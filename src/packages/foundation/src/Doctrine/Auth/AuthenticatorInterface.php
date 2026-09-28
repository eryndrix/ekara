<?php declare(strict_types=1);

namespace Foundation\Doctrine\Auth;

use Illuminate\Contracts\Auth\UserProvider;

interface AuthenticatorInterface extends UserProvider {}
