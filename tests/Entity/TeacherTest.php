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
        $this->assertInstanceOf(Teacher::class, $teacher, 'The created object is not the same as the expected one');
    }

    public function testAddAndRemoveTest()
    {
        $teacher = new Teacher();
        $testMock = $this->createMock(Test::class);

        $teacher->addTest($testMock);
        $this->assertCount(1, $teacher->getTests(), 'The test was not added to the teacher');

        $teacher->removeTest($testMock);
        $this->assertCount(0, $teacher->getTests(), 'The test was not removed from the teacher');
    }

    public function testAddAndRemoveCourseSubject()
    {
        $teacher = new Teacher();
        $courseSubjectMock = $this->createMock(CourseSubject::class);

        $teacher->addCourseSubject($courseSubjectMock);
        $this->assertCount(1, $teacher->getCourseSubjects(), 'The course subject was not added to the teacher');

        $teacher->removeCourseSubject($courseSubjectMock);
        $this->assertCount(0, $teacher->getCourseSubjects(), 'The course subject was not removed from the teacher');
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

        $this->assertCount(1, $teacher->getTeachingSubjects(), 'The teacher is teaching more than one subject');
    }
}

