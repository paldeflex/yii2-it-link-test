<?php

namespace app\modules\car\services;

use app\modules\car\entities\CarEntity;
use app\modules\car\entities\CarOptionEntity;
use app\modules\car\interfaces\CarRepositoryInterface;

class CarService
{
    private CarRepositoryInterface $repository;

    public function __construct(CarRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data): CarEntity
    {
        $option = null;

        if (!empty($data['options'])) {
            $opt = $data['options'];
            if (array_is_list($opt)) {
                $opt = $opt[0];
            }
            $option = new CarOptionEntity(
                brand: $opt['brand'],
                model: $opt['model'],
                year: (int)$opt['year'],
                body: $opt['body'],
                mileage: (int)$opt['mileage']
            );
        }

        $car = new CarEntity(
            title: $data['title'],
            description: $data['description'],
            price: $data['price'],
            photoUrl: $data['photo_url'],
            contacts: $data['contacts'],
            option: $option
        );

        return $this->repository->save($car);
    }

    public function getById(int $id): ?CarEntity
    {
        return $this->repository->findById($id);
    }

    public function getList(int $page): array
    {
        $result = $this->repository->findAll($page);

        $items = array_map(function (CarEntity $car) {
            return $car->toArray();
        }, $result['items']);

        return [
            'items' => $items,
            'total' => $result['total'],
            'page' => $result['page'],
            'per_page' => $result['per_page'],
        ];
    }
}