<?php
// src/app/Services/WebhookService.php

class WebhookService
{
    private $webhookUrl;

    public function __construct($webhookUrl)
    {
        $this->webhookUrl = trim($webhookUrl); // ✅ Eliminar espacios en blanco
    }

    public function send($data, $user = null)
    {
        if (!$this->webhookUrl) {
            error_log("Webhook URL no configurada");
            return false;
        }

        // ✅ Crear payload con la estructura que deseas
        $payload = [
            'timestamp' => date('Y-m-d H:i:s'),
            'user' => $user, // ✅ Información del usuario
            'data' => $data
        ];

        $payloadJson = json_encode($payload);

        $ch = curl_init($this->webhookUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payloadJson)
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadJson);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // ✅ Añadir timeout
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // ✅ Opcional: deshabilitar verificación SSL

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        curl_close($ch);

        if ($error) {
            error_log("Error en webhook: " . $error);
            return false;
        }

        if ($httpCode !== 200) {
            error_log("Webhook respondió con código: " . $httpCode);
        }

        return $response;
    }
}