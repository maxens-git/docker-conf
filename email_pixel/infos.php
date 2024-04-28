<?php

//THIS RETURNS THE IMAGE
header('Content-Type: image/gif');
readfile('tracking.gif');

$adresse = $_GET["adresse"];

//THIS IS THE SCRIPT FOR THE ACTUAL TRACKING
$date = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
$txt = $date.",". $_SERVER['REMOTE_ADDR'];
$myfile = file_put_contents('log.txt', $txt.PHP_EOL , FILE_APPEND);



// URL of the target server
$url = "https://ntfy.maxens.org/Raspberry";

// Data to send in the POST request (replace with your actual data)
$data = array(
  'content' => $txt . " " . $adresse
);

// Headers to include in the request (replace with your specific headers)
$headers = array(
  'Content-Type: application/json', // Example header for JSON data
  'Authorization: Bearer REDACTED_TOKEN', // Example authorization header
);

// Initialize a new cURL resource
$ch = curl_init($url);

// Set request method to POST
curl_setopt($ch, CURLOPT_POST, true);

// Set POST data
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Assuming JSON data

// Set headers
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Return the transfer as a string instead of outputting it directly
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Verify SSL certificate (optional, adjust based on your server's setup)
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

// Execute the request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
  echo 'Error: ' . curl_error($ch);
} else {
  // Process the response
  echo $response;
}

// Close the cURL resource
curl_close($ch);




exit;

?>
