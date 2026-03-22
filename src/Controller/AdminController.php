<?php

namespace App\Controller;

use App\Entity\Race;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    // Paths related to the admin
    #[Route('/admin', name: 'admin_home')]
    public function admin_home() : Response
    {
        return $this->render('admin/admin.html.twig');
    }

    #[Route('/admin/allUsers', name: 'admin_allUsers')]
    public function admin_allUsers(EntityManagerInterface $entityManager) : Response
    {
        $repository = $entityManager->getRepository(User::class);
        $users = $repository->findAll();
        return $this->render('admin/admin_allUsers.html.twig', ['users' => $users]);
    }

}
