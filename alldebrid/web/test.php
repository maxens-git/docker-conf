<?php
// L'URL du fichier XML
$url = "http://webservices-v2.crous-mobile.fr:8080/feed/toulouse/externe/menu.xml";

// Charger le contenu XML depuis l'URL
$xmlContent = file_get_contents($url);

if ($xmlContent === false) {
    die("Erreur lors du chargement du fichier XML");
}

// Convertir le contenu en objet SimpleXML
$xml = simplexml_load_string($xmlContent);

if ($xml === false) {
    die("Erreur lors de l'analyse du fichier XML");
}

// Trouver le restaurant avec l'ID "r662"
$resto = null;
foreach ($xml->resto as $r) {
    if ((string)$r['id'] === 'r662') {
        $resto = $r;
        break;
    }
}

if ($resto === null) {
    die("Restaurant avec l'ID r662 non trouvé.");
}

// Parcourir les menus du restaurant
foreach ($resto->menu as $menu) {
    // Convertir l'élément SimpleXML en un document DOM
    $dom = dom_import_simplexml($menu)->ownerDocument;
    
    // Afficher le code HTML entre les balises <menu>
    echo $dom->saveHTML($menu);
}
?>
