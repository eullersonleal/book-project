<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\AutorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AutorController extends AbstractController
{
    #[Route('/autores', name: 'autores_index', methods: ['GET'])]
    public function index(AutorRepository $autorRepository): Response
    {
        $autores = $autorRepository->findBy([], ['nome' => 'ASC']);

        return $this->render('autores/index.html.twig', [
            'autores' => $autores,
        ]);
    }
}