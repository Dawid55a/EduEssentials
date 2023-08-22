<?php

namespace App\Service;

use AllowDynamicProperties;
use App\Repository\UserRepository;

#[AllowDynamicProperties] class StudentService
{
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getStudents(): array
    {
        return $this->userRepository->getStudents();
    }

    public function getStudentsWithGrades(array $students)
    {
        $studentsWithGrades = [];

        foreach ($students as $student) {
            $studentsWithGrades[$student] = $student->getGrades()->toArray();
        }
        return $studentsWithGrades;
    }
}