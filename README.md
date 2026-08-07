# NieuwbouwOffice PHP SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/concept7/nbo-php-sdk.svg?style=flat-square)](https://packagist.org/packages/concept7/nbo-php-sdk)
[![Tests](https://img.shields.io/github/actions/workflow/status/concept7/nbo-php-sdk/run-tests.yml?branch=0.x&label=tests&style=flat-square)](https://github.com/concept7/nbo-php-sdk/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/concept7/nbo-php-sdk.svg?style=flat-square)](https://packagist.org/packages/concept7/nbo-php-sdk)

A PHP SDK for the [NieuwbouwOffice](https://nieuwbouwoffice.nl) REST API. Built on [Saloon](https://docs.saloon.dev), it ships typed DTOs and enums for projects, unit types, units, and their media so you can work with the API without touching its Dutch JSON keys.

## Installation

You can install the package via composer:

```bash
composer require concept7/nbo-php-sdk
```

## Usage

Instantiate the connector with your API token, then access resources off of it:

```php
use NieuwbouwOffice\PhpSdk\NieuwbouwOffice;

$nbo = new NieuwbouwOffice('your-api-token');

// All projects (returns Project[])
$projects = $nbo->projects()->list();

// A single project (returns Project)
$project = $nbo->projects()->get('e00afb7a1791a22eb8bca3707687c549');
```

Each DTO exposes typed, readonly properties. Dates are parsed into `Carbon\CarbonImmutable` and categorical fields like `Project::$status` are backed by enums (see `NieuwbouwOffice\PhpSdk\Enums\ProjectStatus` and `NieuwbouwOffice\PhpSdk\Enums\UnitStatus`).

### Unit types and units

Both are scoped to a project. `unitTypes()` returns the per-project housing types (e.g. "Tussenwoning"), and `units()` returns the individual homes within those types:

```php
$unitTypes = $nbo->unitTypes($project->uuid)->list();
$unitType  = $nbo->unitTypes($project->uuid)->get($unitTypes[0]->uuid);

$units = $nbo->units($project->uuid)->list();
$unit  = $nbo->units($project->uuid)->get($units[0]->uuid);
```

### Media

Every project, unit type, and unit has an attached media collection (photos, plans, etc.). Each resource exposes a `media()` method that returns `Media[]`:

```php
$projectMedia  = $nbo->projects()->media($project->uuid);
$unitTypeMedia = $nbo->unitTypes($project->uuid)->media($unitType->uuid);
$unitMedia     = $nbo->units($project->uuid)->media($unit->uuid);
```

Those calls return metadata. To fetch the file itself, send a `DownloadMediaRequest`:

```php
use NieuwbouwOffice\PhpSdk\Requests\Media\DownloadMediaRequest;

$contents = (new DownloadMediaRequest($media))->send()->throw()->body();
```

It is a `SoloRequest` rather than a request against the connector: media lives on a separate host and needs no API credentials, so routing it through the connector would resolve the API base URL and send your token to the file host. It also normalises the protocol-relative `//static.nbo.nl/...` URLs the API returns, which are not fetchable as-is.

### Overriding the base URL

The connector defaults to the production base URL. Pass a second argument to point at a staging or local environment:

```php
$nbo = new NieuwbouwOffice('your-api-token', 'https://staging.nbo.nl/rest');
```

## Documentation

### Resources

All resources hang off the `NieuwbouwOffice` connector and return typed DTOs from `NieuwbouwOffice\PhpSdk\Data`.

| Call | HTTP request | Returns |
|---|---|---|
| `$nbo->projects()->list()` | `GET /projects/` | `Project[]` |
| `$nbo->projects()->get($uuid)` | `GET /projects/{uuid}/` | `Project` |
| `$nbo->unitTypes($projectUuid)->list()` | `GET /projects/{projectUuid}/projectwoningen/` | `UnitType[]` |
| `$nbo->unitTypes($projectUuid)->get($uuid)` | `GET /projects/{projectUuid}/projectwoningen/{uuid}/` | `UnitType` |
| `$nbo->units($projectUuid)->list()` | `GET /projects/{projectUuid}/woningen/` | `Unit[]` |
| `$nbo->units($projectUuid)->get($uuid)` | `GET /projects/{projectUuid}/woningen/{uuid}/` | `Unit` |
| `$nbo->projects()->media($uuid)` | `GET /projects/{uuid}/media/` | `Media[]` |
| `$nbo->unitTypes($projectUuid)->media($uuid)` | `GET /projects/{projectUuid}/projectwoningen/{uuid}/media/` | `Media[]` |
| `$nbo->units($projectUuid)->media($uuid)` | `GET /projects/{projectUuid}/woningen/{uuid}/media/` | `Media[]` |

Authentication is handled by the connector via an `apikey`-prefixed `Authorization` header — pass your token to the constructor and Saloon takes care of the rest.

### DTO conventions

- **Readonly value objects.** Every DTO in `src/Data/` uses `public readonly` properties; instantiate them via `Project::fromResponse($array)` (which the request classes do for you), then read.
- **One DTO per resource, list and detail.** Detail-only fields are nullable, so `list()` results return `null` for everything not in the list payload. Look up the full property set in `src/Data/Project.php`, `UnitType.php`, `Unit.php`, and `Media.php`.
- **Shared media endpoint.** All three resources reach `/.../media/` through a single decorating `GetMediaRequest` (`src/Requests/Media/GetMediaRequest.php`) that wraps the parent detail request and appends `media/`. The same `Media` DTO is used regardless of which parent the media belongs to.
- **Downloads bypass the connector.** `DownloadMediaRequest` (`src/Requests/Media/DownloadMediaRequest.php`) is a `SoloRequest` that fetches `Media::$url` directly, normalising protocol-relative URLs to `https`. It deliberately carries no authentication, since the file host is not the API.
- **Casting.** Numeric strings become `int` or `float`; date strings become `Carbon\CarbonImmutable`; the API's `"-1"` / `"0"` booleans become real `bool` (`-1` → `true`, `0` → `false`).
- **Errors.** The connector uses Saloon's `AlwaysThrowOnErrors` trait, so non-2xx responses raise a `Saloon\Exceptions\Request\RequestException` subclass instead of silently returning.

### Enums

Categorical fields are typed where the value set is known. `tryFrom()` is used internally, so unknown values come through as `null` instead of throwing.

| Enum | Backing | Cases | Used by |
|---|---|---|---|
| `NieuwbouwOffice\PhpSdk\Enums\ProjectStatus` | `string` (Dutch label) | 9 | `Project::$status` |
| `NieuwbouwOffice\PhpSdk\Enums\UnitStatus` | `string` (Dutch label) | 14 | `Unit::$status` |

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jan Henk Hazelaar](https://github.com/jhhazelaar)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
