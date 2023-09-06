<?php

namespace App\Controller;

use App\Form\TeacherFindFormType;
use App\Service\TeacherService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkersController extends BaseController
{
    private TeacherService $teacherService;

    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    #[Route('/workers', name: 'app_workers')]
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
            $teachers = $this->teacherService->searchTeachers($search);
            $teachersBySubject = $this->teacherService->getTeachersGroupedBySubjects($teachers);
        }

        return $this->render('workers/index.html.twig', [
            'controller_name' => 'WorkersController',
            'search_form' => $form->createView(),
            'teachersBySubject' => $teachersBySubject ?? null,
        ]);
    }

    #[Route('/workers/teacher-details/{id}', name: 'teacher_details')]
    public function teacherDetails(int $id, Request $request): Response
    {
        if (!$request->headers->has('Turbo-Frame')) {
            return $this->redirectToRoute('app_workers');
        }

        if (empty($id)) {
            throw $this->createNotFoundException('Teacher not found!');
        }

        $teacher = $this->teacherService->getTeacherById($id);

        return $this->render('workers/detail.html.twig', [
            'teacher' => $teacher,
        ]);
    }

}
