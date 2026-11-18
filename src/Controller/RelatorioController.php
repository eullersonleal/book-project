<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\RelatorioRepository;
use App\Service\RelatorioLivrosService;
use Doctrine\DBAL\Exception\ConnectionException;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class RelatorioController extends AbstractController
{
    #[Route('/relatorios/livros', name: 'relatorios_livros', methods: ['GET'])]
    public function livros(
        RelatorioRepository $repository,
        RelatorioLivrosService $service,
    ): Response {
        try {
            $grupos = $service->agruparPorAutor($repository->listarLinhas());
        } catch (ConnectionException $exception) {
            throw new ServiceUnavailableHttpException(
                null,
                'O banco de dados está temporariamente indisponível.',
                $exception,
            );
        }

        $html = $this->renderView('relatorios/livros.html.twig', [
            'grupos' => $grupos,
        ]);

        $options = new Options();
        $options->setDefaultFont('DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return new Response($dompdf->output(), Response::HTTP_OK, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="livros-por-autor.pdf"',
        ]);
    }
}
