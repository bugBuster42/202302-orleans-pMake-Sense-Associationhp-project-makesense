<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Decision;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;

class SearchDecisionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod('GET')
            ->add('search', SearchType::class, [
                'required' => false,
                'trim' => false,
            ])
            ->add(
                'status',
                ChoiceType::class,
                [
                    'choices' => array_flip(Decision::STATUS),
                    'placeholder' => 'Avancée de la décision',
                    'required' => false,
                ]
            )
            ->add(
                'category',
                EntityType::class,
                [
                    'class' => Category::class,
                    'choice_label' => 'title',
                    'placeholder' => 'Catégorie',
                    'required' => false,

                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([

            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
