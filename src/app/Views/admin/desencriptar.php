<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desencriptar Datos de Pedido - Admin</title>
    <link rel="stylesheet" href="../public/css/bootstrap.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 50px 0;
        }
        .decrypt-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
        }
        .title {
            color: #667eea;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
        }
        .result-box {
            background: #f8f9fa;
            border-left: 4px solid #28a745;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            font-family: 'Courier New', monospace;
            white-space: pre-wrap;
            word-break: break-all;
        }
        .btn-decrypt {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            color: white;
            width: 100%;
            margin-top: 15px;
        }
        .btn-decrypt:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        .info-box {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        textarea {
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="decrypt-card">
            <h2 class="title">
                🔓 Desencriptador de Datos de Pedidos
            </h2>

            <div class="info-box">
                <strong>ℹ️ Información:</strong><br>
                Los datos del cliente y dirección en los mensajes de WhatsApp están encriptados por seguridad.
                Usa esta herramienta para desencriptarlos.
            </div>

            <form id="decryptForm">
                <div class="form-group">
                    <label for="encryptedData">
                        <strong>Datos Encriptados:</strong>
                    </label>
                    <textarea 
                        class="form-control" 
                        id="encryptedData" 
                        rows="4" 
                        placeholder="Pega aquí el texto encriptado del mensaje de WhatsApp..."
                        required
                    ></textarea>
                    <small class="form-text text-muted">
                        Copia el texto que aparece entre los símbolos ``` en WhatsApp
                    </small>
                </div>

                <button type="submit" class="btn btn-decrypt">
                    🔓 Desencriptar Datos
                </button>
            </form>

            <div id="resultContainer" style="display: none;">
                <h5 class="mt-4 mb-3">
                    <strong>✅ Datos Desencriptados:</strong>
                </h5>
                <div class="result-box" id="decryptedResult"></div>
                
                <button type="button" class="btn btn-success mt-3" onclick="copiarResultado()">
                    📋 Copiar al Portapapeles
                </button>
            </div>

            <div class="mt-5 pt-4 border-top">
                <h5><strong>📚 Guía de Uso:</strong></h5>
                <ol>
                    <li>Abre el mensaje de WhatsApp con el pedido</li>
                    <li>Busca los bloques de texto entre símbolos ``` (backticks)</li>
                    <li>Copia el texto encriptado (la cadena larga de caracteres)</li>
                    <li>Pégalo en el campo de arriba</li>
                    <li>Haz clic en "Desencriptar Datos"</li>
                    <li>Verás la información del cliente o dirección en texto plano</li>
                </ol>

                <div class="alert alert-warning mt-3">
                    <strong>⚠️ Seguridad:</strong> Esta herramienta solo debe ser usada por personal autorizado.
                    No compartas los datos desencriptados con terceros.
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('decryptForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const encryptedData = document.getElementById('encryptedData').value.trim();
            
            if (!encryptedData) {
                alert('Por favor ingresa los datos encriptados');
                return;
            }

            // Enviar petición al servidor para desencriptar
            fetch('api/desencriptar-datos', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'datos=' + encodeURIComponent(encryptedData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('decryptedResult').textContent = data.datos;
                    document.getElementById('resultContainer').style.display = 'block';
                    
                    // Scroll suave al resultado
                    document.getElementById('resultContainer').scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'nearest' 
                    });
                } else {
                    alert('Error al desencriptar: ' + (data.message || 'Datos inválidos'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al procesar la solicitud');
            });
        });

        function copiarResultado() {
            const resultado = document.getElementById('decryptedResult').textContent;
            
            navigator.clipboard.writeText(resultado).then(() => {
                alert('✅ Datos copiados al portapapeles');
            }).catch(err => {
                console.error('Error al copiar:', err);
                alert('❌ No se pudo copiar. Selecciona y copia manualmente.');
            });
        }
    </script>
</body>
</html>
