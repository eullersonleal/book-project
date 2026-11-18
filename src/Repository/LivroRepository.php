<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Livro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livro>
 *
 * @method Livro|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livro|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livro[]    findAll()
 * @method Livro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

final class LivroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livro::class);
    }

    /**
     * @return list<Livro>
     */
    public function listarComRelacionamentos(): array
    {
        return $this->createQueryBuilder('livro')
            ->leftJoin('livro.autores', 'autor')
            ->addSelect('autor')
            ->leftJoin('livro.assuntos', 'assunto')
            ->addSelect('assunto')
            ->orderBy('livro.titulo', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function save(Livro $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Livro $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}