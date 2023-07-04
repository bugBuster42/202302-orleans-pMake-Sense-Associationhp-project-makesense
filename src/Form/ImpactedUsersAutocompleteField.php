<?php

namespace App\Form;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\ParentEntityAutocompleteType;

#[AsEntityAutocompleteField]
class ImpactedUsersAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => User::class,
            'label' => 'Personnes impactées',
            'placeholder' => 'Choisir une personne impactée',
            'choice_label' => 'fullname',
            'multiple' => true,
            'by_reference' => false,

            'query_builder' => function (UserRepository $userRepository) {
                return $userRepository->createQueryBuilder('user');
            },
        ]);
    }

    public function getParent(): string
    {
        return ParentEntityAutocompleteType::class;
    }
}
