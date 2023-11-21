<?php

namespace App\Repository;

use App\Entity\Discipline;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Classe `DisciplineRepository` qui étend `ServiceEntityRepository`. Cette classe gère l'accès aux entités Discipline.
 */
class DisciplineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Discipline::class);
    }

    /**
     * Méthode pour sauvegarder une entité Discipline.
     *
     * @param Discipline $entity L'entité à sauvegarder.
     * @param bool $flush Indique si la sauvegarde doit être suivie d'un flush (true par défaut).
     */
    public function save(Discipline $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Méthode pour supprimer une entité Discipline.
     *
     * @param Discipline $entity L'entité à supprimer.
     * @param bool $flush Indique si la suppression doit être suivie d'un flush (true par défaut).
     */
    public function remove(Discipline $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
