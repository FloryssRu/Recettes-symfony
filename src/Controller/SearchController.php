<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\User;
use App\Form\RandomFormType;
use App\Repository\RecipeRepository;
use App\Services\RecipeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SearchController extends AbstractController
{
    public function __construct(
        private readonly RecipeService $recipeService,
        private readonly RecipeRepository $recipeRepository
    ) {}

    /**
     * Page which allows to make a search in recipes with parameters
     */
    #[Route('/recherche', name: 'app_search', methods: ['GET', 'POST'])]
    public function search(Request $request): Response
    {
        $params = new Recipe();
        $recipes = [];
        $noRecipeFounded = false;
        $page = $this->recipeService->getPageToTrust($request->query->get('page'));
        $totalOfPages = 0;

        $form = $this->createForm(RandomFormType::class, $params, [
            'randomSearch' => false
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipes = $this->recipeService->getResultsOfSearch(
                $params,
                $page
            );
            if (count($recipes) === 0) $noRecipeFounded = true;
            else $totalOfPages = $this->recipeService->getTotalOfPages($params);
        }

        return $this->render('search/index.html.twig', [
            'form' => $form,
            'recipes' => $recipes,
            'noRecipeFounded' => $noRecipeFounded,
            'page' => $page,
            'totalOfPages' => $totalOfPages - 1
        ]);
    }

    /**
     * Page which shows details of a recipe
     */
    #[Route('/recette/{id<[0-9]+>}', name: 'app_recipe', methods: ['GET'])]
    public function recipeDetails(int $id): Response
    {
        $recipe = $this->recipeRepository->find($id);
        if (!$recipe) {
            $this->addFlash('error', "Cette recette n'existe pas.");
            return $this->redirectToRoute('app_search');
        }

        $params = ['recipe' => $recipe];

        if ($this->getUser()) {
            $params['iLikedThisRecipe'] = in_array($this->getUser(), $recipe->getLikedUsers()->toArray());
        }

        return $this->render('search/recipe.html.twig', $params);
    }

    /**
     * Page which allows user to like/unlike a recipe
     */
    #[Route('/liker/{id<[0-9]+>}/{like<[0-1]>}', name: 'app_like', methods: ['GET'])]
    public function likeRecipe(int $id, int $like): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $recipe = $this->recipeRepository->find($id);

        if ($recipe) {
            $this->recipeService->changeLikeRecipe($user, $recipe, $like == 1);
        }
        
        return $this->redirectToRoute('app_recipe', ['id' => $id]);
    }
}
