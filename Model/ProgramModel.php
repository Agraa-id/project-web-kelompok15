<?php
declare(strict_types=1);

require_once __DIR__ . '/MotoCareProgram.php';

final class ProgramModel
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    /**
     * @return list<MotoCareProgram>
     */
    public function getAll(): array
    {
        $statement = $this->pdo->query(
            'SELECT id, nama, deskripsi, created_at, updated_at
             FROM programs
             ORDER BY updated_at DESC, id DESC'
        );

        return array_map(
            static fn (array $row): MotoCareProgram => new MotoCareProgram(
                (int) $row['id'],
                $row['nama'],
                $row['deskripsi'],
                $row['created_at'],
                $row['updated_at'],
            ),
            $statement->fetchAll()
        );
    }

    public function create(string $name, string $description): void
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO programs (nama, deskripsi) VALUES (:nama, :deskripsi)'
        );
        $statement->execute(['nama' => $name, 'deskripsi' => $description]);
    }

    public function update(int $id, string $name, string $description): bool
    {
        $statement = $this->pdo->prepare(
            'UPDATE programs
             SET nama = :nama, deskripsi = :deskripsi, updated_at = CURRENT_TIMESTAMP
             WHERE id = :id'
        );
        $statement->execute(['id' => $id, 'nama' => $name, 'deskripsi' => $description]);

        return $statement->rowCount() > 0 || $this->exists($id);
    }

    public function delete(int $id): bool
    {
        $statement = $this->pdo->prepare('DELETE FROM programs WHERE id = :id');
        $statement->execute(['id' => $id]);

        return $statement->rowCount() > 0;
    }

    private function exists(int $id): bool
    {
        $statement = $this->pdo->prepare('SELECT 1 FROM programs WHERE id = :id');
        $statement->execute(['id' => $id]);

        return $statement->fetchColumn() !== false;
    }
}
