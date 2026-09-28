<?php declare(strict_types=1);

namespace Foundation\Auth;

use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;

interface UserProviderInterface extends
    AuthorizableContract,
    AuthenticatableContract,
    CanResetPasswordContract,
    MustVerifyEmailContract
{}
