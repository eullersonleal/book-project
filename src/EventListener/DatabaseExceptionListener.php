<?php

declare(strict_types=1);

namespace App\EventListener;

use Doctrine\DBAL\Exception\ConnectionException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

#[AsEventListener(event: KernelEvents::EXCEPTION, priority: 10)]
final class DatabaseExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $original = $event->getThrowable();

        if ($original instanceof HttpExceptionInterface) {
            return;
        }

        // A falha de conexão pode estar encapsulada por outra exceção.
        for ($cause = $original; $cause !== null; $cause = $cause->getPrevious()) {
            if ($cause instanceof ConnectionException) {
                $event->setThrowable(new ServiceUnavailableHttpException(
                    null,
                    'Um serviço necessário está temporariamente indisponível.',
                    $original,
                ));

                return;
            }
        }
    }
}
