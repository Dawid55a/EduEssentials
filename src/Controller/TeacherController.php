<?php

namespace App\Controller;

use App\Form\TeacherFindFormType;
use App\Service\TeacherService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{

    private TeacherService $teacherService;
    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    #[Route('/teacher', name: 'app_teacher')]
    public function index(
        Request $request,
    ): Response
    {
        $form = $this->createForm(TeacherFindFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $search = $data['teacher'];
            if (empty($search)) {
                $search = '';
            }
            $teachers = $this->teacherService->findTeachers($search);
            $teachersBySubject = $this->teacherService->getTeachersGroupedBySubjects($teachers);
        }

        return $this->render('teacher/index.html.twig', [
            'controller_name' => 'TeacherController',
            'search_form' => $form->createView(),
            'teachersBySubject' => $teachersBySubject ?? null,
        ]);
    }
}
