<?php

namespace App\Services;

use App\Entity\Recipe;
use App\Repository\RecipeTypeRepository;
use App\Repository\SeasonRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeService extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $manager,
        private readonly SeasonRepository $seasonRepository,
        private readonly RecipeTypeRepository $recipeTypeRepository
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
}
