<?php

namespace App\DataFixtures;

use App\Entity\CharacterClass;
use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SkillFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $skills = [
            ["Acrobaties",	"DEX", ["Voleur"]],
            ["Arcanes",	"INT", ["Mage", "Sorcier"]],
            ["Athlétisme",	"STR", ["Barbare", "Guerrier"]],
            ["Discrétion",	"DEX", ["Ranger", "Voleur"]],
            ["Dressage",	"WIS", ["Druide"]],
            ["Escamotage",	"DEX", ["Voleur"]],
            ["Histoire",	"INT", ["Barde", "Mage"]],
            ["Intimidation",	"CHA", ["Barbare", "Guerrier", "Paladin"]],
            ["Investigation",	"INT", ["Mage"]],
            ["Médecine",	"WIS", ["Clerc"]],
            ["Nature",	"INT", ["Druide", "Ranger"]],
            ["Perception",	"WIS", ["Guerrier","Ranger"]],
            ["Perspicacité",	"WIS", ["Clerc"]],
            ["Persuasion",	"CHA", ["Barde", "Paladin", "Sorcier"]],
            ["Religion",	"INT", ["Clerc", "Paladin"]],
            ["Représentation",	"CHA", ["Barde"]],
            ["Survie",	"WIS", ["Barbare", "Druide", "Ranger"]],
            ["Tromperie",	"CHA", ["Barde", "Sorcier", "Voleur"]]
        ];

        foreach ($skills as $skill) {
            $skillEntity = new Skill();
            $skillEntity->setName($skill[0]);
            $skillEntity->setAbility(\EnumAbility::from($skill[1]));
            foreach ($skill[2] as $class){
                $refName = 'class_' . strtolower($class);

                $classEntity = $this->getReference($refName, CharacterClass::class);
                $skillEntity->addCharacterClass($classEntity);
            }
            $manager->persist($skillEntity);
        }
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            ClassFixtures::class,
        ];
    }
}
