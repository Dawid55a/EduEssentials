<?php

namespace App\Twig;

use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent()]
class RegistrationForm extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    #[LiveProp]
    public bool $isSuccessful = false;

    #[LiveProp]
    public ?string $newUserEmail = null;

    protected function instantiateForm(): FormInterface
    {
        $form = $this->createForm(RegistrationFormType::class);
//        $form->get(FormRenderer::class)->setTheme($form->createView(), 'form/custom_form_layout.html.twig');
        return $this->createForm(RegistrationFormType::class);

    }

    public function hasValidationErrors(): bool
    {
        return $this->getForm()->isSubmitted() && !$this->getForm()->isValid();
    }

    #[LiveAction]
    public function saveRegistration(UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, Security $security, UrlGeneratorInterface $urlGenerator) : ?RedirectResponse
    {
        $this->submitForm();

        if ($this->getForm()->isValid()) {
            $user = $this->getForm()->getData();
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $this->getForm()->get('password')->getData()
                )
            );

            $role = $this->getForm()->get('role')->getData();
            $user->setRoles([$role]);

            $entityManager->persist($user);
            $entityManager->flush();

//            $this->newUserEmail = $this->getForm()->get('email')->getData();
//            $this->isSuccessful = true;

            $security->login($user, LoginFormAuthenticator::class, 'main');
            return new RedirectResponse($urlGenerator->generate('app_home_page'));
        }
        return null;
    }
}
