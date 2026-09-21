<?php

// Connexion à la base de données
$host = 'mysql:3306';
$dbname = 'debrid';
$username = 'root';
$password = getenv('DB_PASSWORD');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupération et validation du paramètre GET 'lien'
if (!isset($_GET['lien']) || !filter_var($_GET['lien'], FILTER_VALIDATE_URL)) {
    exit('Paramètre "lien" invalide ou manquant.');
}

$linkToUnlock = $_GET['lien'];
$apikey = getenv('ALLDEBRID_API_KEY');
$apiUrl = "https://api.alldebrid.com/v4/link/unlock?agent=php&apikey=$apikey&link=" . urlencode($linkToUnlock);

$contenu = @file_get_contents($apiUrl);
if ($contenu === false) {
    exit('Erreur lors de la récupération du contenu.');
}

// Fonction utilitaire pour parser les champs
function parse_json_field($json, $field) {
    $data = json_decode($json, true);
    return ($data['status'] ?? '') === 'success' && isset($data['data'][$field]) ? $data['data'][$field] : null;
}
function parse_size_in_go($json) {
    $size = parse_json_field($json, 'filesize');
    return is_numeric($size) ? round($size / 1073741824, 2) : null;
}

$lienseul = parse_json_field($contenu, 'link');
$nomfichier = parse_json_field($contenu, 'filename');
$taille = parse_size_in_go($contenu);
$ip = $_SERVER['HTTP_CLIENT_IP'] ?? explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
$date = date('Y-m-d H:i:s');

if ($lienseul && filter_var($lienseul, FILTER_VALIDATE_URL)) {
    $stmt = $pdo->prepare("INSERT INTO liens (`date`, `ip`, `nom`, `lien`, `taille`, `user-agent`, `lien-base`) VALUES (:date, :ip, :nom, :lien, :taille, :user_agent, :lien_base)");
    $stmt->execute([
        ':date' => $date,
        ':ip' => $ip,
        ':nom' => $nomfichier ?? 'Inconnu',
        ':lien' => $lienseul,
        ':taille' => $taille,
        ':user_agent' => $user_agent,
	':lien_base' => $linkToUnlock
    ]);

    header("Location: $lienseul");
    exit;
} else {
    exit('Lien invalide ou indisponible.');
}
?>
