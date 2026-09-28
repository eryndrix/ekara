<?php declare(strict_types=1);

namespace App\Shared\Presentation;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController
{
    /**
     * Provides authorization features.
     */
    use AuthorizesRequests;

    /**
     * Provides job dispatching features.
     */
    use DispatchesJobs;

    /**
     * Provides validation features.
     */
    use ValidatesRequests;
}
