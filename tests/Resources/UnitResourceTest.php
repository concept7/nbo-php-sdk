<?php

use NieuwbouwOffice\PhpSdk\NieuwbouwOffice;
use NieuwbouwOffice\PhpSdk\Requests\Units\GetUnitRequest;
use NieuwbouwOffice\PhpSdk\Requests\Units\GetUnitsRequest;
use NieuwbouwOffice\PhpSdk\Resources\UnitResource;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Response;

it('list() sends a GetUnitsRequest scoped to the project and returns the response', function () {
    $mockClient = new MockClient([
        GetUnitsRequest::class => MockResponse::make([
            'data' => [
                ['uuid' => 'u1'],
                ['uuid' => 'u2'],
            ],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $response = $connector->units('proj-1')->list();

    expect($response)->toBeInstanceOf(Response::class)
        ->and($response->json())->toBe([
            'data' => [
                ['uuid' => 'u1'],
                ['uuid' => 'u2'],
            ],
        ]);

    $mockClient->assertSent(function ($request) {
        return $request instanceof GetUnitsRequest
            && $request->projectUuid === 'proj-1'
            && $request->resolveEndpoint() === '/projects/proj-1/woningen/';
    });
});

it('get() sends a GetUnitRequest with the right project uuid and uuid', function () {
    $mockClient = new MockClient([
        GetUnitRequest::class => MockResponse::make([
            'uuid' => 'unit-9',
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $response = $connector->units('proj-1')->get('unit-9');

    expect($response)->toBeInstanceOf(Response::class)
        ->and($response->json())->toBe([
            'uuid' => 'unit-9',
        ]);

    $mockClient->assertSent(function ($request) {
        return $request instanceof GetUnitRequest
            && $request->projectUuid === 'proj-1'
            && $request->uuid === 'unit-9'
            && $request->resolveEndpoint() === '/projects/proj-1/woningen/unit-9/';
    });
});

it('can be instantiated directly with a connector and project uuid', function () {
    $connector = new NieuwbouwOffice('test-token');

    expect(new UnitResource($connector, 'proj-1'))->toBeInstanceOf(UnitResource::class);
});
