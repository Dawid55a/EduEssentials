<?php

namespace App\Controller;

use App\Service\StudentService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends BaseController
{
    private StudentService $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    #[Route('/student/grade/{subject}', name: 'app_student_grade')]
    public function subject(?string $subject = null): Response
    {
        $userId = $this->getUser()->getStudent()->GetId();
        $grades = $this->studentService->getGradesBySubjectForStudent($userId);

        if ($subject == null) {
            return $this->render('student/grade/index.html.twig', [
                'controller_name' => 'GradeController',
                'grades' => $grades
            ]);
        } else {
            $subjectGrades = $grades[$subject];
            return $this->render('student/grade/subject_grades.html.twig', [
                'controller_name' => 'GradeController',
                'grades' => $grades,
                'subjectGrades' => $subjectGrades
            ]);
        }
    }

    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
}
