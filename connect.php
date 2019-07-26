<?php

function connectDb() {
    $dbhost = 'localhost';
    $dbname = 'hospitalE2N';
    $dbuser = 'belal';
    $dbpassword = 'Belaal789789';

    try {
        $connect_db = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $dbuser, $dbpassword, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        return $connect_db;
    } catch (Exception $e) {
        die($e->getMessage());
    }
}
