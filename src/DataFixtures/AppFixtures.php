<?php

namespace App\DataFixtures;

use App\Entity\MeasureUnit;
use App\Entity\RecipeType;
use App\Entity\Season;
use App\Entity\User;
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
        $manager->persist((new MeasureUnit())->setName('gramme'));

        // All Seasons
        $manager->persist((new Season())->setName('Ete'));
        $manager->persist((new Season())->setName('Automne'));
        $manager->persist((new Season())->setName('Hiver'));
        $manager->persist((new Season())->setName('Printemps'));

        // All Types of Recipes
        $manager->persist((new RecipeType())->setName('Entrée'));
        $manager->persist((new RecipeType())->setName('Plat'));
        $manager->persist((new RecipeType())->setName('Dessert'));
        $manager->persist((new RecipeType())->setName('Autre'));

        $manager->flush();
    }
}
