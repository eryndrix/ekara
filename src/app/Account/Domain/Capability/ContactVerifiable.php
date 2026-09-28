<?php declare(strict_types=1);

namespace App\Account\Domain\Capability;

use App\Account\Domain\Credential\Email\EmailVerifiable;
use App\Account\Domain\Credential\Phone\PhoneVerifiable;

trait ContactVerifiable
{
    /**
     * Email verification capability.
     */
    use EmailVerifiable;

    /**
     * Phone verification capability.
     */
    use PhoneVerifiable;
}
