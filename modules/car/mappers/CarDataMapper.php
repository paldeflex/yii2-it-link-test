<?php

namespace app\modules\car\mappers;

use app\modules\car\entities\CarEntity;
use app\modules\car\entities\CarOptionEntity;

class CarDataMapper
{
    public function fromRow(array $row, ?array $optionRow = null): CarEntity
    {
        $option = null;

        if ($optionRow !== null) {
            $option = new CarOptionEntity(
                brand: $optionRow['brand'],
                model: $optionRow['model'],
                year: (int)$optionRow['year'],
                body: $optionRow['body'],
                mileage: (int)$optionRow['mileage'],
                id: (int)$optionRow['id'],
                carId: (int)$optionRow['car_id']
            );
        }

        return new CarEntity(
            title: $row['title'],
            description: $row['description'],
            price: $row['price'],
            photoUrl: $row['photo_url'],
            contacts: $row['contacts'],
            option: $option,
            id: (int)$row['id'],
            createdAt: $row['created_at']
        );
    }
}