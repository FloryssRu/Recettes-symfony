<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Entity\RecipeType;
use App\Entity\Season;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RecipeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Le nom de la recette ne peut contenir moins de {{ min }} caractères..',
                        'max' => 100,
                        'maxMessage' => 'Le nom de la recette ne peut contenir plus de {{ max }} caractères.'
                    ])
                ]
            ])
            ->add('preparationTime', IntegerType::class, [
                'label' => 'Temps de préparation en minutes',
                'required' => false
            ])
            ->add('isVegetarian', CheckboxType::class, [
                'label' => 'Recette végétarienne',
                'required' => false
            ])
            ->add('isVegan', CheckboxType::class, [
                'label' => 'Recette végan',
                'required' => false
            ])
            ->add('seasons', EntityType::class, [
                'label' => 'Saisons',
                'class' => Season::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('types', EntityType::class, [
                'label' => 'Types',
                'class' => RecipeType::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}