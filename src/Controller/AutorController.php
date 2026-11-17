<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\AutorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Autor;
use App\Form\AutorType;
use Symfony\Component\HttpFoundation\Request;

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

    #[Route('/autores/novo', name: 'autores_novo', methods: ['GET', 'POST'])]
    public function novo(Request $request, AutorRepository $autorRepository,): Response 
    {
        $autor = new Autor();

        $form = $this->createForm(AutorType::class, $autor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $autorRepository->save($autor, true);

            $this->addFlash('success', 'Autor cadastrado com sucesso.');

            return $this->redirectToRoute(
                'autores_index',
                [],
                Response::HTTP_SEE_OTHER,
            );
        }

        return $this->render('autores/novo.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/autores/{id}/editar', name: 'autores_editar', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function editar(Request $request, AutorRepository $autorRepository, int $id): Response
    {
        $autor = $autorRepository->find($id);

        if (!$autor) {
            throw $this->createNotFoundException('Autor não encontrado.');
        }

        $form = $this->createForm(AutorType::class, $autor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $autorRepository->save($autor, true);

            $this->addFlash('sucess', 'Autor atualizado com sucesso!');

            return $this->redirectToRoute('autores_index');
        }

        return $this->render('autores/editar.html.twig', [
            'form' => $form,
        ]);
    }
}