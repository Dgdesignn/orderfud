<?php
require "../controllers/clientController.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$cliente = new ClientController();
$response = ['logged_in' => $cliente->isLoggedIn()];

header('Content-Type: application/json');
echo json_encode($response); 