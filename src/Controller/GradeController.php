<?php

namespace App\Controller;

use AllowDynamicProperties;
use App\Service\StudentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[AllowDynamicProperties] class GradeController extends AbstractController
{

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }


    #[Route('/grade', name: 'app_grade')]
    public function index(): Response
    {
        $students = $this->studentService->getStudents();
        return $this->render('grade/index.html.twig', [
            'controller_name' => 'GradeController',
            'students' => $this->studentService->getStudentsWithGrades($students),
        ]);
    }
}
