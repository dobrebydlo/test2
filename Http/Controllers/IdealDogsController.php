<?php

declare(strict_types=1);

namespace App\Modules\ProjectCustoms\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Modules\ProjectCustoms\Repositories\IdealDogRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Class IdealDogsController
 * @package App\Modules\ProjectCustoms\Http\Controllers\Client
 */
class IdealDogsController extends Controller
{
    /**
     * @param Request $request
     * @param IdealDogRepository $dogs
     * @return JsonResponse
     */
    public function all(Request $request, IdealDogRepository $dogs): JsonResponse
    {
        return response()->json(
            $dogs->getMatching($request->input())
        );
    }
}
