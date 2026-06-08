# ReservasCancha — AGENTS.md

## Dev environment

- **Docker only** (no local PHP/composer). The `app` container runs `php:8.1-apache`.
  ```sh
  docker compose up -d
  docker compose exec app php artisan <command>
  ```
- App is served on **http://localhost:8080**.
- **No local database** — uses remote AWS RDS (MySQL). If RDS is unreachable, add a `db` service to `docker-compose.yml` and update `.env`.
- Frontend assets via Vite: `npm run dev` (inside container or host).

## Commands

| Command | Notes |
|---|---|
| `docker compose exec app php artisan migrate:fresh --seed` | Reset DB + seed: admin (`maza@gmail.com` / `123456789`), client (`daniel@gmail.com` / `123456789`) |
| `docker compose exec app php artisan queue:work` | Process queued email jobs (QUEUE_CONNECTION=database) |
| `docker compose exec app php artisan test` | Pest tests (coverage via phpunit.xml includes `app/`) |
| `docker compose exec app php artisan reservas:recordatorios` | Sends match reminders for tomorrow (scheduled daily at 08:00) |

## Key structure

- **Routes:** `routes/web.php` (main app), `routes/auth.php` (auth flows), `routes/api.php` (only `/api/user`). All reservation logic is web-only.
- **Auth:** Laravel UI scaffolding (`Auth::routes()`) + Sanctum API tokens + Spatie Laravel Permission.
- **Roles:** `administrador` and `cliente` — used via `role:administrador` middleware (registered in `app/Http/Kernel.php:66`).
- **Models:** `User` (HasRoles), `Reserva`, `Horario` (schedule slots), `Precio` (pricing), `Pago` (payments), `Resena` (reviews).
- **Queue:** Database-backed, dispatches `EnviarConfirmacionReserva` / `EnviarNotificacionCancelacion` (email jobs).
- **Mail:** Log driver in dev. Markdown mailables: `ReservaConfirmada`, `ReservaCancelada`, `RecordatorioPartido`.
- **QR codes:** External API (`qrserver.com`) — no local QR generation.
- **Scheduled task:** `reservas:recordatorios` runs daily at 08:00 (sends reminders for next day's approved reservations).

## Testing

- **Pest** (with `pestphp/pest-plugin-laravel`). Tests in `tests/` mirror standard Laravel structure.
- `phpunit.xml` has DB connection commented out. Tests use `CACHE_DRIVER=array`, `QUEUE_CONNECTION=sync`, no DB by default. If tests need DB, uncomment the sqlite env vars.
- Run: `docker compose exec app php artisan test`

## Default seed data

| Role | Email | Password |
|---|---|---|
| administrador | maza@gmail.com | 123456789 |
| cliente | daniel@gmail.com | 123456789 |
