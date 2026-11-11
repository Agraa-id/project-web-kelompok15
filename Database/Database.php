<?php
declare(strict_types=1);

final class Database
{
    public static function connect(bool $withDatabase = true): PDO
    {
        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $port = getenv('DB_PORT') ?: '3306';
        $database = self::databaseName();
        $dsn = "mysql:host={$host};port={$port};charset=utf8mb4";

        if ($withDatabase) {
            $dsn .= ";dbname={$database}";
        }

        return new PDO(
            $dsn,
            getenv('DB_USER') ?: 'root',
            getenv('DB_PASSWORD') ?: '',
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    }

    public static function databaseName(): string
    {
        $database = getenv('DB_NAME') ?: 'motocare';
        if (preg_match('/\A[a-zA-Z0-9_]+\z/', $database) !== 1) {
            throw new InvalidArgumentException('DB_NAME hanya boleh berisi huruf, angka, dan garis bawah.');
        }

        return $database;
    }
}
