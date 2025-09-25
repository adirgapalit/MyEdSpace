<?php

namespace LMS;

use DateTimeImmutable;

class Enrolment
{
    private $student;
    private $course;
    private $startDate;
    private $endDate;

    public function __construct(Student $student, Course $course, DateTimeImmutable $startDate, DateTimeImmutable $endDate)
    {
        $this->student = $student;
        $this->course = $course;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getStudent(): Student { return $this->student; }
    public function getCourse(): Course { return $this->course; }
    public function getStartDate(): DateTimeImmutable { return $this->startDate; }
    public function getEndDate(): DateTimeImmutable { return $this->endDate; }

    public function isActiveAt(DateTimeImmutable $at): bool
    {
        return $at >= $this->startDate && $at <= $this->endDate;
    }

    public function shortenEndDate(DateTimeImmutable $newEndDate): void
    {
        if ($newEndDate < $this->endDate) {
            $this->endDate = $newEndDate;
        }
    }
}