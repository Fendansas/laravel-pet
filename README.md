# Laravel + Docker + MySQL + Nginx + phpMyAdmin

## Состав

- PHP 8.3 (FPM)
- Composer 2
- Node.js 20
- MySQL 8.0
- Nginx
- phpMyAdmin
- Laravel проект в папке `src/`

---

## Установка и запуск

1. Распакуй архив в папку проекта и создай папку `src/`, если её ещё нет:

```bash
mkdir src
```

2. Создай новый Laravel-проект внутри `src/` (если ещё не установлен):

```bash
docker compose run --rm composer create-project laravel/laravel .
```

3. Скопируй `.env.example` в `.env`:

```bash
cp src/.env.example src/.env
```

4. Настрой `.env` для MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret
```

5. Подними контейнеры:

```bash
docker compose up -d --build
```

---

## Доступ к проекту

- Laravel: [http://localhost:8000](http://localhost:8000)
- phpMyAdmin: [http://localhost:8080](http://localhost:8080)

**Данные для MySQL:**

- Host: `mysql`
- DB: `laravel`
- User: `laravel`
- Password: `secret`

**Root-доступ:**

- User: `root`
- Password: `root`

---

## Работа с Laravel

- Сгенерировать ключ:

```bash
docker compose run --rm artisan key:generate
```

- Выполнить миграции:

```bash
docker compose run --rm artisan migrate
```

- Выполнить сиды:

```bash
docker compose run --rm artisan db:seed
```

- Войти в контейнер `app`:

```bash
docker compose exec app bash
```

---

## Права доступа

Чтобы Laravel мог писать логи и кэш:

```bash
  docker compose exec app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
```

---

## Composer и Artisan

- Composer:

```bash
docker compose run --rm composer install
docker compose run --rm composer update
```

- Artisan:

```bash
docker compose run --rm artisan migrate
docker compose run --rm artisan db:seed
docker compose run --rm artisan tinker
```