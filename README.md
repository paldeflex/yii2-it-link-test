# Car Ads API

REST API сервис для управления объявлениями автомобилей на Yii2 + PostgreSQL.

## Стек

- PHP 8
- Yii2 (basic template)
- PostgreSQL
- Docker

## Архитектура

Проект построен по многослойной архитектуре с использованием паттернов:

- **Entity** — объекты предметной области (CarEntity, CarOptionEntity)
- **DataMapper** — преобразование данных из БД в сущности
- **Repository** — доступ к данным через Query Builder
- **Service** — бизнес-логика
- **Validator** — валидация входных данных
- **Controller** — тонкий слой, принимает запрос и отдаёт ответ

Зависимости внедряются через DI-контейнер Yii2 с привязкой к интерфейсам.

## Установка

1. Клонировать репозиторий

```bash
git clone git@github.com:paldeflex/yii2-it-link-test.git
cd yii2-it-link-test
```

2. Создать файл окружения

```bash
cp .env.example .env
```

3. Запустить контейнеры

```bash
docker compose up -d --build
```

4. Установить зависимости

```bash
docker compose exec php composer install
```

5. Выполнить миграции

```bash
docker compose exec php php yii migrate/up
```

## API

### POST /car/create

Создание объявления.

```json
{
  "title": "Toyota Camry",
  "description": "Отличное состояние",
  "price": 1500000,
  "photo_url": "https://example.com/photo.jpg",
  "contacts": "+7 999 123 45 67",
  "options": {
    "brand": "Toyota",
    "model": "Camry",
    "year": 2020,
    "body": "sedan",
    "mileage": 45000
  }
}
```

Поле `options` необязательное (можно передать `null`). Если передаётся, все поля внутри обязательны.

Ответ: `201 Created`

### GET /car/{id}

Получение объявления по ID.

Ответ: `200 OK`

### GET /car/list?page=1

Список объявлений с пагинацией (10 элементов на страницу).

Ответ: `200 OK`

## Тесты

```bash
docker compose exec php vendor/bin/codecept run unit
```