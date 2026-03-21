<?php

namespace App\Form;

use App\Entity\Character;
use App\Entity\CharacterClass;
use App\Entity\Party;
use App\Entity\Race;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('level', null, ['attr' => ['min' => 1, 'max' => 20]])
            ->add('strength', null, ['data' => 8, 'attr' => ['min' => 8, 'max' => 15]])
            ->add('dexterity', null, ['data' => 8, 'attr' => ['min' => 8, 'max' => 15]])
            ->add('constitution', null, ['data' => 8, 'attr' => ['min' => 8, 'max' => 15]])
            ->add('intelligence', null, ['data' => 8, 'attr' => ['min' => 8, 'max' => 15]])
            ->add('wisdom', null, ['data' => 8, 'attr' => ['min' => 8, 'max' => 15]])
            ->add('charisma', null, ['data' => 8, 'attr' => ['min' => 8, 'max' => 15]])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
            ])
            ->add('party_character', EntityType::class, [
                'class' => Party::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
            ->add('race', EntityType::class, [
                'class' => Race::class,
                'choice_label' => 'name',
            ])
            ->add('class_character', EntityType::class, [
                'class' => CharacterClass::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
        ]);
    }
}
