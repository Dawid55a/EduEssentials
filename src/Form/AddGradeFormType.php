<?php

namespace App\Form;

use App\Entity\Grade;
use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DivisibleBy;
use Symfony\Component\Validator\Constraints\Range;

class AddGradeFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('grade', NumberType::class, [
                'label' => 'Grade',
                'attr' => [
                    'min' => 1,
                    'max' => 6,
                    'step' => 0.5,
                ],
                'scale' => 1,
                'constraints' => [
                    new Range([
                        'min' => 1,
                        'max' => 6,
                        'notInRangeMessage' => 'Grade must be between {{ min }} and {{ max }}',
                    ]),
                    new DivisibleBy([
                        'value' => 0.5,
                        'message' => 'Grade can be only in {{ value }} steps',
                    ])

                ],
            ])
            ->add('student', ChoiceType::class, [
                'choices' => $options['students'],
                'choice_label' => function ($student, $key, $value) {
                    return $student->getNumber() . '. ' .
                        $student->getAuthUser()->getFirstName() . ' ' .
                        $student->getAuthUser()->getLastName();
                },
                'choice_value' => function ($student) {
                    return $student ? $student->getId() : '';
                },
                'data_class' => Student::class,
            ])
            ->add('test', HiddenType::class, [
                'data' => $options['test_id'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Grade::class,
            'students' => [],
            'test_id' => null
        ]);
    }
}