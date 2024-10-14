<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RandomController extends AbstractController
{
    /**
     * Page witch allows user to get a random meal with parameters
     */
    #[Route('/repas-random', name: 'app_random', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('random/index.html.twig', []);
    }
}
