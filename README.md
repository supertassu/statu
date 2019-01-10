# Statu

> A self-hosted status page based on Laravel.

![Preview image](docs/preview.png)

## Installing

```bash
git clone git@github.com:supertassu/statu.git
cd statu
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
```

The configuration of Statu is mainly located in `.env` and `config/statu.php`.

Point your web root directory to `public/`.

## Usage

The main admin interface uses the `artisan` CLI tool.

To view the help menu, use

```bash
php artisan list statu
```

## Planned features

- Display monitors on home page
- Incident history
- Admin UI on web
- more stuff
