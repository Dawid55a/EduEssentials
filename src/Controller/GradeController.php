<?php

namespace App\Controller;

use AllowDynamicProperties;
use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[AllowDynamicProperties] class GradeController extends AbstractController
{

//    public function __construct(StudentService $studentService, TeacherService $teacherService)
//    {
//        $this->studentService = $studentService;
//        $this->teacherService = $teacherService;
//    }
//
//
//    #[Route('/grade', name: 'app_grade')]
//    public function index(): Response
//    {
////        $students = $this->studentService->getStudents();
////        dd($this->studentService->getStudentsWithGrades());
//        /** @var User $user */
//        $teacher = in_array('ROLE_TEACHER',$this->getUser()->getRoles() ) ? $this->getUser() : null;
//        return $this->render('grade/index.html.twig', [
//            'controller_name' => 'GradeController',
//            'students' => $this->studentService->getStudentsWithGrades(),
//            'tests' => $this->studentService->getStudentTests($this->getUser()->getId()),
//        ]);
//    }
}
