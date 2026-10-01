<?php
$host   = '192.168.10.24';
$port   = '5432';
$dbname = 'projeto_integrador';
$user   = 'postgres';
$pass   = '1234';

try {
    // Liga à base de dados utilizando o driver correto do PostgreSQL (pgsql)
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // Garante compatibilidade tanto para ficheiros que utilizam $conn como $pdo
    $pdo = $conn;

} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>