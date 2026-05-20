<?php

use NieuwbouwOffice\PhpSdk\Requests\Units\GetUnitsRequest;
use Saloon\Enums\Method;

it('uses the GET method', function () {
    expect((new GetUnitsRequest('proj-1'))->getMethod())->toBe(Method::GET);
});

it('stores the project uuid on a public property', function () {
    expect((new GetUnitsRequest('proj-1'))->projectUuid)->toBe('proj-1');
});

it('resolves to the project-scoped woningen endpoint', function () {
    expect((new GetUnitsRequest('proj-1'))->resolveEndpoint())
        ->toBe('/projects/proj-1/woningen/');
});
