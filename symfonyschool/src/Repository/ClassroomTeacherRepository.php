<?php

namespace App\Repository;

use App\Entity\ClassroomTeacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Classe `ClassroomTeacherRepository` qui étend `ServiceEntityRepository`. Cette classe gère l'accès aux entités ClassroomTeacher.
 */
class ClassroomTeacherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClassroomTeacher::class);
    }

    /**
     * Méthode pour sauvegarder une entité ClassroomTeacher.
     *
     * @param ClassroomTeacher $entity L'entité à sauvegarder.
     * @param bool $flush Indique si la sauvegarde doit être suivie d'un flush (true par défaut).
     */
    public function save(ClassroomTeacher $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Méthode pour supprimer une entité ClassroomTeacher.
     *
     * @param ClassroomTeacher $entity L'entité à supprimer.
     * @param bool $flush Indique si la suppression doit être suivie d'un flush (true par défaut).
     */
    public function remove(ClassroomTeacher $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
