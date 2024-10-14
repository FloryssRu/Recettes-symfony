<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SearchController extends AbstractController
{
    /**
     * Page witch allows to make a search in recipes with parameters
     */
    #[Route('/recherche', name: 'app_search', methods: ['GET', 'POST'])]
    public function search(): Response
    {
        return $this->render('search/index.html.twig', []);
    }

    /**
     * Page witch shows details of a recipe
     */
    #[Route('/recette/{id<[0-9]+>}', name: 'app_recipe', methods: ['GET'])]
    public function recipeDetails(): Response
    {
        return $this->render('search/recipe.html.twig', []);
    }

    /**
     * Page witch allows user to like/unlike a recipe
     */
    #[Route('/liker/{id<[0-9]+>}/{like<[0-1]>', name: 'app_like', methods: ['POST'])]
    public function likeRecipe(int $id): Response
    {
        return $this->redirectToRoute('app_recipe', ['id' => $id]);
    }
}
