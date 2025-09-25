<?php

namespace LMS;

use DateTimeImmutable;
use LMS\Content\Content;
use Student;

class AccessControlService
{
    /** @var Enrolment[] */
    private array $enrolments = [];

    public function addEnrolment(Enrolment $enrolment): void
    {
        $this->enrolments[] = $enrolment;
    }

    private function findEnrolmentFor(Student $student, Course $course): ?Enrolment
    {
        foreach ($this->enrolments as $enrolment) {
            if ($enrolment->getStudent()->getId() === $student->getId() && $enrolment->getCourse() === $course) {
                return $enrolment;
            }
        }
        return null;
    }

    public function canAccess(Student $student, Course $course, Content $content, DateTimeImmutable $at): bool
    {
        $enrolment = $this->findEnrolmentFor($student, $course);
        if ($enrolment === null || !$enrolment->isActiveAt($at)) return false;
        if (!$course->hasStarted($at)) return false;
        return $content->isAvailable($course, $at);
    }
}