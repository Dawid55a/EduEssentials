<?php

namespace App\Tests\Entity;

use App\Entity\CourseSubject;
use App\Entity\Subject;
use App\Entity\Teacher;
use App\Entity\Test;
use PHPUnit\Framework\TestCase;

class TeacherTest extends TestCase
{
    public function testCreateTeacher()
    {
        $teacher = new Teacher();
        $this->assertInstanceOf(Teacher::class, $teacher);
    }

    public function testAddAndRemoveTest()
    {
        $teacher = new Teacher();
        $testMock = $this->createMock(Test::class);

        $teacher->addTest($testMock);
        $this->assertCount(1, $teacher->getTests());

        $teacher->removeTest($testMock);
        $this->assertCount(0, $teacher->getTests());
    }

    public function testAddAndRemoveCourseSubject()
    {
        $teacher = new Teacher();
        $courseSubjectMock = $this->createMock(CourseSubject::class);

        $teacher->addCourseSubject($courseSubjectMock);
        $this->assertCount(1, $teacher->getCourseSubjects());

        $teacher->removeCourseSubject($courseSubjectMock);
        $this->assertCount(0, $teacher->getCourseSubjects());
    }

    public function testGetTeachingSubjects()
    {
        $teacher = new Teacher();
        $courseSubjectMock1 = $this->createMock(CourseSubject::class);
        $courseSubjectMock2 = $this->createMock(CourseSubject::class);

        $subject = $this->createMock(Subject::class);

        $courseSubjectMock1->method('getSubject')->willReturn($subject);
        $courseSubjectMock2->method('getSubject')->willReturn($subject);

        $teacher->addCourseSubject($courseSubjectMock1);
        $teacher->addCourseSubject($courseSubjectMock2);

        $this->assertCount(1, $teacher->getTeachingSubjects());
    }
}

