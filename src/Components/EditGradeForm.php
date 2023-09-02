<?php

namespace App\Components;

use App\Entity\Grade;
use App\Form\EditGradeFormType;
use DateTime;
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
class EditGradeForm extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    #[LiveProp]
    public Grade $grade;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function hasValidationErrors(): bool
    {
        return $this->getForm()->isSubmitted() && !$this->getForm()->isValid();
    }

    #[LiveAction]
    public function saveChanges(): ?RedirectResponse
    {
        $this->submitForm();
        if ($this->getForm()->isValid()) {
            $data = $this->getForm()->getData();
            $data->setChangeDatetime(new DateTime());

            $this->entityManager->persist($data);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_teacher_grade');
        }
        return null;
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(EditGradeFormType::class, $this->grade);
    }
}