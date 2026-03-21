<?php

namespace App\Controller;

use App\Entity\Character;
use App\Form\CharacterCreationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CharacterController extends AbstractController
{
    // Paths related to the characters

    // Returns the list of all characters of the user
    #[Route('/characters', name: 'character_home')]
    public function character_home() : Response
    {
        return $this->render('character/characters.html.twig');
    }

    #[Route('/character/create', name: 'character_create')]
    public function character_create(Request $request, EntityManagerInterface $entityManager) : Response
    {
        $character = new Character();
        $form = $this->createForm(CharacterCreationFormType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // Add the user into the database
            $entityManager->persist($character);
            $entityManager->flush();

            return $this->redirectToRoute('character_home');
        }

        return $this->render('character/create.html.twig', [
            'creationForm' => $form,
        ]);
    }

}
