<?php

namespace App\Services;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use App\Repository\RecipeTypeRepository;
use App\Repository\SeasonRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;

class RecipeService extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $manager,
        private readonly SeasonRepository $seasonRepository,
        private readonly RecipeTypeRepository $recipeTypeRepository,
        private readonly RecipeRepository $recipeRepository,
    ) {}

    /**
     * Function used to save recipe and its relations (season and types)
     */
    public function saveRecipe(Recipe $recipe): void
    {
        // 1) We delete all relation between season / type and this recipe
        $seasons = $this->seasonRepository->findAll();
        foreach ($seasons as $season) {
            $season->removeRecipe($recipe);
            $this->manager->persist($season);
        }

        $types = $this->recipeTypeRepository->findAll();
        foreach ($types as $type) {
            $type->removeRecipe($recipe);
            $this->manager->persist($type);
        }
        $this->manager->flush();

        // 2) We create the relation given in form submission
        foreach ($recipe->getSeasons() as $season) {
            $season->addRecipe($recipe);
            $this->manager->persist($season);
        }
        foreach ($recipe->getTypes() as $type) {
            $type->addRecipe($recipe);
            $this->manager->persist($type);
        }

        // 3) Completion of recipe object (if needed)
        if (!$recipe->getOwner()) $recipe->setOwner($this->getUser());
        if (!$recipe->getCreatedAt()) $recipe->setCreatedAt(new DateTimeImmutable());

        $this->manager->persist($recipe);
        $this->manager->flush();
    }

    /**
     * Function used to search and return a random recipes results
     */
    public function getRandomResults(Recipe $recipe, Form $form): array
    {
        $recipesToReturn = [];

        // 1) Get object selected in un-mapped fields
        $allOfThisTypes = $form->get('allOfThisTypes')->getData();
        
        // If we want a recipe by selected type
        if ($allOfThisTypes) {
            foreach ($recipe->getTypes() as $type) {
                $recipesToReturn[] = $this->recipeRepository->findOneByType(
                    $type,
                    $recipe->getIsVegetarian(),
                    $recipe->getIsVegan()
                );
            }
        // If we want a recipe in one of selected types randomly
        } else {
            $recipesToReturn[0] = null;
            $types = $recipe->getTypes()->toArray();
            $numberOfTypes = count($types);

            $i = $numberOfTypes-1;
            while ($i >= 0) {
                $indexOfType = rand(0, count($types)-1);
                $type = $types[$indexOfType];
    
                $recipeFound = $this->recipeRepository->findOneByType(
                    $type,
                    $recipe->getIsVegetarian(),
                    $recipe->getIsVegan()
                );

                if ($recipeFound !== null) {
                    $recipesToReturn[0] = $recipeFound; // replace null by result
                    $i = -1; // quit the while loop
                } else {
                    array_splice($types, $indexOfType, 1); // remove type
                    $i = $i-1; // continue the while loop
                }
            }
        }

        return $recipesToReturn;
    }
}
