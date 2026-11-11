<?php
final class MotoCareProgram
{
    public function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly string $description,
        private readonly string $createdAt,
        private readonly string $updatedAt,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }
}
