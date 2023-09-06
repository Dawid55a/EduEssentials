<?php

namespace App\Controller;

use App\Service\TeacherService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends BaseController
{
    private TeacherService $teacherService;

    /**
     * @param TeacherService $teacherService
     */
    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    #[Route('/teacher', name: 'app_teacher')]
    public function index(): Response
    {
        return $this->render('teacher/index.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }

    #[Route('/teacher/grade', name: 'app_teacher_grade')]
    public function grade(): Response
    {
        $teacherId = $this->getUser()->getTeacher()->getId();
        $subjectsByCourse = $this->teacherService->getTeachingSubjectsGroupedByCourseForTeacherId($teacherId);
        dump($subjectsByCourse);
        return $this->render('teacher/grade/index.html.twig', [
            'controller_name' => 'TeacherController',
            'subjectsByCourse' => $subjectsByCourse
        ]);
    }

    #[Route('/teacher/grade/{courseSubjectId<\d+>}', name: 'app_teacher_grade_course_subject')]
    public function grading($courseSubjectId = null): Response
    {
        $gradesOnTest = $this->teacherService->getStudentsGradesForCourseSubject($courseSubjectId);
        $students = $this->teacherService->getStudentsInCourseSubject($courseSubjectId);
        return $this->render('teacher/grade/grading.html.twig', [
            'gradesOnTest' => $gradesOnTest,
            'studentCount' => $students,
            'courseSubjectId' => $courseSubjectId
        ]);
    }

    #[Route('/teacher/test/{courseSubjectId<\d+>}', name: 'app_teacher_add_test')]
    public function addTest(int $courseSubjectId): Response
    {
        return $this->render('teacher/test/add_test.html.twig', [
            'courseSubjectId' => $courseSubjectId
        ]);
    }

    #[Route('/teacher/test/edit/{testId<\d+>}', name: 'app_teacher_edit_test')]
    public function editTest(int $testId): Response
    {
        $test = $this->teacherService->getTestById($testId);

        return $this->render('teacher/test/edit_test.html.twig', [
            'test' => $test
        ]);
    }

    #[Route('/teacher/grade/{courseSubjectId<\d+>}/{testId<\d+>}', name: 'app_teacher_grade_test')]
    public function addGrades(int $courseSubjectId, int $testId): Response
    {

        $studentEntities = $this->teacherService->getStudentsInCourseSubject($courseSubjectId);
        $studentsIds = [];
        foreach ($studentEntities as $student) {
            $studentsIds[] = $student->getId();
        }
        return $this->render('teacher/grade/add_grades.html.twig', [
            'test_id' => $testId,
            'studentsIds' => $studentsIds,
            'courseSubjectId' => $courseSubjectId
        ]);
    }

    /**
     * @param int $gradeId
     * @return Response
     */
    #[Route('/teacher/grade/edit/{gradeId<\d+>}', name: 'app_teacher_grade_edit')]
    public function editGrade(int $gradeId): Response
    {
        $grade = $this->teacherService->getGradeById($gradeId);

        return $this->render('teacher/grade/edit_grade.html.twig', [
            'controller_name' => 'TeacherController',
            'grade' => $grade
        ]);

    }
}
