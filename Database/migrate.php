<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require_once __DIR__ . '/Database.php';

$server = Database::connect(false);
$databaseName = Database::databaseName();
$server->exec("CREATE DATABASE IF NOT EXISTS `{$databaseName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

$pdo = Database::connect();
$migrationPath = __DIR__ . '/migrations/001_create_programs_table.sql';
$migration = file_get_contents($migrationPath);

if ($migration === false) {
    throw new RuntimeException('File migration tidak dapat dibaca: ' . $migrationPath);
}

$pdo->exec($migration);
fwrite(STDOUT, "Database {$databaseName} dan tabel programs siap digunakan.\n");
