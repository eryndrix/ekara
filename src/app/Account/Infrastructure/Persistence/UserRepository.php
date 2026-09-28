<?php declare(strict_types=1);

namespace App\Account\Infrastructure\Persistence;

use Doctrine\ORM\EntityManagerInterface;
use App\Account\Domain\Repository\UserRepositoryInterface;
use App\Shared\Domain\Value\Id\UserId;
use App\Account\Domain\Credential\Email\Email;
use App\Account\Domain\User;

final class UserRepository implements UserRepositoryInterface
{
    /**
     * @phpstan-param EntityManagerInterface $entityManager
     */
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * @phpstan-param UserId $id
     * @phpstan-return User|null
     */
    public function findById(UserId $id): ?User
    {
        $qb = $this->entityManager->createQueryBuilder();
        
        /** @phpstan-var User|null $user */
        $user = $qb->select('u')
            ->from(from: User::class, alias: 'u')
            ->where('u.id = :id')
            ->setParameter(key: 'id', value: $id)
            ->getQuery()
            ->getOneOrNullResult();

        return $user;
    }

    /**
     * @phpstan-param Email $email
     * @phpstan-return User|null
     */
    public function findByEmail(Email $email): ?User
    {
        $qb = $this->entityManager->createQueryBuilder();
        
        /** @phpstan-var User|null $user */
        $user = $qb->select('u')
            ->from(from: User::class, alias: 'u')
            ->where('u.email.email = :email')
            ->setParameter(key: 'email', value: (string) $email)
            ->getQuery()
            ->getOneOrNullResult();

        return $user;
    }

    /**
     * @phpstan-param User $user
     * @phpstan-return void
     */
    public function save(User $user): void
    {
        $this->entityManager->persist(object: $user);
    }

    /**
     * @phpstan-param User $user
     * @phpstan-return void
     */
    public function remove(User $user): void
    {
        $this->entityManager->remove(object: $user);
    }
}
