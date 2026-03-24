<?php

namespace App\Controller;

use App\Entity\Character;
use App\Entity\CharacterClass;
use App\Entity\Party;
use App\Entity\Race;
use App\Entity\Skill;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApiController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function app_home() : Response
    {
        return $this->render('home.html.twig');
    }

    // Paths of the api
    #[Route('/api', name: 'api_home')]
    public function api_home() : Response
    {
        return $this->render('api/api.html.twig');
    }


    #[Route('/api/v1/races', name: 'api_v1_races')]
    public function api_v1_races(EntityManagerInterface $entityManager) : Response
    {
        $repository = $entityManager->getRepository(Race::class);
        $races = $repository->findAll();
        return $this->json($races, 200, [], ['groups' => 'character']);
    }

    #[Route('/api/v1/races/{id}', name: 'api_v1_show_race', requirements: ['id' => '\d+'])]
    public function api_v1_shox_race(EntityManagerInterface $entityManager, int $id) : Response
    {
        $repository = $entityManager->getRepository(Race::class);
        $race = $repository->find($id);
        return $this->json($race, 200, [], ['groups' => 'character']);
    }

    #[Route('/api/v1/classes', name: 'api_v1_classes')]
    public function api_v1_classes(EntityManagerInterface $entityManager) : Response
    {
        $repository = $entityManager->getRepository(CharacterClass::class);
        $classes = $repository->findAll();
        return $this->json($classes, 200, [], ['groups' => 'character']);
    }

    #[Route('/api/v1/classes/{id}', name: 'api_v1_show_classes', requirements: ['id' => '\d+'])]
    public function api_v1_shox_classes(EntityManagerInterface $entityManager, int $id) : Response
    {
        $repository = $entityManager->getRepository(CharacterClass::class);
        $classe = $repository->find($id);
        return $this->json($classe, 200, [], ['groups' => 'character']);
    }

    #[Route('/api/v1/characters', name: 'api_v1_characters')]
    public function api_v1_characters(EntityManagerInterface $entityManager) : Response
    {
        $repository = $entityManager->getRepository(Character::class);
        $characters = $repository->findAll();
        return $this->json($characters, 200, [], ['groups' => 'character']);
    }

    #[Route('/api/v1/characters/{id}', name: 'api_v1_show_characters', requirements: ['id' => '\d+'])]
    public function api_v1_shox_characters(EntityManagerInterface $entityManager, int $id) : Response
    {
        $repository = $entityManager->getRepository(Character::class);
        $character = $repository->find($id);
        return $this->json($character, 200, [], ['groups' => 'character']);
    }

    #[Route('/api/v1/parties', name: 'api_v1_party')]
    public function api_v1_party(EntityManagerInterface $entityManager) : Response
    {
        $repository = $entityManager->getRepository(Party::class);
        $party = $repository->findAll();
        return $this->json($party, 200, [], ['groups' => 'character']);
    }

    #[Route('/api/v1/parties/{id}', name: 'api_v1_show_party', requirements: ['id' => '\d+'])]
    public function api_v1_shox_party(EntityManagerInterface $entityManager, int $id) : Response
    {
        $repository = $entityManager->getRepository(Party::class);
        $party = $repository->find($id);
        return $this->json($party, 200, [], ['groups' => 'character']);
    }

    #[Route('/api/v1/skills', name: 'api_v1_skills')]
    public function api_v1_skills(EntityManagerInterface $entityManager) : Response
    {
        $repository = $entityManager->getRepository(Skill::class);
        $skills = $repository->findAll();
        return $this->json($skills, 200, [], ['groups' => 'character']);
    }
}
