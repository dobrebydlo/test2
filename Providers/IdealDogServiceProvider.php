<?php

declare(strict_types=1);

namespace App\Modules\ProjectCustoms\Providers;

use App\Modules\ProjectCustoms\Services\IdealDogService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Ideal dog service provider.
 * Registers service in a deferred manner only when someone needs it.
 *
 * Class IdealDogServiceProvider
 * @package App\Modules\ProjectCustoms\Providers
 */
class IdealDogServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register service
     */
    public function register(): void
    {
        $this->app->bind(IdealDogService::class, function () {
            return new IdealDogService();
        });
    }

    /**
     * Provide deferred service list.
     *
     * @return string[]
     */
    public function provides(): array
    {
        return [
            IdealDogService::class,
        ];
    }
}
