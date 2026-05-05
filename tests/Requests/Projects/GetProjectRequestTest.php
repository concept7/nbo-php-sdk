<?php

use NieuwbouwOffice\PhpSdk\Requests\Projects\GetProjectRequest;
use Saloon\Enums\Method;

it('uses the GET method', function () {
    expect((new GetProjectRequest('abc-123'))->getMethod())->toBe(Method::GET);
});

it('stores the uuid on a public property', function () {
    expect((new GetProjectRequest('abc-123'))->uuid)->toBe('abc-123');
});

it('resolves to the /projects/{uuid}/ endpoint', function () {
    expect((new GetProjectRequest('abc-123'))->resolveEndpoint())
        ->toBe('/projects/abc-123/');
});
