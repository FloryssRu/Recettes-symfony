<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeFormType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mes-recettes')]
class RecipeController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $manager
    ) {}

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
    public function myRecipesForm(Recipe $recipe): Response
    {
        if (!$recipe) $recipe = null;
        $form = $this->createForm(RecipeFormType::class, $recipe, []);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipe
                ->setCreatedAt(new DateTimeImmutable())
                ->setOwner($this->getUser())
            ;
            $this->manager->persist($recipe);
            $this->manager->flush();
            $this->addFlash('success', 'La recette a été enresgitrée.');
        }

        return $this->render('recipe/my-recipes-form.html.twig', [
            'form' => $form,
            'recipe' => $recipe
        ]);
    }

    /**
     * Page witch delete a recipe
     * TODO : if possible, replace method POST by method DELETE
     */
    #[Route('/suppression/{id<[0-9]+>}', name: 'app_myrecipes_delete', methods: ['POST'])]
    public function myRecipesDelete(Recipe $recipe): Response
    {
        $this->manager->remove($recipe);
        $this->manager->flush();
        $this->addFlash('success', 'La recette a bien été supprimée.');

        return $this->redirectToRoute('app_myrecipes');
    }
}
