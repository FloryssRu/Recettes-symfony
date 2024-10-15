<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RandomFormType;
use App\Services\RecipeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SearchController extends AbstractController
{
    public function __construct(
        private readonly RecipeService $recipeService
    ) {}

    /**
     * Page which allows to make a search in recipes with parameters
     */
    #[Route('/recherche', name: 'app_search', methods: ['GET', 'POST'])]
    public function search(Request $request): Response
    {
        $params = new Recipe();
        $recipes = [];

        $form = $this->createForm(RandomFormType::class, $params, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipes = $this->recipeService->getResultsOfSearch($params);
        }

        return $this->render('search/index.html.twig', [
            'form' => $form,
            'recipes' => $recipes
        ]);
    }

    /**
     * Page which shows details of a recipe
     */
    #[Route('/recette/{id<[0-9]+>}', name: 'app_recipe', methods: ['GET'])]
    public function recipeDetails(): Response
    {
        return $this->render('search/recipe.html.twig', []);
    }

    /**
     * Page which allows user to like/unlike a recipe
     */
    #[Route('/liker/{id<[0-9]+>}/{like<[0-1]>', name: 'app_like', methods: ['POST'])]
    public function likeRecipe(int $id): Response
    {
        return $this->redirectToRoute('app_recipe', ['id' => $id]);
    }
}
