<?php
namespace App\Repositories;

/**
 * Interface BaseRepositoryInterface
 * @package App\Repositories
 */
interface BaseRepositoryInterface
{
    /**
     * @param array $attributes
     */
    public function create(array $attributes);

    /**
     * @param integer $id
     */
    public function find($id);
}
