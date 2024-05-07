<?php

session_start();
$db = new PDO('mysql:host=localhost;dbname=andrey.lozovoy.todoapp', 'root', '');

$query = $db->query('SELECT * FROM users');

function d($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

function redirect($url)
{
    header('Location: ' . $url);
    exit;
}