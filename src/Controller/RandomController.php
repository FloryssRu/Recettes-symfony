<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RandomFormType;
use App\Repository\RecipeRepository;
use App\Services\RecipeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RandomController extends AbstractController
{
    public function __construct(
        private readonly RecipeRepository $recipeRepository,
        private readonly RecipeService $recipeService,
    ) {}

    /**
     * Page which allows user to get a random meal with parameters
     */
    #[Route('/recettes-random', name: 'app_random', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $randomParams = new Recipe();
        $recipes = [];

        $form = $this->createForm(RandomFormType::class, $randomParams, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipes = $this->recipeService->getRandomResults($randomParams, $form);
        }

        return $this->render('random/index.html.twig', [
            'recipes' => $recipes,
            'types' => $randomParams->getTypes(),
            'form' => $form
        ]);
    }
}
