<?php

namespace app\modules\car\entities;

class CarOptionEntity
{
    public ?int $id;
    public ?int $carId;
    public string $brand;
    public string $model;
    public int $year;
    public string $body;
    public int $mileage;

    public function __construct(
        string $brand,
        string $model,
        int $year,
        string $body,
        int $mileage,
        ?int $id = null,
        ?int $carId = null
    ) {
        $this->id = $id;
        $this->carId = $carId;
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
        $this->body = $body;
        $this->mileage = $mileage;
    }

    public function toArray(): array
    {
        return [
            'brand' => $this->brand,
            'model' => $this->model,
            'year' => $this->year,
            'body' => $this->body,
            'mileage' => $this->mileage,
        ];
    }
}