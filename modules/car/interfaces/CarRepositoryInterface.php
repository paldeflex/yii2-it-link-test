<?php

namespace app\modules\car\interfaces;

use app\modules\car\entities\CarEntity;

interface CarRepositoryInterface
{
    public function save(CarEntity $car): CarEntity;

    public function findById(int $id): ?CarEntity;

    public function findAll(int $page, int $perPage = 10): array;
}