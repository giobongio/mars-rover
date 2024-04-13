<?php

namespace App\Repositories;

/**
 * @template T
 */
interface WriteRepositoryInterface
{
    /**
     * @param T $data
     *
     * @return void
     */
    public function save($data): void;

    /**
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void;
}
