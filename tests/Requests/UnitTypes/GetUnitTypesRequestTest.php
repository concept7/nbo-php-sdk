<?php

use NieuwbouwOffice\PhpSdk\Requests\UnitTypes\GetUnitTypesRequest;
use Saloon\Enums\Method;

it('uses the GET method', function () {
    expect((new GetUnitTypesRequest('proj-1'))->getMethod())->toBe(Method::GET);
});

it('stores the project uuid on a public property', function () {
    expect((new GetUnitTypesRequest('proj-1'))->projectUuid)->toBe('proj-1');
});

it('resolves to the project-scoped projectwoningen endpoint', function () {
    expect((new GetUnitTypesRequest('proj-1'))->resolveEndpoint())
        ->toBe('/projects/proj-1/projectwoningen/');
});
