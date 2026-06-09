<div class="voice-assistant" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;">
    <button id="voiceBtn" class="btn btn-primary rounded-circle shadow-lg" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
        <i class="fas fa-microphone fa-2x"></i>
    </button>
    
    <div id="voiceModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-microphone-alt"></i> Asistente por Voz - CUP FICCT</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mic-icon mb-3">
                        <i id="micIcon" class="fas fa-microphone-alt fa-4x text-primary"></i>
                    </div>
                    <p id="voiceStatus" class="text-muted">Haz clic en el micrófono y habla</p>
                    <div id="voiceResult" class="mt-3"></div>
                    <div class="alert alert-info mt-3">
                        <strong>🎯 Comandos soportados:</strong><br>
                        <small>"mostrar aprobados" - "mostrar reprobados" - "ver grupos"</small><br>
                        <small>"exportar excel" - "exportar pdf" - "ver estadísticas"</small><br>
                        <small>"promedios generales" - "docentes por grupos" - "dashboard"</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.2); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }
    .pulse-animation {
        animation: pulse 1.5s infinite;
        color: #dc3545 !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const voiceBtn = document.getElementById('voiceBtn');
    const voiceModalEl = document.getElementById('voiceModal');
    const voiceModal = new bootstrap.Modal(voiceModalEl);
    const voiceResult = document.getElementById('voiceResult');
    const voiceStatus = document.getElementById('voiceStatus');
    const micIcon = document.getElementById('micIcon');
    
    let recognition = null;
    let isListening = false;
    
    // Verificar soporte del navegador
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    
    if (!SpeechRecognition) {
        voiceBtn.disabled = true;
        voiceBtn.title = "Tu navegador no soporta reconocimiento de voz";
        voiceStatus.textContent = "❌ Navegador no compatible. Usa Chrome o Edge.";
        return;
    }
    
    // Inicializar reconocimiento
    recognition = new SpeechRecognition();
    recognition.lang = 'es-ES';
    recognition.continuous = false;
    recognition.interimResults = false;
    recognition.maxAlternatives = 1;
    
    recognition.onstart = function() {
        isListening = true;
        voiceStatus.textContent = "🎤 Escuchando... habla ahora";
        micIcon.classList.add('pulse-animation');
        voiceResult.innerHTML = '<div class="spinner-border text-primary" role="status"></div>';
    };
    
    recognition.onend = function() {
        isListening = false;
        micIcon.classList.remove('pulse-animation');
        if (voiceStatus.textContent !== "Haz clic en el micrófono y habla") {
            voiceStatus.textContent = "Haz clic en el micrófono y habla";
        }
    };
    
    recognition.onresult = function(event) {
        const command = event.results[0][0].transcript.toLowerCase();
        voiceResult.innerHTML = `<p><strong>Dijiste:</strong> "${command}"</p><div class="spinner-border text-success" role="status"></div><p>Procesando...</p>`;
        
        fetch('/voice-command', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ command: command })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                voiceResult.innerHTML = `<div class="alert alert-success">✅ ${data.message}</div>`;
                setTimeout(() => {
                    voiceModal.hide();
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                }, 1500);
            } else {
                voiceResult.innerHTML = `<div class="alert alert-danger">❌ ${data.message}</div>`;
                setTimeout(() => {
                    voiceResult.innerHTML = '';
                }, 3000);
            }
        })
        .catch(error => {
            voiceResult.innerHTML = '<div class="alert alert-danger">Error al procesar el comando</div>';
            setTimeout(() => {
                voiceResult.innerHTML = '';
            }, 3000);
        });
    };
    
    recognition.onerror = function(event) {
        console.error('Speech recognition error:', event.error);
        let errorMsg = "Error al reconocer la voz";
        
        switch(event.error) {
            case 'not-allowed':
                errorMsg = "❌ Permiso denegado. Permite el acceso al micrófono.";
                break;
            case 'no-speech':
                errorMsg = "No se detectó voz. Intenta nuevamente.";
                break;
            case 'network':
                errorMsg = "Error de red. Verifica tu conexión.";
                break;
            default:
                errorMsg = `Error: ${event.error}`;
        }
        
        voiceResult.innerHTML = `<div class="alert alert-warning">${errorMsg}</div>`;
        setTimeout(() => {
            voiceResult.innerHTML = '';
        }, 3000);
    };
    
    voiceBtn.addEventListener('click', function() {
        voiceModal.show();
        voiceResult.innerHTML = '';
        voiceStatus.textContent = "Haz clic en el micrófono y habla";
        
        // Solicitar permisos de micrófono al hacer clic
        navigator.mediaDevices.getUserMedia({ audio: true })
            .then(function(stream) {
                stream.getTracks().forEach(track => track.stop());
                voiceStatus.textContent = "✅ Micrófono listo. Haz clic en el ícono para hablar.";
            })
            .catch(function(err) {
                voiceStatus.textContent = "❌ No se pudo acceder al micrófono. Permite el acceso.";
                console.error("Error de micrófono:", err);
            });
    });
    
    // Al abrir el modal, iniciar reconocimiento
    voiceModalEl.addEventListener('shown.bs.modal', function() {
        if (recognition && !isListening) {
            try {
                recognition.start();
            } catch(e) {
                console.log("Error starting recognition:", e);
            }
        }
    });
});
</script>