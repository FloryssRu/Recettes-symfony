<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', []);
    }

    #[Route('/mentions', name: 'app_mentions', methods: ['GET'])]
    public function mentions(): Response
    {
        return $this->render('home/mentions.html.twig', []);
    }

    #[Route('/a-propos', name: 'app_aboutUs', methods: ['GET'])]
    public function aboutUs(): Response
    {
        return $this->render('home/about-us.html.twig', []);
    }
}
