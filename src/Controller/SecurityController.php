<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Endroid\QrCode\Builder\Builder;
use LogicException;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Totp\TotpAuthenticator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends BaseController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {


        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/authenticate/2fa/enable', name: 'app_2fa_totp_enable')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function enableTOTP2fa(TotpAuthenticator $totpAuthenticator, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user->isTotpAuthenticationEnabled()) {
            $user->setTotpSecret($totpAuthenticator->generateSecret());

            $entityManager->persist($user);
            $entityManager->flush();
        }

//        dd($totpAuthenticator->getQRContent($user));

        return $this->render('security/enable_totp_2fa.html.twig', [
        ]);
    }

    #[Route(path: '/authenticate/2fa/qr-code', name: 'app_qr_code')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function authenticatorQrCode(TotpAuthenticator $totpAuthenticator): Response
    {
        $user = $this->getUser();
        if (!$user->isTotpAuthenticationEnabled()) {
            throw new LogicException('TOTP authentication is not enabled for this user.');
        }

        $qrCodeContent = $totpAuthenticator->getQRContent($user);
        $result = Builder::create()
            ->data($qrCodeContent)
            ->build();

        return new Response($result->getString(), 200, ['Content-Type' => 'image/png']);
    }


}
