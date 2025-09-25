<?php

namespace Tests;

use DateTimeImmutable;
use LMS\AccessControlService;
use LMS\Content\Homework;
use LMS\Content\Lesson;
use LMS\Content\PrepMaterial;
use LMS\Course;
use LMS\Enrolment;
use LMS\Student;
use PHPUnit\Framework\TestCase;

class AccessControlServiceTest extends TestCase
{
//    protected Student $emma;
//    protected Course $biology;
//    protected Enrolment $enrolment;
//    protected AccessControlService $acs;

    protected function setUp(): void
    {
        $this->emma = new Student('s1', 'Emma');

        $courseStart = new DateTimeImmutable('2025-05-13');
        $courseEnd = new DateTimeImmutable('2025-06-12');
        $this->biology = new Course('c1', 'A-Level Biology', $courseStart, $courseEnd);

        $lesson = new Lesson('l1', 'Cell Structure', new DateTimeImmutable('2025-05-15 10:00'));
        $homework = new Homework('h1', 'Label a Plant Cell');
        $prep = new PrepMaterial('p1', 'Biology Reading Guide');

        $this->biology->addContent($lesson);
        $this->biology->addContent($homework);
        $this->biology->addContent($prep);

        $enrolStart = new DateTimeImmutable('2025-05-01');
        $enrolEnd = new DateTimeImmutable('2025-05-30');
        $this->enrolment = new Enrolment($this->emma, $this->biology, $enrolStart, $enrolEnd);

        $this->acs = new AccessControlService();
        $this->acs->addEnrolment($this->enrolment);
    }

    public function testPrepBeforeCourseStartDenied()
    {
        $at = new DateTimeImmutable('2025-05-01');
        $prep = $this->findContentById('p1');
        $this->assertFalse($this->acs->canAccess($this->emma, $this->biology, $prep, $at));
    }

    public function testPrepOnCourseStartAllowed()
    {
        $at = new DateTimeImmutable('2025-05-13');
        $prep = $this->findContentById('p1');
        $this->assertTrue($this->acs->canAccess($this->emma, $this->biology, $prep, $at));
    }

    public function testLessonAfterScheduledAllowed()
    {
        $at = new DateTimeImmutable('2025-05-15 10:01');
        $lesson = $this->findContentById('l1');
        $this->assertTrue($this->acs->canAccess($this->emma, $this->biology, $lesson, $at));
    }

    public function testAccessAfterEnrolmentShortenedDenied()
    {
        $this->enrolment->shortenEndDate(new DateTimeImmutable('2025-05-20'));
        $at = new DateTimeImmutable('2025-05-21');
        $homework = $this->findContentById('h1');
        $this->assertFalse($this->acs->canAccess($this->emma, $this->biology, $homework, $at));
    }

    public function testAccessCourseRunningButNotEnrolledDenied()
    {
        $at = new DateTimeImmutable('2025-06-10');
        $prep = $this->findContentById('p1');
        $this->assertFalse($this->acs->canAccess($this->emma, $this->biology, $prep, $at));
    }

    // Helper
    private function findContentById(string $id)
    {
        foreach ($this->biology->getContents() as $c) {
            if ($c->getId() === $id) return $c;
        }
        throw new \RuntimeException('Content not found: ' . $id);
    }
}
