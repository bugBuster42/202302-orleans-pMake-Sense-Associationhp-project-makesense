<?php

namespace App\Form;

use App\Entity\Decision;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DecisionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('startDate', DateType::class, ['widget' => 'single_text', 'label' => 'Date début'])
            ->add('category', Entitytype::class, [
                'class' => Category::class,
                'label' => 'Choisir une catégorie',
                'choice_label' => 'title',
                'placeholder' => 'Catégorie',
            ])
            ->add(
                'expertUsers',
                ExpertUsersAutocompleteField::class,
            )
            ->add(
                'impactedUsers',
                ImpactedUsersAutocompleteField::class,
            )
            ->add('description', CKEditorType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Decision::class,
        ]);
    }
}
