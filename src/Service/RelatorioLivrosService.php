<?php

declare(strict_types=1);

namespace App\Service;

final class RelatorioLivrosService
{
    /**
     * @param iterable<array<string, int|string|null>> $linhas
     */
    public function agruparPorAutor(iterable $linhas): array
    {
        $grupos = [];

        foreach ($linhas as $linha) {
            $autorId = isset($linha['autor_id']) ? (int) $linha['autor_id'] : null;
            $chaveAutor = 'autor_'.($autorId ?? 'sem_cadastro');
            $livroId = (int) $linha['livro_id'];

            $grupos[$chaveAutor] ??= [
                'id' => $autorId,
                'nome' => (string) ($linha['autor_nome'] ?? 'Sem autor cadastrado'),
                'livros' => [],
            ];

            $grupos[$chaveAutor]['livros'][$livroId] ??= [
                'titulo' => (string) $linha['titulo'],
                'editora' => (string) $linha['editora'],
                'edicao' => (int) $linha['edicao'],
                'ano_publicacao' => (string) $linha['ano_publicacao'],
                'valor' => (string) $linha['valor'],
                'assuntos' => [],
            ];

            if (isset($linha['assunto_id'])) {
                $assuntoId = (int) $linha['assunto_id'];

                $grupos[$chaveAutor]['livros'][$livroId]['assuntos'][$assuntoId]
                    = (string) $linha['assunto_descricao'];
            }
        }

        return $grupos;
    }
}
