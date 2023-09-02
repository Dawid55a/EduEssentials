<?php

namespace App\DataTransformer;

use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class StudentToStringTransformer implements DataTransformerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function transform($value): string
    {
        if (null === $value) {
            return '';
        }
        return "{$value->getNumber()}. {$value->getAuthUser()->getFirstName()} {$value->getAuthUser()->getLastName()}";
    }

    public function reverseTransform($value)
    {
        if (!$value) {
            return null;
        }
        $studentId = explode('.', $value)[0];

        $student = $this->entityManager
            ->getRepository(Student::class)
            ->find($studentId);

        if (null === $student) {
            throw new TransformationFailedException(sprintf(
                'An student with number "%s" does not exist!',
                $value
            ));
        }

        return $student;
    }
}