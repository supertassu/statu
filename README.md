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

```bash
# create a new incident
php artisan statu:add-incident

# add an update
php artisan statu:add-incident-update [incident id]
```

## Planned features

- Display monitors on home page
- Incident history
- Admin UI on web
- more stuff
