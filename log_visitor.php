<?php
// Récupérer l'adresse IP du visiteur
function getClientIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return trim($ip);
}

$ip = getClientIP();
$timestamp = date('Y-m-d H:i:s');
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

// Format de l'entrée de log
$logEntry = "[$timestamp] IP: $ip | User-Agent: $userAgent\n";

// Chemin du fichier de log (séparé du fichier principal)
$logFile = __DIR__ . '/visitor_logs.txt';

// Enregistrer l'IP dans le fichier
file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);

// Répondre avec succès
http_response_code(200);
echo json_encode(['status' => 'success', 'ip' => $ip]);
?>
