<?php

namespace LMS\Content;

use DateTimeImmutable;
use LMS\Course;

abstract class Content
{
    protected string $id;
    protected string $title;

    public function __construct(string $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    abstract public function isAvailable(Course $course, DateTimeImmutable $at): bool;
}
