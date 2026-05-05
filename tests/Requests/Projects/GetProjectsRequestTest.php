<?php

use NieuwbouwOffice\PhpSdk\Requests\Projects\GetProjectsRequest;
use Saloon\Enums\Method;

it('uses the GET method', function () {
    expect((new GetProjectsRequest)->getMethod())->toBe(Method::GET);
});

it('resolves to the /projects/ endpoint', function () {
    expect((new GetProjectsRequest)->resolveEndpoint())->toBe('/projects/');
});
