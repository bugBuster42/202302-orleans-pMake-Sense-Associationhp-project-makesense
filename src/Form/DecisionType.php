<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Decision;
use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichFileType;

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
                'label' => 'Catégorie',
                'choice_label' => 'title',
                'placeholder' => 'Choisir une catégorie',
            ])
            ->add('description', CKEditorType::class)
            ->add('posterFile', VichFileType::class, [
                'required'      => false,
                'allow_delete'  => true,
                'download_uri' => true,
            ])
            ->add('user', EntityType::class, [
                'label' => 'Personnes expertes & Personnes impactées',
                'class' => User::class,
                'choice_label' => 'fullname',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Decision::class,
        ]);
    }
}
