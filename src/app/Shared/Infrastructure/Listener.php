<?php declare(strict_types=1);

namespace App\Shared\Infrastructure;

use Illuminate\Contracts\Queue\ShouldQueueAfterCommit;
use Illuminate\Queue\InteractsWithQueue;

abstract class Listener implements ShouldQueueAfterCommit
{
    /**
     * Enables queue handling and queue job interaction.
     */
    use InteractsWithQueue;
}
