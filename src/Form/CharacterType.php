<?php

namespace App\Form;

use App\Entity\Character;
use App\Entity\CharacterClass;
use App\Entity\Party;
use App\Entity\Race;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;

class CharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('level', null, ['attr' => ['min' => 1, 'max' => 20, 'placeholder' => 'from 1 to 20']])
            ->add('strength', null, ['attr' => ['min' => 8, 'max' => 15, 'placeholder' => 'from 8 to 15']])
            ->add('dexterity', null, ['attr' => ['min' => 8, 'max' => 15, 'placeholder' => 'from 8 to 15']])
            ->add('constitution', null, ['attr' => ['min' => 8, 'max' => 15, 'placeholder' => 'from 8 to 15']])
            ->add('intelligence', null, ['attr' => ['min' => 8, 'max' => 15, 'placeholder' => 'from 8 to 15']])
            ->add('wisdom', null, ['attr' => ['min' => 8, 'max' => 15, 'placeholder' => 'from 8 to 15']])
            ->add('charisma', null, ['attr' => ['min' => 8, 'max' => 15, 'placeholder' => 'from 8 to 15']])
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

            ->add('avatarFile', FileType::class, [
                'label' => 'Avatar (Image File)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Constraints\File(extensions: ['png', 'jpg', 'jpeg'], extensionsMessage: 'Please upload a valid image file.'),

                ]
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
