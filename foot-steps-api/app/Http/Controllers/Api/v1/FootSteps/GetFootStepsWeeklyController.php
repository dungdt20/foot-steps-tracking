<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\FootSteps;

use App\Http\Controllers\Controller;
use Domain\FootSteps\Requests\GetFootStepsWeeklyRequest;
use Domain\FootSteps\Services\GetFootStepsWeeklyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetFootStepsWeeklyController extends Controller
{
    private GetFootStepsWeeklyService $getFootStepsWeeklyService;

    public function __construct(GetFootStepsWeeklyService $getFootStepsWeeklyService)
    {
        $this->getFootStepsWeeklyService = $getFootStepsWeeklyService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $response = $this->getFootStepsWeeklyService->execute(new GetFootStepsWeeklyRequest(
            (int) $request->get("user_id"),
            $request->get("value_date") ?? ""
        ));

        return $this->sendSuccess(
            __('response.success'),
            $response->data()
        );
    }
}
