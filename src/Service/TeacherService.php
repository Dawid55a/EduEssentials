<?php

namespace App\Service;

use AllowDynamicProperties;
use App\Entity\User;
use App\Repository\TeacherRepository;
use App\Repository\TestRepository;
use App\Repository\UserRepository;

#[AllowDynamicProperties]
class TeacherService
{
    public function __construct(UserRepository $userRepository, TestRepository $testRepository, TeacherRepository $teacherRepository)
    {
        $this->userRepository = $userRepository;
        $this->testRepository = $testRepository;
        $this->teacherRepository = $teacherRepository;
    }

    public function searchTeachers(string $search): array
    {
        return $this->teacherRepository->searchTeachers($search);
    }

    public function getTeachersGroupedBySubjects(array $teachers): array
    {
        $extTeachers = $this->teacherRepository->searchTeachersInfoGroupedBySubject($teachers);

        $subjectsWithTeachers = [];

        foreach ($extTeachers as $teacher) {
            $subjects = $teacher->getSubjects();
            foreach ($subjects as $subject) {
                $subjectName = $subject->getName(); // Assuming subject has a getName() method
                if (!isset($subjectsWithTeachers[$subjectName])) {
                    $subjectsWithTeachers[$subjectName] = [];
                }
                $subjectsWithTeachers[$subjectName][] = $teacher;
            }
        }
        return $subjectsWithTeachers;
    }
}