<?php

declare(strict_types=1);

namespace Domain\FootSteps\Services;

use Carbon\Carbon;
use Domain\FootSteps\Repositories\FootStepsDailyRepository;
use Domain\FootSteps\Repositories\FootStepsMonthlyRepository;
use Domain\FootSteps\Requests\GetFootStepsMonthlyRequest;
use Domain\FootSteps\Responses\GetFootStepsResponse;
use Infrastructure\Abstracts\Requests\RequestAbstract;
use Infrastructure\Abstracts\Responses\ResponseAbstract;
use Infrastructure\Abstracts\Services\ServiceAbstract;
use Infrastructure\Exceptions\SetFunctionNotFoundException;

/**
 * Class GetFootStepsMonthlyService
 * @package Domain\FootSteps\Services
 */
class GetFootStepsMonthlyService extends ServiceAbstract
{

    /** @var FootStepsMonthlyRepository */
    private FootStepsMonthlyRepository $footStepsMonthlyRepository;

    /**
     * @param FootStepsMonthlyRepository $footStepsMonthlyRepository
     */
    public function __construct(
        FootStepsMonthlyRepository $footStepsMonthlyRepository
    )
    {
        $this->footStepsMonthlyRepository = $footStepsMonthlyRepository;
    }

    /**
     * @param RequestAbstract|GetFootStepsMonthlyRequest|null $request
     * @return ResponseAbstract
     */
    public function execute(RequestAbstract $request = null): ResponseAbstract
    {
        $month = ! empty($request->getMonth()) ? $request->getMonth() : Carbon::now()->format("Y-m");

        $response = $this->footStepsMonthlyRepository->getFootstepsMonthly(
            $request->getUserId(),
            $month
        );

        if (empty($response)) {
            $response = [
                'user_id' => $request->getUserId(),
                'value_month' => $month,
                'steps' => 0
            ];
        }

        return new GetFootStepsResponse($response);
    }
}
