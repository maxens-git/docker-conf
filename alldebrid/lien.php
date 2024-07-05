<?php

// Récupérer la variable GET
$variable = $_GET["lien"];

// Si la variable n'est pas définie, afficher un message d'erreur
if (!isset($variable)) {
    exit;
}

// Remplacer la variable dans l'URL de la page web
$url = "https://api.alldebrid.com/v4/link/unlock?agent=php&apikey=APIKEY&link=" . $variable;

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

$lienseul = parse_api_response($contenu);


$date = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
$vartxt = $date." , ". $lienseul;
$myfile = file_put_contents('liens.txt', $vartxt.PHP_EOL , FILE_APPEND);

if ($lienseul) {
  header("Location: $lienseul");
  die();
}

?>
