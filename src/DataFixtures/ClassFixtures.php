<?php

namespace App\DataFixtures;

use App\Entity\CharacterClass;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClassFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $characterClasss = [
            ["Barbare",12,"Guerrier sauvage animé par une rage dévastatrice."],
            ["Barde", 8, "Artiste et conteur dont la musique possède un pouvoir magique."],
            ["Clerc", 8,"Serviteur divin canalisant la puissance de sa divinité."],
            ["Druide",	8,	"Gardien de la nature capable de se métamorphoser."],
            ["Guerrier",	10,	"Maître des armes et des tactiques de combat."],
            ["Mage"	,6,	"Érudit de l'arcane maîtrisant de puissants sortilèges."],
            ["Paladin",	10,	"Chevalier sacré combinant prouesse martiale et magie divine."],
            ["Ranger",	10,	"Chasseur et pisteur expert des terres sauvages."],
            ["Sorcier",	6,	"Lanceur de sorts dont le pouvoir est inné et instinctif."],
            ["Voleur",	8,	"Spécialiste de la discrétion, du crochetage et des attaques sournoises."]
        ];

        foreach ($characterClasss as $characterClass) {
            $class = new CharacterClass();
            $class->setName($characterClass[0]);
            $class->setHealthDice($characterClass[1]);
            $class->setDescription($characterClass[2]);
            $manager->persist($class);

            $refName = 'class_' . strtolower($characterClass[0]);
            $this->addReference($refName, $class);
        }

        $manager->flush();
    }
}
