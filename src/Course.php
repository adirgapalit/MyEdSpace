<?php

namespace LMS;

use DateTimeImmutable;
use LMS\Content\Content;

class Course
{
    private string $id;
    private string $title;
    private DateTimeImmutable $startDate;
    private?DateTimeImmutable $endDate;
    /** @var Content[] */
    private array $contents = [];

    public function __construct(string $id, string $title, DateTimeImmutable $startDate, ?DateTimeImmutable $endDate = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function addContent(Content $content): void
    {
        $this->contents[] = $content;
    }

    public function getContents(): array
    {
        return $this->contents;
    }

    public function getStartDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getEndDate(): ?DateTimeImmutable
    {
        return $this->endDate;
    }

    public function hasStarted(DateTimeImmutable $at): bool
    {
        return $at >= $this->startDate;
    }

    public function isRunning(DateTimeImmutable $at): bool
    {
        if ($at < $this->startDate) return false;
        if ($this->endDate !== null && $at > $this->endDate) return false;
        return true;
    }
}