# Laravel Contextual Permissions

Adds contextual role support to [Spatie/laravel-permission](https://github.com/spatie/laravel-permission), allowing roles to be assigned within specific model contexts (e.g. schools, student groups), and permissions to be resolved accordingly.

## 📦 Installation

```bash
composer require mbojanks/laravel-contextual-permissions
```

## 🚀 Setup

Add the trait to your User model:

```php
use Mbojanks\ContextualPermissions\Traits\HasContextualRolesAndPermissions;

class User extends Authenticatable
{
    use HasRoles, HasContextualRolesAndPermissions;
}
```

Run the migration:

```bash
php artisan migrate
```

This adds `context_type` and `context_id` to the `model_has_roles` table.

## 🧩 Usage

Assign a role in context

```php
$user->assignRoleInContext('school_manager', $school);
```

Check role in context

```php
$user->hasRoleInContext('school_manager', $school);
```

Get permissions via roles in context

```php
$user->getPermissionsViaRolesInContext($school);
```

Get all permissions in context

```php
$user->getAllPermissionsInContext($school);
```

## 🛠 Artisan Commands

Assign role in context

```bash
php artisan permission:assign-context-role 1 teacher "App\Models\School" 3
```

Check role in context

```bash
php artisan permission:check-context-role 1 teacher "App\Models\School" 3
```

List roles in context

```bash
php artisan permission:list-context-roles 1 "App\Models\School" 3
```

## 📚 License

MIT © Bojan Milosavljević

## 🌍 Localization (i18n)

This package supports multiple languages for all console messages and facade responses.

- `en` – English
- `sr` – Serbian (Cyrillic)

You can set the default language in your Laravel app via `config/app.php`:

```php
'locale' => 'sr',
'fallback_locale' => 'en',
```
