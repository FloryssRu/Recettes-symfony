<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use App\Entity\MeasureUnit;
use App\Entity\Recipe;
use App\Entity\RecipeType;
use App\Entity\Season;
use App\Entity\Step;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user
            ->setPseudo('Floryss')
            ->setRoles(['ROLE_USER'])
            ->setPassword($this->passwordHasher->hashPassword($user, 'TestTest'))
        ;
        $manager->persist($user);

        // All MeasureUnits
        $manager->persist((new MeasureUnit())->setName('millilitre'));
        $manager->persist((new MeasureUnit())->setName('litre'));
        $manager->persist((new MeasureUnit())->setName('kilogramme'));
        $manager->persist($mesureUnit = (new MeasureUnit())->setName('gramme'));

        // All Seasons
        $manager->persist((new Season())->setName('Ete'));
        $manager->persist((new Season())->setName('Automne'));
        $manager->persist((new Season())->setName('Hiver'));
        $manager->persist((new Season())->setName('Printemps'));

        // All Types of Recipes
        $manager->persist((new RecipeType())->setName('Entrée'));
        $manager->persist((new RecipeType())->setName('Plat'));
        $manager->persist($recipeType = (new RecipeType())->setName('Dessert'));
        $manager->persist((new RecipeType())->setName('Autre'));

        // First Recipe for the user (example)
        $ingredient1 = new Ingredient();
        $ingredient1->setName('Chocolat noir')->setNumber(250)->setMeasureUnit($mesureUnit);

        $ingredient2 = new Ingredient();
        $ingredient2->setName('Oeufs')->setNumber(6);

        $step1 = new Step();
        $step1->setNumber(1)->setDescription('Séparez les blancs des jaunes.');
        $step2 = new Step();
        $step2->setNumber(2)->setDescription('Faites fondre le chocolat.');
        $step3 = new Step();
        $step3->setNumber(3)->setDescription('Montez les blancs en neige.');
        $step4 = new Step();
        $step4->setNumber(4)->setDescription("Mélangez les jaunes d'oeufs avec le chocolat.");
        $step5 = new Step();
        $step5->setNumber(5)->setDescription("Incorporez les blancs en neige dans le chocolat.");
        $step6 = new Step();
        $step6->setNumber(6)->setDescription("Conservez au frigo 4h.");
        

        $recipe = new Recipe();
        $recipe
            ->setCreatedAt(new DateTimeImmutable())
            ->setOwner($user)
            ->setPreparationTime(30)
            ->setVegan(false)
            ->setVegetarian(true)
            ->addType($recipeType)
            ->addIngredient($ingredient1)
            ->addIngredient($ingredient2)
            ->addStep($step1)
            ->addStep($step2)
            ->addStep($step3)
            ->addStep($step4)
            ->addStep($step5)
            ->addStep($step6)
        ;
        $manager->persist($recipe);

        $manager->flush();
    }
}
