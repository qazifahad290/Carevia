# Carevia — Doctor Appointment Booking

A simple, full-stack Laravel web app for booking doctor visits. Built as a healthcare UI project based on a Figma design.

## Features
- Patient registration & login
- Browse doctors by specialty, search, and filter
- View doctor profiles with bio, rating, and price
- Pick a date and time slot, get instant confirmation
- Submit a "Quick Care" open request (matched to a specialty)
- Manage upcoming and past appointments
- Edit patient profile with avatar upload

## Tech Stack
- **Backend:** Laravel 12 (PHP 8.2)
- **Auth:** Laravel Breeze (Blade)
- **Frontend:** Tailwind CSS, Alpine.js, Vite
- **Database:** SQLite (local) / PostgreSQL (production)

## Local Setup
```bash
# Install dependencies
composer install
npm install

# Create SQLite database and seed
php artisan migrate:fresh --seed

# Build front-end
npm run build

# Start the dev server
php artisan serve
```
Open http://127.0.0.1:8000

## Demo Login
After running the seeder:
- **Email:** `patient@demo.com`
- **Password:** `password`

## Test Suite
```bash
php artisan test
```
29 tests covering booking flow, auth, and profile.

## Project Structure
```
app/
  Http/Controllers/   (Home, Doctor, Booking, Appointment, QuickCare, Profile)
  Models/             (User, Doctor, Specialty, Appointment, QuickCareRequest, DoctorSchedule)
database/
  migrations/         (6 tables)
  seeders/            (specialties, doctors, schedules, demo user)
resources/views/      (Blade templates, Tailwind-themed)
routes/web.php        (route definitions)
```

## Design
Color palette is taken from the original Figma design:
- Primary purple: `#5B2EE6`
- Surface: `#F5F4FF`
- Ink: `#0F0B1F`

Logo is a heart + medical cross SVG, defined as reusable Blade components:
- `<x-brand-mark />` — the icon only
- `<x-brand-logo />` — icon + wordmark

## Live Demo
A live demo is available at: **https://carevia.onrender.com**

> Note: Render's free tier sleeps after 15 minutes of inactivity. The first visit may take ~30 seconds to wake up.

## Deployment
The app is configured for one-click deploy to Render via `render.yaml`:
- Provisions a free PostgreSQL database
- Builds with `render-build.sh` (composer + npm + migrate + seed)
- Runs on PHP's built-in dev server

## Notes
- Uploaded avatars (via the profile page) are stored on the local filesystem. On Render's free tier, the filesystem is ephemeral — uploaded avatars will be lost on redeploy. Seeded doctor photos use external URLs (pravatar.cc).
- Demo data includes 6 specialties, 10 doctors, and a demo patient account.
