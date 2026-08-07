# Changelog

All notable changes to `nbo-php-sdk` will be documented in this file.

## 0.0.3 - 2026-08-07

### What's Changed

* Add `DownloadMediaRequest` for fetching the file a `Media` DTO points at, by @janhenkhazelaar in https://github.com/concept7/nbo-php-sdk/pull/15

The `media()` methods return metadata only. `DownloadMediaRequest` fetches the bytes, normalising the protocol-relative `//static.nbo.nl/...` URLs the API returns. It is a `SoloRequest`, so no API token is sent to the file host.

**Full Changelog**: https://github.com/concept7/nbo-php-sdk/compare/0.0.2...0.0.3

## 0.0.2 - 2026-05-20

### What's Changed

* Add Media DTO and shared GetMediaRequest by @jhhazelaar in https://github.com/concept7/nbo-php-sdk/pull/12
* Document the media() methods in the README by @jhhazelaar in https://github.com/concept7/nbo-php-sdk/pull/13

**Full Changelog**: https://github.com/concept7/nbo-php-sdk/compare/0.0.1...0.0.2

## 0.0.1 - 2026-05-20

### What's Changed

* Convert NieuwbouwOffice to a Saloon connector by @jhhazelaar in https://github.com/concept7/nbo-php-sdk/pull/1
* Add ProjectResource with list and get by @jhhazelaar in https://github.com/concept7/nbo-php-sdk/pull/2
* Add UnitTypeResource scoped to a project by @jhhazelaar in https://github.com/concept7/nbo-php-sdk/pull/3
* Add Project DTO and return it from project endpoints by @jhhazelaar in https://github.com/concept7/nbo-php-sdk/pull/4
* Add Project DTO and expand it to cover the detail endpoint by @jhhazelaar in https://github.com/concept7/nbo-php-sdk/pull/5
* Add UnitType DTO for list and detail responses by @jhhazelaar in https://github.com/concept7/nbo-php-sdk/pull/6
* Add UnitResource for project-scoped woningen endpoints by @jhhazelaar in https://github.com/concept7/nbo-php-sdk/pull/7
* Add Unit DTO covering list and detail responses by @jhhazelaar in https://github.com/concept7/nbo-php-sdk/pull/8
* Document SDK usage with a real example in the README by @jhhazelaar in https://github.com/concept7/nbo-php-sdk/pull/9
* Add Documentation chapter to the README by @jhhazelaar in https://github.com/concept7/nbo-php-sdk/pull/10
* Update branch references from main to 0.x by @jhhazelaar in https://github.com/concept7/nbo-php-sdk/pull/11

### New Contributors

* @jhhazelaar made their first contribution in https://github.com/concept7/nbo-php-sdk/pull/1

**Full Changelog**: https://github.com/concept7/nbo-php-sdk/commits/0.0.1
