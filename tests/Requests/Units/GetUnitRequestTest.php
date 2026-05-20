<?php

use NieuwbouwOffice\PhpSdk\Requests\Units\GetUnitRequest;
use Saloon\Enums\Method;

it('uses the GET method', function () {
    expect((new GetUnitRequest('proj-1', 'unit-9'))->getMethod())->toBe(Method::GET);
});

it('stores the project uuid and uuid on public properties', function () {
    $request = new GetUnitRequest('proj-1', 'unit-9');

    expect($request->projectUuid)->toBe('proj-1')
        ->and($request->uuid)->toBe('unit-9');
});

it('resolves to the project-scoped woningen detail endpoint', function () {
    expect((new GetUnitRequest('proj-1', 'unit-9'))->resolveEndpoint())
        ->toBe('/projects/proj-1/woningen/unit-9/');
});
