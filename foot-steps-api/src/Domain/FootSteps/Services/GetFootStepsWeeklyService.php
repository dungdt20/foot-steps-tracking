<?php

declare(strict_types=1);

namespace Domain\FootSteps\Services;

use Carbon\Carbon;
use Domain\FootSteps\Repositories\FootStepsDailyRepository;
use Domain\FootSteps\Requests\GetFootStepsWeeklyRequest;
use Domain\FootSteps\Responses\GetFootStepsResponse;
use Infrastructure\Abstracts\Requests\RequestAbstract;
use Infrastructure\Abstracts\Responses\ResponseAbstract;
use Infrastructure\Abstracts\Services\ServiceAbstract;

/**
 * Class GetFootStepsWeeklyService
 * @package Domain\FootSteps\Services
 */
class GetFootStepsWeeklyService extends ServiceAbstract
{
    /** @var FootStepsDailyRepository */
    private FootStepsDailyRepository $footStepsDailyRepository;


    /**
     * @param FootStepsDailyRepository $footStepsDailyRepository
     */
    public function __construct(
        FootStepsDailyRepository $footStepsDailyRepository
    )
    {
        $this->footStepsDailyRepository = $footStepsDailyRepository;
    }

    /**
     * @param RequestAbstract|GetFootStepsWeeklyRequest|null $request
     * @return ResponseAbstract
     */
    public function execute(RequestAbstract $request = null): ResponseAbstract
    {
        $dateTime = ! empty($request->getDate())
            ? Carbon::createFromFormat("Y-m-d", $request->getDate())
            : Carbon::now();

        $response = $this->footStepsDailyRepository->getFootstepsWeekly(
            $request->getUserId(),
            $dateTime
        );

        return new GetFootStepsResponse($response);
    }
}
