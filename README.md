# Laravel Docker Project

Этот проект содержит Laravel-приложение, готовое к запуску в Docker.

## Как запустить проект

```bash
   git clone https://github.com/Bronislavson/laravel-docker-project
   cd laravel-docker-project
```

1. Поднимите контейнеры Docker:
```bash
docker-compose up --build
```

2. Выполните миграции:
```bash
docker exec -it project_app
```
```bash
php artisan migrate
```

## Структура проекта
Dockerfile: описание Docker-образа для Laravel.  
docker-compose.yml: настройки контейнеров (приложение и база данных).  
composer.json: зависимости Laravel.


## Доступы:

1. Общий доступ к проекту http://localhost:8876/
2. swagger документация http://localhost:8876/api/documentation
3. насроена работа с БД в phpMyAdmin http://localhost:9292/

## Тестирование

0. Предвариетльно через Seeder создал фейковые данные,  
если необходимо запуск сидера:

```bash
php artisan db:seed
```

1. Postman. Ручное добавление и проверка request и response

2. Написаны Функциональные и Юнит тесты. Для запуска:

```bash
php artisan test
```

## Так же реализовано условие запуска финального билда из Docker контейнера

## Примечание:

Создана дополнительная сущность 'notebook_photos' для хранения  
фото (шестое поле сущности 'notebook'), в следствии чего итоговая  
структура методов выглядит так:  

### для сущности 'notebooks':
1.1. **GET /api/v1/notebooks/**  
1.2. **POST /api/v1/notebooks/**  
1.3. **GET /api/v1/notebooks/{id}/**  
1.4. **PUT /api/v1/notebooks/{id}/**  
1.5. **DELETE /api/v1/notebooks/{id}/**

### для сущности 'notebook_photos':
1.1. **GET /api/v1/notebook-photos/**
1.2. **POST /api/v1/notebook-photos/**
1.3. **GET /api/v1/notebook-photos/{id}/**
1.4. **DELETE /api/v1/notebook-photos/{id}/**

#### Хранение файлов фотографий:
в директории /public/notebook_photos/  
в данную директорию сохраняются, как тестовые фото (.png),  
так и итоговые фото (.jpg)  