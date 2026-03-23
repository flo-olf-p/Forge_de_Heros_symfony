<?php

namespace App\Controller;

use App\Entity\Character;
use App\Form\CharacterType;
use App\Repository\CharacterClassRepository;
use App\Repository\CharacterRepository;
use App\Repository\RaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/user/character')]
final class CharacterController extends AbstractController
{
    #[Route(name: 'app_character_index', methods: ['GET'])]
    public function index(CharacterRepository $characterRepository, Request $request, CharacterClassRepository $characterClassRepository, RaceRepository $raceRepository): Response
    {
        $user = $this->getUser();
        $classId = $request->query->get('class');
        $raceId = $request->query->get('race');

        if ($classId)
        {
            $characters = $characterRepository->findBy([
                'user' => $user,
                'class_character' => $classId
            ], ['name' => 'ASC']);
        }
        else
        {
            $characters = $characterRepository->findBy([
                'user' => $user
            ], ['name' => 'ASC']);
        }

        if ($raceId)
        {
            $characters = $characterRepository->findBy([
                'user' => $user,
                'race' => $raceId
            ], ['name' => 'ASC']);
        }
        else
        {
            $characters = $characterRepository->findBy([
                'user' => $user
            ], ['name' => 'ASC']);
        }

        // Returns all the characters created by the connected user, with the option to filter by a class
        return $this->render('character/index.html.twig', [
            'characters' => $characters,
            'classes' => $characterClassRepository->findAll(),
            'races' => $raceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_character_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, #[Autowire('%kernel.project_dir%/public/uploads/avatars')] string $avatarDirectory): Response
    {
        $user = $this->getUser();
        $character = new Character();
        $character->updateHealthPoints();

        $form = $this->createForm(CharacterType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $character->setUser($user);
            /** @var UploadedFile $AvatarFile */
            $AvatarFile = $form->get('avatarFile')->getData();

            if ($AvatarFile)
            {
                $originalFilename = pathinfo($AvatarFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$AvatarFile->guessExtension();

                // Move the file to the directory where avatar are stored
                try
                {
                    $AvatarFile->move($avatarDirectory, $newFilename);
                }
                catch (FileException $e)
                {

                }

                $character->setAvatarFileName($newFilename);
            }

            $entityManager->persist($character);
            $entityManager->flush();

            return $this->redirectToRoute('app_character_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('character/new.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_character_show', methods: ['GET'])]
    public function show(Character $character): Response
    {
        return $this->render('character/show.html.twig', [
            'character' => $character,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_character_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Character $character, EntityManagerInterface $entityManager, #[Autowire('%kernel.project_dir%/public/uploads/avatars')] string $avatarDirectory): Response
    {
        $form = $this->createForm(CharacterType::class, $character);
        $form->handleRequest($request);

        if (!$form->isSubmitted() && $character->getAvatarFileName())
        {
            $form->setData(['avatarFile' => new File($avatarDirectory.DIRECTORY_SEPARATOR.$character->getAvatarFileName())]);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_character_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('character/edit.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_character_delete', methods: ['POST'])]
    public function delete(Request $request, Character $character, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$character->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($character);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_character_index', [], Response::HTTP_SEE_OTHER);
    }
}
