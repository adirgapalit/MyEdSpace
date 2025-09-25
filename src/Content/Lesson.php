<?php

namespace LMS\Content;

use DateTimeImmutable;
use LMS\Course;

class Lesson extends Content
{
    private $scheduledAt;

    public function __construct(string $id, string $title, DateTimeImmutable $scheduledAt)
    {
        parent::__construct($id, $title);
        $this->scheduledAt = $scheduledAt;
    }

    public function isAvailable(Course $course, DateTimeImmutable $at): bool
    {
        return $at >= $this->scheduledAt;
    }
}