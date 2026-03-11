<?php

namespace app\modules\car;

use app\modules\car\interfaces\CarRepositoryInterface;
use app\modules\car\interfaces\CarCreateValidatorInterface;
use app\modules\car\repositories\CarRepository;
use app\modules\car\validators\CarCreateValidator;
use app\modules\car\mappers\CarDataMapper;
use app\modules\car\services\CarService;
use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\car\controllers';

    public function init(): void
    {
        parent::init();

        $container = Yii::$container;

        $container->setSingleton(CarDataMapper::class);

        $container->setSingleton(CarRepositoryInterface::class, function () {
            return new CarRepository(
                Yii::$app->db,
                Yii::$container->get(CarDataMapper::class)
            );
        });

        $container->setSingleton(CarCreateValidatorInterface::class, CarCreateValidator::class);

        $container->setSingleton(CarService::class, function () {
            return new CarService(
                Yii::$container->get(CarRepositoryInterface::class)
            );
        });
    }
}