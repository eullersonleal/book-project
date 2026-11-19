<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    #[Route('/documentacoes', name: 'documentacoes_index', methods: ['GET'])]
    public function documentacoes(): Response
    {
        return $this->render('documents.html.twig');
    }

    #[Route('/sistema', name: 'sistema_index', methods: ['GET'])]
    public function sistema(): Response
    {
        return $this->render('sistema.html.twig');
    }
}