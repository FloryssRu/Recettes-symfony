<?php

namespace App\Form;

use App\Entity\Ingredient;
use App\Entity\MeasureUnit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class IngredientFormType extends AbstractType
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
                        'minMessage' => 'Le nom doit contenir {{ min }} caractères minimum.',
                        'max' => 120,
                        'minMessage' => 'Le nom doit contenir {{ max }} caractères maximum.'
                    ])
                ]
            ])
            ->add('number', IntegerType::class, [
                'label' => "Quantité",
                'required' => true,
            ])
            ->add('measureUnit', EntityType::class, [
                'label' => 'Unité de mesure',
                'class' => MeasureUnit::class,
                'choice_label' => 'name',
                'required' => false,
                'placeholder' => 'aucune'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ingredient::class,
        ]);
    }
}
