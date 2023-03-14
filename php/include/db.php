<?php
session_start();
try {
    $db = new PDO('mysql:host=localhost;dbname=hospitalps', 'root', '');
} catch (Exception $e) {
    Die('Erreur : ' . $e->getMessage());
}
