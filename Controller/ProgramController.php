<?php
require_once __DIR__ . '/../Model/ProgramModel.php';

final class ProgramController
{
    public function __construct(private ProgramModel $programModel)
    {
    }

    public function index(): void
    {
        $pageTitle = 'Program Prioritas';
        $workspaceName = 'MotoCare';
        $ownerName = 'Kelompok 15';
        $periodLabel = 'Oktober 2026';
        $programs = $this->programModel->getAll();
        $programCount = count($programs);
        $runningCount = count(array_filter(
            $programs,
            static fn (MotoCareProgram $program): bool => $program->getStatus() === 'Berjalan'
        ));
        $completedCount = count(array_filter(
            $programs,
            static fn (MotoCareProgram $program): bool => $program->getStatus() === 'Selesai'
        ));

        require __DIR__ . '/../View/program-prioritas.php';
    }
}
