# Laravel Contextual Permissions

Adds contextual role support to [Spatie/laravel-permission](https://github.com/spatie/laravel-permission), allowing roles to be assigned within specific model contexts (e.g. schools, student groups), and permissions to be resolved accordingly.

## 📦 Installation

```bash
composer require bojan-dev/laravel-contextual-permissions

## 🌍 Localization (i18n)

This package supports multiple languages for all console messages and facade responses.

### Available languages

- `en` – English
- `sr` – Serbian (Cyrillic)

You can set the default language in your Laravel app via `config/app.php`:

```php
'locale' => 'sr',
'fallback_locale' => 'en',
