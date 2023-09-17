<?php

declare(strict_types=1);

namespace Domain\FootSteps\Repositories;

use Illuminate\Support\Facades\DB;
use Infrastructure\Abstracts\Repositories\RepositoryAbstract;

/**
 * Class FootStepsMonthlyRepository
 * @package Domain\FootSteps\Repositories
 */
class FootStepsMonthlyRepository extends RepositoryAbstract
{
    /**
     * @var string
     */
    protected string $tableName = 'foot_steps_monthly';

    /**
     * @param int $userId
     * @param string $month
     * @return string[]
     */
    public function getFootstepsMonthly(int $userId, string $month): array
    {
        $columns = ['user_id', "value_month", 'steps'];
        $data = DB::table($this->tableName)
            ->select($columns)
            ->where("user_id", "=", $userId)
            ->where("value_month", "=", $month)
            ->first();

        return ! empty($data) ? (array) $data : [];
    }
}
