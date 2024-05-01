# Seragam App

## Requirement

1. php 8.2
2. composer 2.x

## Run on your local mechine

1. Clone repository

```bash
git clone https://github.com/abhipraya-kusuma-dev/seragam-app
cd seragam-app
```

2. Install dependencies

```bash
composer install
npm install
```

3. Copy or rename `.env.example` to `.env`

```bash
cp -r .env.example .env
```

4. Setup your project env

```bash
php artisan key:generate # Generate Laravel APP_KEY

# Edit your database credentials
DB_DATABASE=seragam_app
DB_USERNAME=root
DB_PASSWORD=

php artisan migrate # Migrate database schema
```

5. Run your app

```bash
php artisan serve
```

## Conventional Commit Messages

1. `feat: <message>` for New Features
2. `fix: <message>` for Fixing bug
3. `docs: <message>` for Update README.md

[conventional commit spec](https://www.conventionalcommits.org/en/v1.0.0/)
