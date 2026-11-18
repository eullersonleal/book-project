<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Assunto;
use App\Form\AssuntoType;
use App\Repository\AssuntoRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class AssuntoController extends AbstractController
{
    #[Route('/assuntos', name: 'assuntos_index', methods: ['GET'])]
    public function index(AssuntoRepository $assuntoRepository): Response
    {
        $assuntos = $assuntoRepository->findBy([], ['descricao' => 'ASC']);

        return $this->render('assuntos/index.html.twig', [
            'assuntos' => $assuntos,
        ]);
    }

    #[Route('/assuntos/novo', name: 'assuntos_novo', methods: ['GET', 'POST'])]
    public function novo(Request $request, AssuntoRepository $AssuntoRepository): response
    {
        $assunto = new Assunto();

        $form = $this->createForm(AssuntoType::class, $assunto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $AssuntoRepository->save($assunto, true);

            $this->addFlash('success', 'Assunto cadastrado com sucesso.');

            return $this->redirectToRoute('assuntos_index');
        }

        return $this->render('assuntos/novo.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/assuntos/{id}/editar', name: 'assuntos_editar', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function editar(Request $request, AssuntoRepository $AssuntoRepository, int $id): Response
    {
        $assunto = $AssuntoRepository->find($id);

        if(!$assunto) {
            throw $this->createNotFoundException('Assunto não encontrado.');
        }

        $form = $this->createForm(AssuntoType::class, $assunto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $AssuntoRepository->save($assunto, true);

            $this->addFlash('success', 'Assunto atualizado com sucesso.');

            return $this->redirectToRoute('assuntos_index');
        }

        return $this->render('assuntos/editar.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/assuntos/{id}/excluir', name: 'assuntos_excluir', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function excluir(int $id, Request $request, AssuntoRepository $AssuntoRepository): Response 
     {
        $token = $request->request->getString('_token');

        if (!$this->isCsrfTokenValid('excluir_assunto_'.$id, $token)) {
            throw new AccessDeniedHttpException(
                'Token de segurança inválido.',
            );
        }

        $assunto = $AssuntoRepository->find($id);

        if ($assunto === null) {
            throw $this->createNotFoundException('Assunto não encontrado.');
        }

        try {
            $AssuntoRepository->remove($assunto, true);

            $this->addFlash('success', 'Assunto excluído com sucesso.');
        } catch (ForeignKeyConstraintViolationException) {
            $this->addFlash(
                'error',
                'O assunto está associado a livros. Remova essas associações antes de excluí-lo.',
            );
        }

        return $this->redirectToRoute('assuntos_index');
    }
}