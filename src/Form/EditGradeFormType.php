<?php

namespace App\Form;

use App\Entity\Grade;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DivisibleBy;
use Symfony\Component\Validator\Constraints\Range;

class EditGradeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('grade', NumberType::class, [
                'label' => 'New Grade',
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
            ->add('save', SubmitType::class, [
                'label' => 'Save',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Grade::class,
        ]);
    }
}