<?php

namespace App\Service;

use AllowDynamicProperties;
use App\Entity\Teacher;
use App\Entity\User;
use App\Repository\CourseSubjectRepository;
use App\Repository\TeacherRepository;
use App\Repository\TestRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\NonUniqueResultException;

#[AllowDynamicProperties]
class TeacherService
{
    public function __construct(UserRepository $userRepository, TestRepository $testRepository, TeacherRepository $teacherRepository, CourseSubjectRepository $courseSubjectRepository)
    {
        $this->userRepository = $userRepository;
        $this->testRepository = $testRepository;
        $this->teacherRepository = $teacherRepository;
        $this->courseSubjectRepository = $courseSubjectRepository;
    }

    public function searchTeachers(string $search): array
    {
        return $this->teacherRepository->searchTeachers($search);
    }

    public function getTeacherById(int $id): ?Teacher
    {
        try {
            return $this->teacherRepository->findTeacherById($id);
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }

    public function getTeachersGroupedBySubjects(array $teachers): array
    {
        $extTeachers = $this->courseSubjectRepository->findTeachersGroupedBySubjectsByIds($teachers);

        $teachersGroupedBySubjects = [];
        foreach ($extTeachers as $extTeacher) {
            if (!isset($teachersGroupedBySubjects[$extTeacher->getSubject()->getName()])) {
                $teachersGroupedBySubjects[$extTeacher->getSubject()->getName()] = [];
            }
            $teachersGroupedBySubjects[$extTeacher->getSubject()->getName()][] = $extTeacher->getTeacher();
        }
        ksort($teachersGroupedBySubjects);
        return $teachersGroupedBySubjects;
    }
}