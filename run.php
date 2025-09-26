<?php
require __DIR__ . '/vendor/autoload.php';

use LMS\Student;
use LMS\Course;
use LMS\Enrolment;
use LMS\AccessControlService;
use LMS\Content\Lesson;
use LMS\Content\Homework;
use LMS\Content\PrepMaterial;

//set some data for running
$emma = new Student('s1', 'Emma');

$courseStart = new DateTimeImmutable('2025-05-13');
$courseEnd   = new DateTimeImmutable('2025-06-12');
$biology = new Course('c1', 'A-Level Biology', $courseStart, $courseEnd);

$lesson   = new Lesson('l1', 'Cell Structure', new DateTimeImmutable('2025-05-15 10:00'));
$homework = new Homework('h1', 'Label a Plant Cell');
$prep     = new PrepMaterial('p1', 'Biology Reading Guide');

$biology->addContent($lesson);
$biology->addContent($homework);
$biology->addContent($prep);

$enrolStart = new DateTimeImmutable('2025-05-01');
$enrolEnd   = new DateTimeImmutable('2025-05-30');
$enrolment  = new Enrolment($emma, $biology, $enrolStart, $enrolEnd);

$acs = new AccessControlService();
$acs->addEnrolment($enrolment);

function checkAccess(AccessControlService $acs, Student $student, Course $course, $content, DateTimeImmutable $at) {
    echo "At " . $at->format('Y-m-d H:i') . " → ";
    echo $acs->canAccess($student, $course, $content, $at) ? "Allowed\n" : "Denied\n";
}

echo "=== MyEdSpace’s LMS Demo ===\n";

checkAccess($acs, $emma, $biology, $prep, new DateTimeImmutable('2025-05-01'));

checkAccess($acs, $emma, $biology, $prep, new DateTimeImmutable('2025-05-13'));

checkAccess($acs, $emma, $biology, $lesson, new DateTimeImmutable('2025-05-15 10:01'));

$enrolment->shortenEndDate(new DateTimeImmutable('2025-05-20'));
checkAccess($acs, $emma, $biology, $homework, new DateTimeImmutable('2025-05-21'));

checkAccess($acs, $emma, $biology, $prep, new DateTimeImmutable('2025-06-10'));
