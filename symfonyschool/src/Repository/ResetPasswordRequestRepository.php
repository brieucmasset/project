<?php

namespace App\Repository;

use App\Entity\ResetPasswordRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Persistence\Repository\ResetPasswordRequestRepositoryTrait;
use SymfonyCasts\Bundle\ResetPassword\Persistence\ResetPasswordRequestRepositoryInterface;

/**
 * Classe `ResetPasswordRequestRepository` qui étend `ServiceEntityRepository`. Cette classe gère l'accès aux entités ResetPasswordRequest et implémente l'interface ResetPasswordRequestRepositoryInterface.
 */
class ResetPasswordRequestRepository extends ServiceEntityRepository implements ResetPasswordRequestRepositoryInterface
{
    use ResetPasswordRequestRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResetPasswordRequest::class);
    }

    /**
     * Méthode pour sauvegarder une entité ResetPasswordRequest.
     *
     * @param ResetPasswordRequest $entity L'entité à sauvegarder.
     * @param bool $flush Indique si la sauvegarde doit être suivie d'un flush (true par défaut).
     */
    public function save(ResetPasswordRequest $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Méthode pour supprimer une entité ResetPasswordRequest.
     *
     * @param ResetPasswordRequest $entity L'entité à supprimer.
     * @param bool $flush Indique si la suppression doit être suivie d'un flush (true par défaut).
     */
    public function remove(ResetPasswordRequest $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Méthode pour créer une demande de réinitialisation de mot de passe.
     *
     * @param object $user L'utilisateur associé à la demande.
     * @param \DateTimeInterface $expiresAt La date d'expiration de la demande.
     * @param string $selector Le sélecteur de la demande.
     * @param string $hashedToken Le jeton de la demande haché.
     *
     * @return ResetPasswordRequestInterface Une instance de l'interface ResetPasswordRequestInterface.
     */
    public function createResetPasswordRequest(object $user, \DateTimeInterface $expiresAt, string $selector, string $hashedToken): ResetPasswordRequestInterface
    {
        return new ResetPasswordRequest($user, $expiresAt, $selector, $hashedToken);
    }
}
