<?php

// Récupérer la variable GET
$variable = $_GET["lien"];

// Si la variable n'est pas définie, afficher un message d'erreur
if (!isset($variable)) {
    exit;
}

// Remplacer la variable dans l'URL de la page web
$url = "https://api.alldebrid.com/v4/link/unlock?agent=php&apikey=REDACTED_API_KEY&link=" . $variable;

// Obtenir le contenu de la page web
$contenu = file_get_contents($url);


// Déclaration de la fonction pour parser le JSON et extraire le lien
function parse_api_response($api_response) {
  // Décodage du JSON en objet PHP
  $data = json_decode($api_response, true);

  // Vérification du statut de la réponse
  if ($data['status'] === 'success') {
    // Extraction du lien depuis l'objet data
    $lienp = $data['data']['link'];

    // Retour du lien
    return $lienp;
  } else {
    return null;
  }
}

function getUserIP() {
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      return $_SERVER['HTTP_CLIENT_IP'];
  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]; // Prend la première IP si plusieurs sont listées
  } else {
      return $_SERVER['REMOTE_ADDR'];
  }
}

$lienseul = parse_api_response($contenu);
$ip = getUserIP();

$date = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);


// Connexion à la base de données
$host = 'mysql:3306'; // Adresse du serveur MySQL
$dbname = 'debrid'; // Nom de la base de données
$username = 'root'; // Nom d'utilisateur MySQL
$password = 'REDACTED_PASSWORD'; // Mot de passe MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Données à insérer
$date = date('Y-m-d H:i:s'); // Date actuelle
$ip = $ip; // Adresse IP du client
$lien = $lienseul;

// Requête d'insertion
$sql = "INSERT INTO liens (`date`, `ip`, `lien`) VALUES (:date, :ip, :lien)";
$stmt = $pdo->prepare($sql);

// Exécution de la requête avec les valeurs
$stmt->execute([
    ':date' => $date,
    ':ip' => $ip,
    ':lien' => $lien
]);

if ($lienseul) {
  header("Location: $lienseul");
  die();
}


?>
