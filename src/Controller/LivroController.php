<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Livro;
use App\Form\LivroType;
use App\Repository\LivroRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\DBAL\Exception\DeadlockException;
use Doctrine\DBAL\Exception\LockWaitTimeoutException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

final class LivroController extends AbstractController
{
    #[Route('/livros', name: 'livros_index', methods: ['GET'])]
    public function index(LivroRepository $livroRepository): Response
    {
        return $this->render('livros/index.html.twig', [
            'livros' => $livroRepository->listarComRelacionamentos(),
        ]);
    }

    #[Route('/livros/novo', name: 'livros_novo', methods: ['GET', 'POST'])]
    public function novo(Request $request, LivroRepository $livroRepository): Response {
        $livro = new Livro();

        $form = $this->createForm(LivroType::class, $livro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $livroRepository->save($livro, true);
            } catch (
                DeadlockException | LockWaitTimeoutException $exception
            ) {
                throw new ServiceUnavailableHttpException(
                    null,
                    'Não foi possível concluir a operação devido a um bloqueio no banco.',
                    $exception,
                );
            }

            $this->addFlash('success', 'Livro cadastrado com sucesso.');

            return $this->redirectToRoute(
                'livros_index',
                [],
                Response::HTTP_SEE_OTHER,
            );
        }

        return $this->render('livros/form.html.twig', [
            'form' => $form,
            'tituloPagina' => 'Novo livro',
        ]);
    }

    #[Route('/livros/{id}/editar', name: 'livros_editar', requirements: ['id' => '\d+'], methods: ['GET', 'POST'],)]
    public function editar(int $id, Request $request, LivroRepository $livroRepository): Response 
    {
        $livro = $livroRepository->find($id);

        if ($livro === null) {
            throw $this->createNotFoundException('Livro não encontrado.');
        }

        $form = $this->createForm(LivroType::class, $livro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $livroRepository->save($livro, true);
            } catch (DeadlockException | LockWaitTimeoutException $exception) {
                throw new ServiceUnavailableHttpException(
                    null,
                    'Não foi possível atualizar o livro devido a um bloqueio no banco.',
                    $exception,
                );
            }

            $this->addFlash('success', 'Livro atualizado com sucesso.');

            return $this->redirectToRoute(
                'livros_index',
                [],
                Response::HTTP_SEE_OTHER,
            );
        }

        return $this->render('livros/form.html.twig', [
            'form' => $form,
            'tituloPagina' => 'Editar livro',
        ]);
    }

    #[Route('/livros/{id}/excluir', name: 'livros_excluir', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function excluir(int $id, Request $request, LivroRepository $livroRepository): Response 
    {
        $token = $request->request->getString('_token');

        if (!$this->isCsrfTokenValid('excluir_livro_'.$id, $token)) {
            throw new AccessDeniedHttpException(
                'Token de segurança inválido.',
            );
        }

        $livro = $livroRepository->find($id);

        if ($livro === null) {
            throw $this->createNotFoundException('Livro não encontrado.');
        }

        try {
            $livroRepository->remove($livro, true);
        } catch (DeadlockException | LockWaitTimeoutException $exception) {
            throw new ServiceUnavailableHttpException(
                null,
                'Não foi possível excluir o livro devido a um bloqueio no banco.',
                $exception,
            );
        }

        $this->addFlash('success', 'Livro excluído com sucesso.');

        return $this->redirectToRoute('livros_index');
    }
}