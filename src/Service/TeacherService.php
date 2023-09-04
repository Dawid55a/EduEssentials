<?php

namespace App\Service;

use AllowDynamicProperties;
use App\Entity\Teacher;
use App\Repository\CourseSubjectRepository;
use App\Repository\GradeRepository;
use App\Repository\StudentRepository;
use App\Repository\TeacherRepository;
use App\Repository\TestRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\NonUniqueResultException;

#[AllowDynamicProperties]
class TeacherService
{

    public function __construct(
        UserRepository          $userRepository,
        TestRepository          $testRepository,
        TeacherRepository       $teacherRepository,
        CourseSubjectRepository $courseSubjectRepository,
        GradeRepository         $gradeRepository,
        StudentRepository       $studentRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->testRepository = $testRepository;
        $this->teacherRepository = $teacherRepository;
        $this->courseSubjectRepository = $courseSubjectRepository;
        $this->gradeRepository = $gradeRepository;
        $this->studentRepository = $studentRepository;
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

    /**
     * @param int $id
     * @return array
     */
    public function getTeachingSubjectsGroupedByCourseForTeacherId(int $id): array
    {
        $data = $this->courseSubjectRepository->findCourseNameAndSubjectNameForTeacherId($id);
        $groupedByCourse = [];
        // Loop through the data and group by course with key courseId and subjects as array with courseSubjectId as key
        foreach ($data as $courseSubject) {
            $courseId = $courseSubject->getCourse()->getId();
            $courseName = $courseSubject->getCourse()->getName();
            $groupedByCourse[$courseId]['courseName'] = $courseName;
            $groupedByCourse[$courseId]['subjects'][$courseSubject->getId()] = $courseSubject->getSubject();
        }
        return $groupedByCourse;
    }

    public function getStudentsGradesForCourseSubject(int $courseSubjectId): array
    {
        return $this->testRepository->findGradesOnTestForCourseAndSubject($courseSubjectId);
    }

    public function getStudentsInCourseSubject(int $courseSubjectId): array
    {
        $courseId = $this->courseSubjectRepository->find($courseSubjectId)->getCourse()->getId();
        return $this->studentRepository->findStudentsInCourse($courseId);
    }

    public function getGradeById(int $gradeId)
    {
        return $this->gradeRepository->find($gradeId);
    }

    public function getTestById(int $testId)
    {
        return $this->testRepository->find($testId);
    }

}