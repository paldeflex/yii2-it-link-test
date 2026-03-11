# Инструкция по установке

1. Клонировать репозиторий

`git clone git@github.com:paldeflex/yii2-it-link-test.git`

`cd yii2-it-link-test`

2. Создать файл окружения

`cp .env.example .env`

3. Запустить контейнеры

`docker compose up -d --build`

4. Установить зависимости

`docker compose exec php composer install`

5. Выполнить миграции

`docker compose exec php php yii migrate/up`

6. Открыть в браузере

`http://localhost:8080`