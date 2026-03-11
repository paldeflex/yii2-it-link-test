<?php

namespace app\modules\car\repositories;

use app\modules\car\interfaces\CarRepositoryInterface;
use app\modules\car\entities\CarEntity;
use app\modules\car\entities\CarOptionEntity;
use app\modules\car\mappers\CarDataMapper;
use yii\db\Connection;
use yii\db\Exception;
use yii\db\Query;

class CarRepository implements CarRepositoryInterface
{
    private Connection $db;
    private CarDataMapper $mapper;

    public function __construct(Connection $db, CarDataMapper $mapper)
    {
        $this->db = $db;
        $this->mapper = $mapper;
    }

    /**
     * @throws Exception
     */
    public function save(CarEntity $car): CarEntity
    {
        $this->db->createCommand()->insert('car', [
            'title' => $car->title,
            'description' => $car->description,
            'price' => $car->price,
            'photo_url' => $car->photoUrl,
            'contacts' => $car->contacts,
        ])->execute();

        $car->id = (int)$this->db->getLastInsertID('car_id_seq');

        if ($car->option !== null) {
            $this->saveOption($car->id, $car->option);
        }

        return $this->findById($car->id);
    }

    /**
     * @throws Exception
     */
    private function saveOption(int $carId, CarOptionEntity $option): void
    {
        $this->db->createCommand()->insert('car_option', [
            'car_id' => $carId,
            'brand' => $option->brand,
            'model' => $option->model,
            'year' => $option->year,
            'body' => $option->body,
            'mileage' => $option->mileage,
        ])->execute();
    }

    public function findById(int $id): ?CarEntity
    {
        $row = new Query()
            ->from('car')
            ->where(['id' => $id])
            ->one($this->db);

        if ($row === false) {
            return null;
        }

        $optionRow = new Query()
            ->from('car_option')
            ->where(['car_id' => $id])
            ->one($this->db);

        return $this->mapper->fromRow($row, $optionRow ?: null);
    }

    public function findAll(int $page, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;

        $rows = new Query()
            ->from('car')
            ->orderBy(['created_at' => SORT_DESC])
            ->limit($perPage)
            ->offset($offset)
            ->all($this->db);

        $totalCount = (int)new Query()
            ->from('car')
            ->count('*', $this->db);

        $cars = [];
        foreach ($rows as $row) {
            $optionRow = new Query()
                ->from('car_option')
                ->where(['car_id' => $row['id']])
                ->one($this->db);

            $cars[] = $this->mapper->fromRow($row, $optionRow ?: null);
        }

        return [
            'items' => $cars,
            'total' => $totalCount,
            'page' => $page,
            'per_page' => $perPage,
        ];
    }
}