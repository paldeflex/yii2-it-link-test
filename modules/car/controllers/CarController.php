<?php

namespace app\modules\car\controllers;

use app\modules\car\interfaces\CarCreateValidatorInterface;
use app\modules\car\services\CarService;
use yii\base\InvalidConfigException;
use yii\web\Controller;
use yii\web\Response;
use Yii;

class CarController extends Controller
{
    public $enableCsrfValidation = false;

    private CarService $carService;
    private CarCreateValidatorInterface $validator;

    public function __construct(
        $id,
        $module,
        CarService $carService,
        CarCreateValidatorInterface $validator,
        $config = []
    ) {
        $this->carService = $carService;
        $this->validator = $validator;

        parent::__construct($id, $module, $config);
    }

    /**
     * @throws InvalidConfigException
     */
    public function actionCreate(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $data = Yii::$app->request->getBodyParams();

        $errors = $this->validator->validate($data);
        if (!empty($errors)) {
            Yii::$app->response->statusCode = 422;
            return ['errors' => $errors];
        }

        $car = $this->carService->create($data);

        Yii::$app->response->statusCode = 201;
        return $car->toArray();
    }

    public function actionView(int $id): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $car = $this->carService->getById($id);

        if ($car === null) {
            Yii::$app->response->statusCode = 404;
            return ['error' => 'Car not found'];
        }

        return $car->toArray();
    }

    public function actionList(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $page = (int)Yii::$app->request->get('page', 1);
        if ($page < 1) {
            $page = 1;
        }

        return $this->carService->getList($page);
    }
}