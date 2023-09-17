<?php

declare(strict_types=1);

namespace Domain\FootSteps\Services;

use Carbon\Carbon;
use Domain\FootSteps\Repositories\FootStepsDailyRepository;
use Domain\FootSteps\Requests\GetFootStepsDailyTopRankRequest;
use Domain\FootSteps\Responses\GetFootStepsResponse;
use Illuminate\Support\Facades\Log;
use Infrastructure\Abstracts\Requests\RequestAbstract;
use Infrastructure\Abstracts\Responses\ResponseAbstract;
use Infrastructure\Abstracts\Services\ServiceAbstract;
use Infrastructure\Util\Redis\Facade\RedisArray;

/**
 * Class GetFootStepsDailyTopRankCacheService
 * @package Domain\FootSteps\Services
 */
class GetFootStepsDailyTopRankCacheService extends ServiceAbstract
{
    /** FOOTSTEPS_DAILY_TOP_RANK_@month_@limit */
    public const FOOTSTEPS_DAILY_TOP_RANK_CACHE_KEY = "FOOTSTEPS_DAILY_TOP_RANK_%s_%s";

    public const FOOTSTEPS_DAILY_TOP_RANK_CACHE_TTL = 60 * 15; // 15 minutes

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
     * @param RequestAbstract|GetFootStepsDailyTopRankRequest|null $request
     * @return ResponseAbstract
     */
    public function execute(RequestAbstract $request = null): ResponseAbstract
    {
        $date = ! empty($request->getDate()) ? $request->getDate() : Carbon::now()->format("Y-m-d");
        $limit = $request->getLimit();

        $key = $this->buildCacheKey($date, $limit);

        try {
            $redisData = RedisArray::has($key) ? RedisArray::get($key) : [];
        } catch (\Throwable $exception) {
            Log::warning($exception->getMessage());

            $data = $this->getFromDb($date, $limit);
            return new GetFootStepsResponse($data);
        }

        if (! empty($redisData)) {
            return new GetFootStepsResponse($redisData);
        }

        $fromDb = $this->getFromDb($date, $limit);

        RedisArray::setEx($key, $fromDb, self::FOOTSTEPS_DAILY_TOP_RANK_CACHE_TTL);

        return new GetFootStepsResponse($fromDb);
    }

    /**
     * @param string $date
     * @param int $limit
     * @return array
     */
    public function getFromDb(string $date, int $limit): array
    {
        $response = $this->footStepsDailyRepository->getTopRankDaily(
            $date,
            $limit
        );

        return [
            "value_date" => $date,
            "items" => $response,
        ];
    }

    /**
     * @param string $date
     * @param int $limit
     * @return string
     */
    protected function buildCacheKey(string $date, int $limit): string
    {
        return sprintf(self::FOOTSTEPS_DAILY_TOP_RANK_CACHE_KEY, $date, $limit);
    }
}
