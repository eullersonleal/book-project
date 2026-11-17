<?php

declare(strict_types=1);

namespace App\service;

final class ProcessoService
{
    public function podeEncerrar(string $status): bool
    {
        return $status === 'aberto';
    }
}