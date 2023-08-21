<?php
namespace App\Form;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;

class TeacherFindFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('teacher', SearchType::class, [
            'label' => 'Search for a teacher',
            'attr' => [
                'placeholder' => 'Enter a name or surname',
            ],
            'required' => false,
            'data' => '',
        ]);
    }
}