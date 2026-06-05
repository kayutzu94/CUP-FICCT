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

        // 1. Obtener Access Token de PayPal
        $response = Http::withBasicAuth($clientId, $clientSecret)
            ->asForm()
            ->post('https://api-m.sandbox.paypal.com/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        if (!$response->successful()) {
            return redirect()->route('postulantes.create')
                ->with('error', 'No se pudo conectar con PayPal. Intente más tarde.');
        }

        $accessToken = $response->json()['access_token'];

        // 2. Crear la orden de pago
        $orderData = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'reference_id' => 'CUP_' . uniqid(),
                'description' => 'Pago de inscripción - Curso Preuniversitario CUP FICCT',
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => '50.00',
                    'breakdown' => [
                        'item_total' => [
                            'currency_code' => 'USD',
                            'value' => '50.00'
                        ]
                    ]
                ],
                'items' => [
                    [
                        'name' => 'Inscripción CUP FICCT',
                        'description' => 'Curso Preuniversitario - Facultad FICCT',
                        'quantity' => '1',
                        'unit_amount' => [
                            'currency_code' => 'USD',
                            'value' => '100.00'
                        ]
                    ]
                ]
            ]],
            'application_context' => [
                'brand_name' => 'CUP FICCT',
                'landing_page' => 'BILLING',
                'user_action' => 'PAY_NOW',
                'return_url' => route('paypal.capture'),
                'cancel_url' => route('paypal.cancel'),
            ]
        ];

        $response = Http::withToken($accessToken)
            ->withHeader('Content-Type', 'application/json')
            ->post('https://api-m.sandbox.paypal.com/v2/checkout/orders', $orderData);

        if (!$response->successful()) {
            return redirect()->route('postulantes.create')
                ->with('error', 'No se pudo crear la orden de pago.');
        }

        $order = $response->json();

        // Buscar el enlace de aprobación (approval_url)
        foreach ($order['links'] as $link) {
            if ($link['rel'] === 'approve') {
                return redirect()->away($link['href']);
            }
        }

        return redirect()->route('postulantes.create')
            ->with('error', 'No se pudo procesar el pago.');
    }

    // Capturar el pago después de que el usuario aprueba
    public function captureOrder(Request $request)
    {
        $token = $request->query('token');
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
                ->with('error', 'Error al confirmar el pago.');
        }

        $accessToken = $response->json()['access_token'];

        // 2. Capturar el pago
        $response = Http::withToken($accessToken)
            ->post("https://api-m.sandbox.paypal.com/v2/checkout/orders/{$token}/capture");

        if ($response->successful()) {
            $data = $response->json();
            
            // Pago exitoso - Aquí puedes guardar la transacción en tu base de datos
            // Guardar el estado del pago en la sesión
            session(['pago_completado' => true, 'transaccion_id' => $data['id']]);
            
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
            ->with('error', 'Cancelaste el proceso de pago. Puedes intentarlo nuevamente.');
    }
}