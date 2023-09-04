<?php

namespace App\Components;

use App\Entity\Test;
use App\Form\EditTestFormType;
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
class EditTestForm extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    #[LiveProp]
    public Test $test;

    public function hasValidationErrors(): bool
    {
        return $this->getForm()->isSubmitted() && !$this->getForm()->isValid();
    }

    #[LiveAction]
    public function saveChanges(EntityManagerInterface $entityManager): ?RedirectResponse
    {
        $this->submitForm();
        if ($this->getForm()->isValid()) {
            $test = $this->getForm()->getData();

            $entityManager->persist($test);
            $entityManager->flush();

            return $this->redirectToRoute('app_teacher_grade');
        }
        return null;
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(EditTestFormType::class, $this->test);
    }
}