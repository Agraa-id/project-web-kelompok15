<?php
final class MotoCareProgram
{
    public function __construct(
        private string $code,
        private string $title,
        private string $description,
        private string $category,
        private string $priority,
        private string $status,
        private int $progress,
        private string $deadline,
        private string $team
    ) {
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getPriority(): string
    {
        return $this->priority;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getProgress(): int
    {
        return max(0, min(100, $this->progress));
    }

    public function getDeadline(): string
    {
        return $this->deadline;
    }

    public function getTeam(): string
    {
        return $this->team;
    }

    public function getStatusClass(): string
    {
        return match ($this->status) {
            'Berjalan' => 'status-running',
            'Perencanaan' => 'status-planned',
            'Selesai' => 'status-complete',
            default => 'status-default',
        };
    }

    public function getPriorityClass(): string
    {
        return match ($this->priority) {
            'Tinggi' => 'priority-high',
            'Sedang' => 'priority-medium',
            'Rendah' => 'priority-low',
            default => 'priority-default',
        };
    }
}
