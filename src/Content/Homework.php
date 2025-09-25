<?php

namespace LMS\Content;

use DateTimeImmutable;
use LMS\Course;

class Homework extends Content
{
    public function isAvailable(Course $course, DateTimeImmutable $at): bool
    {
        return $at >= $course->getStartDate();
    }
}
