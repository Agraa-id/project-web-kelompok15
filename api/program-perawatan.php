<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

session_start();

function respond(int $statusCode, array $payload): void
{
    http_response_code($statusCode);
    echo json_encode($payload, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    exit;
}

function readJsonBody(): array
{
    try {
        $body = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException) {
        respond(400, ['message' => 'Format JSON tidak valid.']);
    }

    if (!is_array($body)) {
        respond(400, ['message' => 'Data JSON harus berupa object.']);
    }

    return $body;
}

if (!isset($_SESSION['maintenance_tasks'])) {
    $_SESSION['maintenance_tasks'] = [
        [
            'id' => 'oil-change',
            'title' => 'Ganti oli mesin',
            'description' => 'Jaga pelumasan mesin agar performa tetap halus dan suhu terkontrol.',
            'interval' => 'Setiap 2.000 km atau 2 bulan',
            'status' => 'segera',
            'completed' => false,
        ],
        [
            'id' => 'brakes',
            'title' => 'Periksa sistem pengereman',
            'description' => 'Pastikan kampas, tuas, dan minyak rem bekerja dengan baik.',
            'interval' => 'Setiap 4.000 km',
            'status' => 'terjadwal',
            'completed' => false,
        ],
        [
            'id' => 'tires',
            'title' => 'Cek tekanan dan kondisi ban',
            'description' => 'Periksa tekanan angin serta alur ban untuk menjaga traksi.',
            'interval' => 'Setiap 1.000 km',
            'status' => 'rutin',
            'completed' => false,
        ],
        [
            'id' => 'chain',
            'title' => 'Bersihkan dan lumasi rantai',
            'description' => 'Bersihkan rantai dari kotoran dan atur kekencangannya.',
            'interval' => 'Setiap 500 km',
            'status' => 'rutin',
            'completed' => false,
        ],
        [
            'id' => 'battery',
            'title' => 'Periksa aki dan lampu',
            'description' => 'Cek tegangan aki, lampu utama, sein, dan lampu rem.',
            'interval' => 'Setiap 3 bulan',
            'status' => 'terjadwal',
            'completed' => false,
        ],
        [
            'id' => 'air-filter',
            'title' => 'Servis filter udara',
            'description' => 'Bersihkan filter udara agar aliran udara mesin tetap optimal.',
            'interval' => 'Setiap 8.000 km',
            'status' => 'rutin',
            'completed' => false,
        ],
    ];
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$tasks = &$_SESSION['maintenance_tasks'];

if ($method === 'GET') {
    respond(200, ['data' => array_values($tasks)]);
}

if ($method === 'POST') {
    $body = readJsonBody();
    $title = isset($body['title']) && is_string($body['title']) ? trim($body['title']) : '';
    $description = isset($body['description']) && is_string($body['description'])
        ? trim($body['description'])
        : '';

    if ($title === '' || strlen($title) > 480 || preg_match('/^.{1,120}$/us', $title) !== 1) {
        respond(422, ['message' => 'Nama perawatan wajib diisi (maksimal 120 karakter).']);
    }

    if (strlen($description) > 2000 || preg_match('/^.{0,500}$/us', $description) !== 1) {
        respond(422, ['message' => 'Catatan maksimal 500 karakter.']);
    }

    $task = [
        'id' => bin2hex(random_bytes(8)),
        'title' => $title,
        'description' => $description,
        'interval' => 'Atur sesuai kebutuhan',
        'status' => 'rutin',
        'completed' => false,
    ];
    $tasks[] = $task;

    respond(201, ['data' => $task]);
}

if ($method === 'PATCH') {
    $body = readJsonBody();
    $taskId = isset($body['id']) && is_string($body['id']) ? $body['id'] : '';

    if ($taskId === '' || !isset($body['completed']) || !is_bool($body['completed'])) {
        respond(422, ['message' => 'ID dan status selesai harus diisi dengan format yang benar.']);
    }

    foreach ($tasks as &$task) {
        if ($task['id'] === $taskId) {
            $task['completed'] = $body['completed'];
            $updatedTask = $task;
            unset($task);
            respond(200, ['data' => $updatedTask]);
        }
    }
    unset($task);

    respond(404, ['message' => 'Program perawatan tidak ditemukan.']);
}

header('Allow: GET, POST, PATCH');
respond(405, ['message' => 'Metode request tidak didukung.']);
