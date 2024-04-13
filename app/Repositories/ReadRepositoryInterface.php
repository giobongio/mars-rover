<?php

namespace App\Repositories;

/**
 * @template T
 */
interface ReadRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return T|null
     */
    public function get(int $id);
}
