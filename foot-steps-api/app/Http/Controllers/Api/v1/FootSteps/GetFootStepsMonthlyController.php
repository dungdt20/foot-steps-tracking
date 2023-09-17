<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\FootSteps;

use App\Http\Controllers\Controller;
use Domain\FootSteps\Requests\GetFootStepsMonthlyRequest;
use Domain\FootSteps\Services\GetFootStepsMonthlyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetFootStepsMonthlyController extends Controller
{
    /** @var GetFootStepsMonthlyService */
    private GetFootStepsMonthlyService $getFootStepsMonthlyService;

    /**
     * @param GetFootStepsMonthlyService $getFootStepsMonthlyService
     */
    public function __construct(GetFootStepsMonthlyService $getFootStepsMonthlyService)
    {
        $this->getFootStepsMonthlyService = $getFootStepsMonthlyService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $response = $this->getFootStepsMonthlyService->execute(new GetFootStepsMonthlyRequest(
            (int) $request->get("user_id"),
            $request->get("value_month") ?? ""
        ));

        return $this->sendSuccess(
            __('response.success'),
            $response->data()
        );
    }
}
