<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * Classe `UserRepository` qui étend `ServiceEntityRepository`. Cette classe gère l'accès aux entités User.
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Méthode pour sauvegarder une entité User.
     *
     * @param User $entity L'entité à sauvegarder.
     * @param bool $flush Indique si la sauvegarde doit être suivie d'un flush (true par défaut).
     */
    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Méthode pour supprimer une entité User.
     *
     * @param User $entity L'entité à supprimer.
     * @param bool $flush Indique si la suppression doit être suivie d'un flush (true par défaut).
     */
    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Méthode de l'interface `PasswordUpgraderInterface` utilisée pour mettre à jour automatiquement le mot de passe de l'utilisateur au fil du temps (par exemple, pour ré-hasher le mot de passe).
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }
}
