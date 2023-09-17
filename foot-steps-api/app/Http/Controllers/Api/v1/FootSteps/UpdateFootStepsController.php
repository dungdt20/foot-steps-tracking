<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\FootSteps;

use App\Http\Controllers\Controller;
use Domain\FootSteps\Requests\UpdateFootStepsRequest;
use Domain\FootSteps\Services\UpdateFootStepsService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateFootStepsController extends Controller
{
    private UpdateFootStepsService $updateFootStepsService;

    public function __construct(UpdateFootStepsService $updateFootStepsService)
    {
        $this->updateFootStepsService = $updateFootStepsService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function __invoke(Request $request): JsonResponse
    {
        $response = $this->updateFootStepsService->execute(new UpdateFootStepsRequest(
            (int) $request->get("user_id"),
            (string) $request->get("value_date"),
            (int) $request->get("foot_steps"),
        ));

        return $this->sendSuccess(
            __('response.success')
        );
    }
}
