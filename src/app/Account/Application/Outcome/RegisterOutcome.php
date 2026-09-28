<?php declare(strict_types=1);

namespace App\Account\Application\Outcome;

use App\Shared\Application\Payload\Envelope;
use App\Account\Application\Context\RegisterContext;
use App\Account\Application\TokenData;

final class RegisterOutcome
{
    /**
     * @phpstan-param RegisterContext $context
     * @phpstan-return Envelope<null>
     */
    public function form(RegisterContext $context): Envelope
    {
        return Envelope::empty();
    }
}
