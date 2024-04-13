<?php

// Récupérer la variable GET
$variable = $_GET["variable"];

// Si la variable n'est pas définie, afficher un message d'erreur
if (!isset($variable)) {
    echo "Erreur : La variable GET 'variable' n'est pas définie.";
    exit;
}

// Remplacer la variable dans l'URL de la page web
$url = "https://api.alldebrid.com/v4/link/unlock?agent=myAppName&apikey=someValidApikeyYouGenerated&link=" . $variable;

// Obtenir le contenu de la page web
$contenu = file_get_contents($url);

// Décoder le contenu JSON
$donnéesJSON = json_decode($contenu, true);

// Vérifier si le décodage JSON a réussi
if ($donnéesJSON === false) {
    echo "Erreur : Le contenu de la page web n'est pas au format JSON.";
    exit;
}

// Définir l'en-tête HTTP pour indiquer le format JSON
header('Content-Type: application/json');

// Encoder les données en JSON et les afficher
echo json_encode($donnéesJSON);
?>
