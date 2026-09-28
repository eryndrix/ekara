<?php declare(strict_types=1);

namespace App\Account\Domain\Repository;

use App\Shared\Domain\Value\Id\UserId;
use App\Shared\Domain\Repository\UserRepositoryInterface as RepositoryInterface;
use App\Account\Domain\Credential\Email\Email;
use App\Account\Domain\User;

interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * @phpstan-param UserId $id
     * @phpstan-return User|null
     */
    public function findById(UserId $id): ?User;

    /**
     * @phpstan-param Email $email
     * @phpstan-return User|null
     */
    public function findByEmail(Email $email): ?User;
    
    /**
     * @phpstan-param User $user
     * @phpstan-return void
     */
    public function save(User $user): void;
    
    /**
     * @phpstan-param User $user
     * @phpstan-return void
     */
    public function remove(User $user): void;
}
