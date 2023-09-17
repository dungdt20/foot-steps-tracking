<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\FootSteps;

use App\Http\Controllers\Controller;
use Domain\FootSteps\Requests\GetFootStepsDailyTopRankRequest;
use Domain\FootSteps\Services\GetFootStepsDailyTopRankCacheService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetFootStepsDailyTopRankController extends Controller
{
    /** @var GetFootStepsDailyTopRankCacheService */
    private GetFootStepsDailyTopRankCacheService $getFootStepsDailyTopRankCacheService;

    /**
     * @param GetFootStepsDailyTopRankCacheService $getFootStepsDailyTopRankCacheService
     */
    public function __construct(GetFootStepsDailyTopRankCacheService $getFootStepsDailyTopRankCacheService)
    {
        $this->getFootStepsDailyTopRankCacheService = $getFootStepsDailyTopRankCacheService;
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $response = $this->getFootStepsDailyTopRankCacheService->execute(new GetFootStepsDailyTopRankRequest(
            $request->get("value_date") ?? "",
            (int) ($request->get("limit") ?? 3)
        ));

        return $this->sendSuccess(
            __('response.success'),
            $response->data()
        );
    }
}
