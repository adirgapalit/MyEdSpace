<?php

namespace LMS;

use DateTimeImmutable;
use LMS\Content\Content;

class Course
{
    private $id;
    private $title;
    private $startDate;
    private $endDate;
    /** @var Content[] */
    private $contents = [];

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

    public function hasStarted(DateTimeImmutable $at): bool
    {
        return $at >= $this->startDate;
    }
}