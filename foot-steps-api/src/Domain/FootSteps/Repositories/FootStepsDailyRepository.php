<?php

declare(strict_types=1);

namespace Domain\FootSteps\Repositories;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Infrastructure\Abstracts\Repositories\RepositoryAbstract;

/**
 * Class FootStepsDailyRepository
 * @package Domain\FootSteps\Repositories
 */
class FootStepsDailyRepository extends RepositoryAbstract
{
    /**
     * @var string
     */
    protected string $tableName = 'foot_steps_daily';

    /**
     * @param int $userId
     * @param string $date
     * @return array
     */
    public function getFootStepsDaily(int $userId, string $date): array
    {
        $columns = ['user_id', "value_date", 'steps'];
        $data = DB::table($this->tableName)
            ->select($columns)
            ->where("user_id", "=", $userId)
            ->where("value_date", "=", $date)
            ->first();

        return ! empty($data) ? (array) $data : [];
    }

    /**
     * @param int $userId
     * @param DateTime|Carbon $date
     * @return array
     */
    public function getFootstepsWeekly(int $userId, DateTime $date): array
    {
        $startOfWeek = $date->startOfWeek()->format("Y-m-d");
        $endOfWeek = $date->endOfWeek()->format("Y-m-d");

        $data = DB::table($this->tableName)
            ->select(
                'user_id',
                DB::raw('sum(steps) steps'),
            )
            ->where("user_id", "=", $userId)
            ->whereBetween(
                'value_date',
                [
                    $startOfWeek,
                    $endOfWeek
                ]
            )
            ->groupBy("user_id")
            ->first();

        return [
            "user_id" => $userId,
            "start_of_week" => $startOfWeek,
            "end_of_week" => $endOfWeek,
            "steps" => ! empty($data) ? (int) $data->steps : 0
        ];
    }

    /**
     * @param string $date
     * @param int $limit
     * @return array
     */
    public function getTopRankDaily(
        string $date,
        int $limit
    ): array {
        $columns = [
            "t.user_id",
            "u.name",
            "t.steps",
        ];

        return DB::table($this->tableName, "t")
            ->select($columns)
            ->join("users as u", "u.id", "=", "t.user_id")
            ->where("value_date", "=", $date)
            ->orderBy("steps", "desc")
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
