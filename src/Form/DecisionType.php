<?php

namespace App\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use App\Entity\Decision;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DecisionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('startDate', DateType::class, ['widget' => 'single_text', 'label' => 'Date début'])
            ->add('description', CKEditorType::class)
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
