<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use app\service\ProcessoService;

final class ProcessoController extends AbstractController
{

    #[Route('/processo', name: 'processo_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('processo/index.html.twig', [
            'controller_name' => 'Lista de processos',
        ]);
    }

    #[Route('/processo/resumo', name: 'processo_resumo', methods: ['GET'])]
    public function resumo(ProcessoService $processoService): Response
    {
        $status = 'aberto';

        return $this->render('processo/resumo.html.twig', [
            'status' => $status,
            'pode_encerrar' => $processoService->podeEncerrar($status),
        ]);
    }
}
