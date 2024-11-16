<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Entity\RecipeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * The form who will be used in randmon meal generation
 */
class RandomFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['randomSearch']) {
            $builder->add('allOfThisTypes', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Une recette de chaque type.',
                'required' => false,
            ]);
        }

        $builder
            ->add('types', EntityType::class, [
                'label' => 'Les types de recettes.',
                'class' => RecipeType::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true
            ])
            ->add('isVegetarian', CheckboxType::class, [
                'label' => 'Les recettes doivent être végétariennes.',
                'required' => false,
            ])
            ->add('isVegan', CheckboxType::class, [
                'label' => 'Les recettes doivent être végan.',
                'required' => false,
            ])
            // TODO ideas for other filters
            // ->add('onlyLikedRecipes', CheckboxType::class, [
            //     'mapped' => false,
            //     'label' => "Ne sélectionner que des recettes que j'ai aimées.",
            //     'required' => false,
            // ])
            // ->add('seasons', EntityType::class, [
            //     'label' => "Saisons",
            //     'class' => Season::class,
            //     'choice_label' => 'name',
            //     'expanded' => true,
            //     'multiple' => true
            // ])
            // ->add('totalPreparationTime', IntegerType::class, [
            //     'mapped' => false,
            //     'label' => 'Temps total de préparation maximal.',
            //     'required' => false,
            //     'constraints' => [
            //         new GreaterThan(0)
            //     ]
            // ])
            // ->add('owner', EntityType::class, [
            //     'label' => 'Le propriétaire des recettes.',
            //     'class' => User::class,
            //     'choice_label' => 'pseudo',
            //     'expanded' => true,
            //     'multiple' => true
            // ])
            // ->add('likedByMoreThan', IntegerType::class, [
            //     'label' => 'Recette aimée par plus de x personnes',
            //     'mapped' => false,
            //     'constraints' => []
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Recipe::class,
            'randomSearch' => true,
        ]);
    }
}
