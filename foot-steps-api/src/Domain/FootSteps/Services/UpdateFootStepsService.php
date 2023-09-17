<?php

declare(strict_types=1);

namespace Domain\FootSteps\Services;

use DateTime;
use Domain\FootSteps\Repositories\FootStepsDailyRepository;
use Domain\FootSteps\Repositories\FootStepsMonthlyRepository;
use Domain\FootSteps\Requests\UpdateFootStepsRequest;
use Domain\FootSteps\Responses\UpdateFootStepsResponse;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Infrastructure\Abstracts\Requests\RequestAbstract;
use Infrastructure\Abstracts\Responses\ResponseAbstract;
use Infrastructure\Abstracts\Services\ServiceAbstract;

/**
 * Class UpdateFootStepsService
 * @package Domain\FootSteps\Services
 */
class UpdateFootStepsService extends ServiceAbstract
{
    /** @var FootStepsDailyRepository */
    private FootStepsDailyRepository $footStepsDailyRepository;

    /** @var FootStepsMonthlyRepository */
    private FootStepsMonthlyRepository $footStepsMonthlyRepository;

    /**
     * @param FootStepsAllRepository $footStepsAllRepository
     * @param FootStepsDailyRepository $footStepsDailyRepository
     * @param FootStepsMonthlyRepository $footStepsMonthlyRepository
     */
    public function __construct(
        FootStepsDailyRepository $footStepsDailyRepository,
        FootStepsMonthlyRepository $footStepsMonthlyRepository
    )
    {
        $this->footStepsDailyRepository = $footStepsDailyRepository;
        $this->footStepsMonthlyRepository = $footStepsMonthlyRepository;
    }

    /**
     * @param RequestAbstract|UpdateFootStepsRequest|null $request
     * @throws Exception
     */
    public function execute(RequestAbstract $request = null): ResponseAbstract
    {
        try {
            DB::beginTransaction();

            $this->updateFootSteps($request);

            DB::commit();
        } catch (Exception $exception) {
            Log::error($exception->getTraceAsString());
            DB::rollBack();

            throw new Exception();
        }

        return new UpdateFootStepsResponse(true);
    }

    /**
     * @param RequestAbstract|UpdateFootStepsRequest $request
     * @return void
     */
    private function updateFootSteps(RequestAbstract $request)
    {
        $userId = $request->getUserId();
        $date = DateTime::createFromFormat("Y-m-d", $request->getDate());
        $requestSteps = $request->getFootSteps();

        if ($requestSteps === 0) {
            return;
        }

        $addedSteps = $this->updateFootStepsDaily($userId, $date, $requestSteps);

        if ($addedSteps > 0) {
            $this->updateFootStepsMonthly($userId, $date, $addedSteps);
        }
    }

    private function updateFootStepsDaily(int $userId, DateTime $date, int $requestSteps): int
    {
        $dateDaily = $date->format("Y-m-d");
        $footStepsDaily = $this->footStepsDailyRepository->getFootStepsDaily($userId, $dateDaily);
        if (empty($footStepsDaily)) {
            $this->footStepsDailyRepository->insert([
                "user_id" => $userId,
                "value_date" => $dateDaily,
                "steps" => $requestSteps,
            ]);

            return $requestSteps;
        }
        $addedSteps = $requestSteps - (int) $footStepsDaily["steps"];

        if ($addedSteps > 0) {
            $this->footStepsDailyRepository->update(
                [
                    "user_id" => $userId,
                    "value_date" => $dateDaily,
                ],
                ["steps" => $requestSteps]
            );
        }

        return $addedSteps;
    }

    private function updateFootStepsMonthly(int $userId, DateTime $date, $addedSteps)
    {
        $month = $date->format("Y-m");
        $footStepsMonthly = $this->footStepsMonthlyRepository->getFootstepsMonthly($userId, $month);
        if (empty($footStepsMonthly)) {
            $this->footStepsMonthlyRepository->insert([
                "user_id" => $userId,
                "value_month" => $month,
                "steps" => $addedSteps,
            ]);
        } else {
            $this->footStepsMonthlyRepository->update(
                [
                    "user_id" => $userId,
                    "value_month" => $month,
                ],
                ["steps" => (int) $footStepsMonthly["steps"] + $addedSteps]
            );
        }
    }
}
