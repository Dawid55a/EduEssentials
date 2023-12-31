<?php

namespace App\Controller;

use App\Service\CatApiService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends BaseController
{
    #[Route('/', name: 'app_home_page')]
    public function index(CatApiService $catApi): Response
    {
        $photo = $catApi->getRandomCatPhotoUrl();

        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
            'catPhoto' => $photo ?? '',
        ]);
    }
}
