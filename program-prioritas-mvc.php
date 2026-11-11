<?php
declare(strict_types=1);

require_once __DIR__ . '/Database/Database.php';
require_once __DIR__ . '/Controller/ProgramController.php';

try {
    $controller = new ProgramController(new ProgramModel(Database::connect()));
    $controller->index();
} catch (PDOException | InvalidArgumentException $exception) {
    error_log('MotoCare database error: ' . $exception->getMessage());
    http_response_code(503);
    require __DIR__ . '/View/database-error.php';
}
