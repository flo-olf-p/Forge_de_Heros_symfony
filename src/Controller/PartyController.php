<?php

namespace App\Controller;

use App\Entity\Character;
use App\Entity\Party;
use App\Form\PartyType;
use App\Repository\PartyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user/parties')]
final class PartyController extends AbstractController
{
    #[Route(name: 'app_party_index', methods: ['GET'])]
    public function index(Request $request, PartyRepository $partyRepository): Response
    {

        $filter = $request->query->get('filter');

        if ($filter === 'available') {
            $parties = $partyRepository->findAvailable();
        } elseif ($filter === 'full') {
            $parties = $partyRepository->findFull();
        } else {
            $parties = $partyRepository->findAll();
        }
        return $this->render('party/index.html.twig', [
            'parties' => $parties,
            'filter' => $filter,
        ]);
    }

    #[Route('/new', name: 'app_party_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $party = new Party();
        $form = $this->createForm(PartyType::class, $party, [
            'user' => $this->getUser(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $party = $form->getData();
            $user = $this->getUser();

            $selectedCharacter = $form->get('characters')->getData();
            $party->addCharacter($selectedCharacter);
            $party->addUser($user);

            $entityManager->persist($party);
            $entityManager->flush();

            return $this->redirectToRoute('app_party_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('party/new.html.twig', [
            'party' => $party,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_party_show', methods: ['GET'])]
    public function show(Party $party): Response
    {
        $size = $party->getMaxSize() - $party->getUsers()->count();
        return $this->render('party/show.html.twig', [
            'party' => $party,
            'size' => $size,
        ]);
    }

    #[Route('/{id}/subscribe', name: 'app_party_subscribe', methods: ['GET', 'POST'])]
    public function subscribe(Request $request, Party $party, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $form = $this->createFormBuilder()
            ->add('character', EntityType::class, [
                'class' => Character::class,
                'choice_label' => function (Character $character) {
                    return $character->getName() . ' (' . $character->getClassCharacter()->getName() . ')';
                },
                'query_builder' => function ($repo) use ($user) {
                    return $repo->createQueryBuilder('c')
                        ->where('c.user = :user')
                        ->setParameter('user', $user);
                },
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $character = $form->get('character')->getData();


            if ($party->getCharacters()->contains($character)) {
                $this->addFlash('error', 'Character already in party');
                return $this->redirectToRoute('app_party_show', ['id' => $party->getId()]);
            }

            if ($party->getCharacters()->count() >= $party->getMaxSize()) {
                $this->addFlash('error', 'Party full');
                return $this->redirectToRoute('app_party_show', ['id' => $party->getId()]);
            }


            if ($character->getUser() !== $user) {
                throw $this->createAccessDeniedException();
            }


            $party->addCharacter($character);
            $party->addUser($user);

            $em->flush();

            return $this->redirectToRoute('app_party_show', ['id' => $party->getId()]);
        }

        return $this->render('party/subscribe.html.twig', [
            'form' => $form,
            'party' => $party,
        ]);
    }

    #[Route('/{id}/unsubscribe', name: 'app_party_unsubscribe', methods: ['GET', 'POST'])]
    public function unsubscribe(Request $request, Party $party, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if ($this->isCsrfTokenValid('unsubscribe'.$party->getId(), $request->getPayload()->getString('_token'))) {
            if ($party->getUsers()->contains($user)) {
                foreach ($party->getCharacters() as $character) {
                    if ($character->getUser() === $user) {
                        $party->removeCharacter($character);
                    }
                }

                $party->removeUser($user);
                $entityManager->flush();
                return $this->redirectToRoute('app_party_show', ['id' => $party->getId()]);
            }


            $this->addFlash('error', 'You are not in this party');


        }
        return $this->redirectToRoute('app_party_show', ['id' => $party->getId()]);
    }


    #[Route('/{id}/delete', name: 'app_party_delete', methods: ['POST'])]
    public function delete(Request $request, Party $party, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$party->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($party);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_party_index', [], Response::HTTP_SEE_OTHER);
    }
}
