<?php
declare(strict_types=1);

require_once __DIR__ . '/../Model/ProgramModel.php';

final class ProgramController
{
    public function __construct(private ProgramModel $programModel)
    {
    }

    public function index(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['program_csrf_token'])) {
            $_SESSION['program_csrf_token'] = bin2hex(random_bytes(32));
        }

        $pageTitle = 'Program Prioritas';
        $workspaceName = 'MotoCare';
        $ownerName = 'Kelompok 15';
        $csrfToken = $_SESSION['program_csrf_token'];
        $errorMessage = null;
        $successMessage = null;

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            try {
                $this->handlePost($csrfToken);
            } catch (InvalidArgumentException $exception) {
                $errorMessage = $exception->getMessage();
            }
        }

        $programs = $this->programModel->getAll();
        $programCount = count($programs);
        $latestUpdatedAt = $programs === [] ? null : $programs[0]->getUpdatedAt();
        $successMessages = [
            'created' => 'Program berhasil ditambahkan.',
            'updated' => 'Program berhasil diperbarui.',
            'deleted' => 'Program berhasil dihapus.',
        ];
        $successKey = $_GET['success'] ?? '';
        if (is_string($successKey) && isset($successMessages[$successKey])) {
            $successMessage = $successMessages[$successKey];
        }

        require __DIR__ . '/../View/program-prioritas.php';
    }

    private function handlePost(string $csrfToken): void
    {
        $submittedToken = $this->postString('csrf_token');
        if (!hash_equals($csrfToken, $submittedToken)) {
            throw new InvalidArgumentException('Sesi formulir tidak valid. Muat ulang halaman lalu coba lagi.');
        }

        $action = $this->postString('action');
        if ($action === 'create' || $action === 'update') {
            $name = trim($this->postString('nama'));
            $description = trim($this->postString('deskripsi'));
            $this->validateProgram($name, $description);

            if ($action === 'create') {
                $this->programModel->create($name, $description);
                $this->redirect('created');
            }

            $id = $this->postId();
            if (!$this->programModel->update($id, $name, $description)) {
                throw new InvalidArgumentException('Program yang ingin diperbarui tidak ditemukan.');
            }

            $this->redirect('updated');
        }

        if ($action === 'delete') {
            if (!$this->programModel->delete($this->postId())) {
                throw new InvalidArgumentException('Program yang ingin dihapus tidak ditemukan.');
            }

            $this->redirect('deleted');
        }

        throw new InvalidArgumentException('Aksi program tidak dikenali.');
    }

    private function validateProgram(string $name, string $description): void
    {
        if ($name === '' || mb_strlen($name) > 120) {
            throw new InvalidArgumentException('Nama program wajib diisi dan maksimal 120 karakter.');
        }

        if ($description === '' || mb_strlen($description) > 2000) {
            throw new InvalidArgumentException('Deskripsi program wajib diisi dan maksimal 2.000 karakter.');
        }
    }

    private function postId(): int
    {
        $value = $_POST['id'] ?? null;
        if (!is_string($value) && !is_int($value)) {
            throw new InvalidArgumentException('ID program tidak valid.');
        }

        $id = filter_var($value, FILTER_VALIDATE_INT);
        if ($id === false || $id === null || $id < 1) {
            throw new InvalidArgumentException('ID program tidak valid.');
        }

        return $id;
    }

    private function postString(string $key): string
    {
        $value = $_POST[$key] ?? '';

        return is_string($value) ? $value : '';
    }

    private function redirect(string $success): never
    {
        $path = $_SERVER['SCRIPT_NAME'] ?? '/program-prioritas-mvc.php';
        header('Location: ' . $path . '?success=' . rawurlencode($success), true, 303);
        exit;
    }
}
