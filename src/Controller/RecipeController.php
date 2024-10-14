<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mes-recettes')]
class RecipeController extends AbstractController
{
    /**
     * Page which will display list of my recipes
     */
    #[Route('/', name: 'app_myrecipes', methods: ['GET'])]
    public function myRecipes(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        // this next condition could not happen because unautenticated users cannot access to this route (config)
        if (!$user) return $this->redirectToRoute('app_home');

        $recipes = $user->getRecipes();
        
        return $this->render('recipe/my-recipes.html.twig', [
            'recipes' => $recipes
        ]);
    }

    /**
     * Page which allow user to modify / create a recipe
     */
    #[Route('/{id<[0-9]+>}', name: 'app_myrecipes_form', methods: ['GET', 'POST'])]
    public function myRecipesForm(): Response
    {
        return $this->render('recipe/my-recipes-form.html.twig', []);
    }

    /**
     * Page witch delete a recipe
     * TODO : if possible, replace method POST by method DELETE
     */
    #[Route('/suppression/{id<[0-9]+>}', name: 'app_myrecipes_delete', methods: ['POST'])]
    public function myRecipesDelete(): Response
    {
        return $this->redirectToRoute('app_myrecipes');
    }
}
