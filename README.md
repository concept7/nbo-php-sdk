# NieuwbouwOffice PHP SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/concept7/nbo-php-sdk.svg?style=flat-square)](https://packagist.org/packages/concept7/nbo-php-sdk)
[![Tests](https://img.shields.io/github/actions/workflow/status/concept7/nbo-php-sdk/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/concept7/nbo-php-sdk/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/concept7/nbo-php-sdk.svg?style=flat-square)](https://packagist.org/packages/concept7/nbo-php-sdk)

A PHP SDK for the [NieuwbouwOffice](https://nieuwbouwoffice.nl) REST API. Built on [Saloon](https://docs.saloon.dev), it ships typed DTOs and enums for projects, unit types, and units so you can work with the API without touching its Dutch JSON keys.

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

### Overriding the base URL

The connector defaults to the production base URL. Pass a second argument to point at a staging or local environment:

```php
$nbo = new NieuwbouwOffice('your-api-token', 'https://staging.nbo.nl/rest');
```

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
