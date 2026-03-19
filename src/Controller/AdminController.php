<?php

namespace App\Controller;

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
}
