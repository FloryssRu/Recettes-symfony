<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecipeController extends AbstractController
{
    /**
     * Page which will display list of my recipes
     */
    #[Route('/mes-recettes', name: 'app_myrecipes')]
    public function myRecipes(): Response
    {
        return $this->render('recipe/my-recipes.html.twig', []);
    }

    /**
     * Page which allow user to modify / create a recipe
     */
    #[Route('/mes-recettes/{id<[0-9]+>}', name: 'app_myrecipes_form')]
    public function myRecipesForm(): Response
    {
        return $this->render('recipe/my-recipes-form.html.twig', []);
    }

    /**
     * Page witch delete a recipe
     */
    #[Route('/mes-recettes/suppression/{id<[0-9]+>}', name: 'app_myrecipes_delete')]
    public function myRecipesDelete(): Response
    {
        return $this->redirectToRoute('app_myrecipes');
    }
}
