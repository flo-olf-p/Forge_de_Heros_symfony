<?php

namespace App\Form;

use App\Entity\Character;
use App\Entity\Party;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];
        $builder
            ->add('name')
            ->add('description')
            ->add('maxSize')
            ->add('characters', EntityType::class, [
                'class' => Character::class,
                'choice_label' => function (Character $character) {
                return $character->getName() . ' (' . $character->getClassCharacter()->getName() . ')';
                },
                'multiple' => true,
                'query_builder' => function (EntityRepository $er) use ($user) {
                return $er->createQueryBuilder('c')
                    ->where('c.user = :user')
                    ->setParameter('user', $user);
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Party::class,
            'user' => null,
        ]);
    }
}
