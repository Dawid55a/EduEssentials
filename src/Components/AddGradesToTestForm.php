<?php

namespace App\Components;

use App\Entity\Student;
use App\Entity\Test;
use App\Form\AddGradesToTestFormType;
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
use Symfony\UX\LiveComponent\LiveCollectionTrait;

#[AsLiveComponent()]
class AddGradesToTestForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use LiveCollectionTrait;

    #[LiveProp]
    public array $studentsIds;
    #[LiveProp]
    public int $testId;

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->studentsIds = [];
        $this->testId = 0;
    }

    public function hasValidationErrors(): bool
    {
        return $this->getForm()->isSubmitted() && !$this->getForm()->isValid();
    }

    #[LiveAction]
    public function saveGrades(): ?RedirectResponse
    {
        $this->submitForm();
        if ($this->getForm()->isValid()) {
            $test = $this->entityManager->getRepository(Test::class)->find($this->testId);

            $grades = $this->getForm()->getData();
            foreach ($grades['grades'] as $grade) {
                $grade->setTest($test);
                $grade->setIssueDatetime(new DateTime());
                $this->entityManager->persist($grade);
            }
            $this->entityManager->flush();

            return $this->redirectToRoute('app_teacher_grade');
        }
        return null;
    }

    protected function instantiateForm(): FormInterface
    {
        $students = $this->entityManager->getRepository(Student::class)->findBy(['id' => $this->studentsIds]);

        return $this->createForm(AddGradesToTestFormType::class, null, [
            'students' => $students,
            'test_id' => $this->testId
        ]);
    }
}