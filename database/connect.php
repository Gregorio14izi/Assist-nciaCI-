<?php
$host     = '192.168.10.24';
$port     = '5432';
$dbname   = 'projeto_integrador'; // Substitua pelo nome do seu banco de dados
$user     = 'postgres';  // Substitua pelo seu usuário do Postgres
$pass = '1234'; // Substitua pela sua senha do Postgres

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    // NOTA: Nunca coloque 'echo' neste ficheiro para não quebrar redirecionamentos
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}