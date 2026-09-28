<?php declare(strict_types=1);

namespace App\Privilege\Domain;

enum Guard: string
{
    /**
     * API guard for stateless API authentication.
     */
    case Api = 'api';

    /**
     * Web guard for session-based web authentication.
     */
    case Web = 'web';
}
