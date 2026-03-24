<?php

namespace App\DataFixtures;

use App\Entity\Race;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RaceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $races = [
          'Humain' => 'Polyvalents et ambitieux, les humains sont la race la plus répandue.',
            'Elfe' => 'Gracieux et longévifs, les elfes possèdent une affinité naturelle avec la magie.',
            'Nain' => 'Robustes et tenaces, les nains sont des artisans et guerriers réputés.',
            'Halfelin' => 'Petits et agiles, les halfelins sont connus pour leur chance et leur discrétion.',
            'Demi-Orc' => 'Forts et endurants, les demi-orcs allient la puissance des orcs à l adaptabilité humaine.',
            'Gnome' => '	Curieux et inventifs, les gnomes excellent dans les domaines de la magie et de la technologie.',
            'Tieffelin' => 'Descendants d une lignée infernale, les tieffelins portent la marque de leur héritage.',
            'Demi-Elfe' => 'Héritant du meilleur des deux mondes, les demi-elfes sont diplomates et polyvalents.'

        ];
        foreach ($races as $name => $description) {
            $race = new Race();
            $race->setName($name);
            $race->setDescription($description);
            $manager->persist($race);


            $manager->flush();
        }
    }
}
