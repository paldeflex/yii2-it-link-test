<?php

namespace tests\unit\modules\car\services;

use app\modules\car\entities\CarEntity;
use app\modules\car\entities\CarOptionEntity;
use app\modules\car\interfaces\CarRepositoryInterface;
use app\modules\car\services\CarService;
use Codeception\Test\Unit;

class CarServiceTest extends Unit
{
    private function createMockRepository(): CarRepositoryInterface
    {
        $mock = $this->createMock(CarRepositoryInterface::class);

        $mock->method('save')->willReturnCallback(function (CarEntity $car) {
            $car->id = 1;
            $car->createdAt = '2025-01-01 00:00:00';
            return $car;
        });

        return $mock;
    }

    public function testCreateCarWithoutOptions(): void
    {
        $repository = $this->createMockRepository();
        $service = new CarService($repository);

        $data = [
            'title' => 'Toyota Camry',
            'description' => 'Отличное состояние',
            'price' => '1500000',
            'photo_url' => 'https://example.com/photo.jpg',
            'contacts' => '+7 999 123 45 67',
        ];

        $car = $service->create($data);

        $this->assertInstanceOf(CarEntity::class, $car);
        $this->assertEquals(1, $car->id);
        $this->assertEquals('Toyota Camry', $car->title);
        $this->assertEquals('1500000', $car->price);
        $this->assertNull($car->option);
    }

    public function testCreateCarWithOptions(): void
    {
        $repository = $this->createMockRepository();
        $service = new CarService($repository);

        $data = [
            'title' => 'Honda Civic',
            'description' => 'Продаю срочно',
            'price' => '900000',
            'photo_url' => 'https://example.com/civic.jpg',
            'contacts' => '+7 999 000 00 00',
            'options' => [
                'brand' => 'Honda',
                'model' => 'Civic',
                'year' => 2019,
                'body' => 'sedan',
                'mileage' => 60000,
            ],
        ];

        $car = $service->create($data);

        $this->assertInstanceOf(CarEntity::class, $car);
        $this->assertEquals('Honda Civic', $car->title);
        $this->assertNotNull($car->option);
        $this->assertInstanceOf(CarOptionEntity::class, $car->option);
        $this->assertEquals('Honda', $car->option->brand);
        $this->assertEquals(2019, $car->option->year);
        $this->assertEquals(60000, $car->option->mileage);
    }

    public function testCreateCarWithOptionsAsArray(): void
    {
        $repository = $this->createMockRepository();
        $service = new CarService($repository);

        $data = [
            'title' => 'BMW X5',
            'description' => 'В идеальном состоянии',
            'price' => '3500000',
            'photo_url' => 'https://example.com/bmw.jpg',
            'contacts' => '+7 999 111 22 33',
            'options' => [
                [
                    'brand' => 'BMW',
                    'model' => 'X5',
                    'year' => 2021,
                    'body' => 'suv',
                    'mileage' => 30000,
                ],
            ],
        ];

        $car = $service->create($data);

        $this->assertNotNull($car->option);
        $this->assertEquals('BMW', $car->option->brand);
        $this->assertEquals(2021, $car->option->year);
    }
}