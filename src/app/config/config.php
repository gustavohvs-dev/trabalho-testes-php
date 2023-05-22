<?php

$systemConfig = [
    "status" => "debug",
    "appName" => "trabalhosTestes",
    "version" => "1.0.0",
    "database" => [
        "server" => "localhost",
        "username" => "root",
        "password" => "",
        "database" => "trabalhotestes"
    ],
    "api" => [
        "token" => "2(#bymk8v27jv@h_uoi]x=k[xcoqf["
    ]
];

//Configuração de banco de dados
$dbConfigServer = $systemConfig["database"]["server"];
$dbConfigDatabase = $systemConfig["database"]["database"];
$dbConfigUsername = $systemConfig["database"]["username"];
$dbConfigPassword = $systemConfig["database"]["password"];

//Conexão
try {
    $conn = new PDO("mysql:host=$dbConfigServer;dbname=$dbConfigDatabase", $dbConfigUsername, $dbConfigPassword);
} catch (PDOException $e) {
    die("Connection Failed: " . $e->getMessage());
}
