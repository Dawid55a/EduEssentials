<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('first_name', null, [
                'constraints' => [
                    new NotBlank(message: 'Please enter a name!'),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Your name should be at least {{ limit }} characters',
                        'max' => 255,
                        'maxMessage' => 'Your name should be at most {{ limit }} characters',
                    ]),
                ],
            ],)
            ->add('last_name', null, [
                'constraints' => [
                    new NotBlank(message: 'Please enter a surname!'),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Your surname should be at least {{ limit }} characters',
                        'max' => 255,
                        'maxMessage' => 'Your surname should be at most {{ limit }} characters',
                    ]),
                ],
            ],)
            ->add('phone_number', null, [
                'constraints' => [
                    new NotBlank(message: 'Please enter a phone!'),
                    // example acceptable phone numbers:
                    // 531 123 456
                    // +48 531 123 456
                    // +48 531123456
                    // +48 531 123456
                    // 531123456
                    new Regex(pattern: '/^\+?(\d{2})?(\s?)([0-9]{3})(\s?)([0-9]{3})(\s?)([0-9]{3})$/', message: 'Invalid phone number!'),
                ],
            ],)
            ->add('address', null, [
                'constraints' => [
                    new NotBlank(message: 'Please enter an address!'),
                ],
            ],)
            ->add('dateOfBirth', DateType::class, [
                'widget' => 'choice',

                'constraints' => [
                    new NotBlank(message: 'Please enter a date of birth!'),
                    new LessThanOrEqual([
                        'value' => new \DateTime(),
                        'message' => 'The date of birth cannot be in the future!',
                    ]),
                ],
            ],)
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank(message: 'Please enter an email!'),
                    new Email(),
                ],
            ])
            ->add('password', PasswordType::class, [
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank(message: 'Please enter a password'),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'always_empty' => false,
            ])
            ->add('terms', CheckboxType::class, [
                'label' => 'Agree to terms',
                'mapped' => false,
                'constraints' => [
                    new NotBlank(message: 'Please agree to the non-existent terms'),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
