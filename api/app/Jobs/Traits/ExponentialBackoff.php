<?php

declare(strict_types=1);

namespace App\Jobs\Traits;

trait ExponentialBackoff
{
    public $tries = 5;

    public function backoff(): array
    {
        return [1, 10, 60, 300, 600];
    }
}
