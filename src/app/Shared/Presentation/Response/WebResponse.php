<?php declare(strict_types=1);

namespace App\Shared\Presentation\Response;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response as View;

final class WebResponse extends Response
{
    /**
     * @phpstan-param string $view
     * @phpstan-param array<string, mixed> $data
     */
    public function __construct(
        private readonly string $view,
        private array $data = []
    ) {
        parent::__construct();
    }

    /**
     * @phpstan-param mixed $request
     * @phpstan-return View
     */
    public function toResponse($request): View
    {
        return response()->view(
            view: $this->view,
            data: $this->data
        );
    }
}
