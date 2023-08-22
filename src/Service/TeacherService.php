<?php

namespace App\Service;

use AllowDynamicProperties;
use App\Entity\User;
use App\Repository\UserRepository;

#[AllowDynamicProperties]
class TeacherService
{
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function findTeacher(int $id): ?User
    {
        return $this->userRepository->find($id);
    }
    public function findTeachers(string $search): array
    {
        return $this->userRepository->searchTeachers($search);
    }
    public function getTeachersGroupedBySubjects(array $teachers): array
    {
        $subjectsWithTeachers = [];

        foreach ($teachers as $teacher) {
            $subjects = $teacher->getTeachingSubjects();
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