<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PayPalController extends Controller
{
    // Crear orden de pago y redirigir a PayPal
    public function createOrder()
    {
        $clientId = env('PAYPAL_CLIENT_ID');
        $clientSecret = env('PAYPAL_CLIENT_SECRET');

        // 1. Obtener Access Token
        $response = Http::withBasicAuth($clientId, $clientSecret)
            ->asForm()
            ->post('https://api-m.sandbox.paypal.com/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        if (!$response->successful()) {
            return redirect()->route('postulantes.create')
                ->with('error', 'No se pudo conectar con PayPal. Error: ' . $response->body());
        }

        $accessToken = $response->json()['access_token'];

        // 2. Crear la orden de pago (más simple para pruebas)
        $orderData = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => '100.00',
                    ],
                ],
            ],
            'application_context' => [
                'return_url' => route('paypal.capture'),
                'cancel_url' => route('paypal.cancel'),
            ],
        ];

        $response = Http::withToken($accessToken)
            ->withHeader('Content-Type', 'application/json')
            ->post('https://api-m.sandbox.paypal.com/v2/checkout/orders', $orderData);

        if (!$response->successful()) {
            return redirect()->route('postulantes.create')
                ->with('error', 'No se pudo crear la orden. Error: ' . $response->body());
        }

        $order = $response->json();

        // Buscar el enlace de aprobación
        foreach ($order['links'] as $link) {
            if ($link['rel'] === 'approve') {
                return redirect()->away($link['href']);
            }
        }

        return redirect()->route('postulantes.create')
            ->with('error', 'No se encontró enlace de aprobación en PayPal.');
    }

    // Capturar el pago después de que el usuario aprueba
    public function captureOrder(Request $request)
    {
        $token = $request->query('token');
        $clientId = env('PAYPAL_CLIENT_ID');
        $clientSecret = env('PAYPAL_CLIENT_SECRET');

        // Obtener Access Token
        $response = Http::withBasicAuth($clientId, $clientSecret)
            ->asForm()
            ->post('https://api-m.sandbox.paypal.com/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        if (!$response->successful()) {
            return redirect()->route('postulantes.create')
                ->with('error', 'Error al confirmar el pago.');
        }

        $accessToken = $response->json()['access_token'];

        // Capturar el pago
        $response = Http::withToken($accessToken)
            ->post("https://api-m.sandbox.paypal.com/v2/checkout/orders/{$token}/capture");

        if ($response->successful()) {
            session(['pago_completado' => true]);
            return redirect()->route('postulantes.create')
                ->with('success', '¡Pago completado exitosamente! Ahora puedes registrar al postulante.');
        }

        return redirect()->route('postulantes.create')
            ->with('error', 'El pago no pudo ser completado.');
    }

    // Cancelar pago
    public function cancelOrder()
    {
        return redirect()->route('postulantes.create')
            ->with('error', 'Cancelaste el proceso de pago.');
    }
}