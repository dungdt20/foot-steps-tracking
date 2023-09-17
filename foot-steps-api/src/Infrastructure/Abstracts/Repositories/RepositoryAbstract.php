<?php

namespace Infrastructure\Abstracts\Repositories;

use Illuminate\Support\Facades\DB;

/**
 * Class RepositoryAbstract
 * @package Infrastructure\Abstracts\Repositories
 */
abstract class RepositoryAbstract
{
    /**
     * @var string
     */
    protected string $tableName;

    /**
     * @param array $rows
     * @return int
     */
    public function insertOrIgnore(array $rows): int
    {
        return DB::table($this->tableName)->insertOrIgnore($rows);
    }

    /**
     * @param array $conditions
     * @return bool
     */
    public function checkExist(array $conditions): bool
    {
        return DB::table($this->tableName)
            ->where($conditions)
            ->exists();
    }

    /**
     * @param array $data
     * @return bool
     */
    public function insert(array $data): bool
    {
        return DB::table($this->tableName)->insert($data);
    }

    /**
     * @param array $data
     * @return int
     */
    public function insertGetId(array $data): int
    {
        return DB::table($this->tableName)->insertGetId($data);
    }

    /**
     * @param array $conditions
     * @param array $data
     * @return bool
     */
    public function update(array $conditions, array $data): bool
    {
        return (bool)DB::table($this->tableName)
            ->where($conditions)
            ->update($data);
    }

    /**
     * @param array $conditions
     * @return int
     */
    public function delete(array $conditions): int
    {
        return DB::table($this->tableName)
            ->where($conditions)
            ->delete();
    }
}
