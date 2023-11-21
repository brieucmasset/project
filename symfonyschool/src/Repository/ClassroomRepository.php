<?php

namespace App\Repository;

use App\Entity\Classroom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Classe `ClassroomRepository` qui étend `ServiceEntityRepository`. Cette classe gère l'accès aux entités Classroom.
 */
class ClassroomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classroom::class);
    }

    /**
     * Méthode pour sauvegarder une entité Classroom.
     *
     * @param Classroom $entity L'entité à sauvegarder.
     * @param bool $flush Indique si la sauvegarde doit être suivie d'un flush (true par défaut).
     */
    public function save(Classroom $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Méthode pour supprimer une entité Classroom.
     *
     * @param Classroom $entity L'entité à supprimer.
     * @param bool $flush Indique si la suppression doit être suivie d'un flush (true par défaut).
     */
    public function remove(Classroom $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Méthode pour sélectionner les trois dernières entités Classroom ayant un ID supérieur à une valeur donnée.
     *
     * @param mixed $value La valeur de l'ID à partir de laquelle sélectionner les entités.
     * @return array Un tableau d'entités Classroom correspondant à la requête.
     */
    public function select3LastClassroom($value)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM classroom c
            WHERE c.id > :id
            ORDER BY c.id ASC
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $value]);
        return $resultSet->fetchAllAssociative();
    }
}
