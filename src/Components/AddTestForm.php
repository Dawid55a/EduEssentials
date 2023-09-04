<?php

namespace App\Components;

use App\DTO\TestStatusEnum;
use App\Entity\CourseSubject;
use App\Form\CreateTestFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent()]
class AddTestForm extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    #[LiveProp]
    public int $courseSubjectId;

    public function hasValidationErrors(): bool
    {
        return $this->getForm()->isSubmitted() && !$this->getForm()->isValid();
    }

    #[LiveAction]
    public function saveTest(EntityManagerInterface $entityManager): ?RedirectResponse
    {
        $this->submitForm();
        if ($this->getForm()->isValid()) {
            $test = $this->getForm()->getData();
//            dd($test);
            $test->setTeacher($this->getUser()->getTeacher());
            $courseSubject = $entityManager->getRepository(CourseSubject::class)->find($this->courseSubjectId);
            $test->setCourseSubject($courseSubject);
            $test->setStatus(TestStatusEnum::PLANNED);
            $entityManager->persist($test);
            $entityManager->flush();

            return $this->redirectToRoute('app_teacher_grade');
        }
        return null;
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(CreateTestFormType::class);
    }
}