<?php

namespace app\modules\car\validators;

use app\modules\car\interfaces\CarCreateValidatorInterface;

class CarCreateValidator implements CarCreateValidatorInterface
{
    public function validate(array $data): array
    {
        $errors = [];

        $required = [
            'title' => 'Заголовок',
            'description' => 'Описание',
            'price' => 'Цена',
            'photo_url' => 'Ссылка на фото',
            'contacts' => 'Контакты',
        ];

        foreach ($required as $field => $label) {
            if (empty($data[$field])) {
                $errors[] = "Поле «{$label}» обязательно для заполнения.";
            }
        }

        if (isset($data['price']) && !is_numeric($data['price'])) {
            $errors[] = "Поле «Цена» должно быть числом.";
        }

        if (!empty($data['options'])) {
            $opt = $data['options'];

            $optionFields = [
                'brand' => 'Марка',
                'model' => 'Модель',
                'year' => 'Год выпуска',
                'body' => 'Тип кузова',
                'mileage' => 'Пробег',
            ];

            foreach ($optionFields as $field => $label) {
                if (empty($opt[$field])) {
                    $errors[] = "Поле «{$label}» обязательно при указании характеристик.";
                }
            }

            if (isset($opt['year']) && !is_int($opt['year'])) {
                $errors[] = "Поле «Год выпуска» должно быть целым числом.";
            }

            if (isset($opt['mileage']) && !is_int($opt['mileage'])) {
                $errors[] = "Поле «Пробег» должно быть целым числом.";
            }
        }

        return $errors;
    }
}