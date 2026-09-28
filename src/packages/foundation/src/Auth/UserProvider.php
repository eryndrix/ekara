<?php declare(strict_types=1);

namespace Foundation\Auth;

use Foundation\Auth\Access\Authenticatable;
use Foundation\Auth\Access\Authorizable;
use Foundation\Auth\Verification\MustVerifyEmail;
use Foundation\Auth\Verification\CanResetPassword;
use Foundation\Auth\Notification\Notifiable;
use Foundation\Auth\Sanctum\HasApiTokens;

abstract class UserProvider implements UserProviderInterface
{
    /**
     * @var string
     */
    protected const PRIMARY_KEY = 'id';

    /**
     * @var string
     */
    protected const AUTH_PASSWORD_NAME = 'password';

    /**
     * @var string
     */
    protected const REMEMBER_TOKEN_NAME = 'rememberToken';

    /**
     * @var string
     */
    protected const EMAIL_NAME = 'email';

    /**
     * @var string
     */
    protected const EMAIL_VERIFIED_AT_NAME = 'emailVerifiedAt';

    /**
     * Provides authentication.
     */
    use Authenticatable;

    /**
     * Provides authorization.
     */
    use Authorizable;

    /**
     * Provides notifications.
     */
    use Notifiable;

    /**
     * Provides email verification.
     */
    use MustVerifyEmail;

    /**
     * Provides password reset.
     */
    use CanResetPassword;

    /**
     * Provides API tokens.
     */
    use HasApiTokens;
}
