<?php

use NieuwbouwOffice\PhpSdk\NieuwbouwOffice;
use NieuwbouwOffice\PhpSdk\Requests\UnitTypes\GetUnitTypeRequest;
use NieuwbouwOffice\PhpSdk\Requests\UnitTypes\GetUnitTypesRequest;
use NieuwbouwOffice\PhpSdk\Resources\UnitTypeResource;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Response;

it('list() sends a GetUnitTypesRequest scoped to the project and returns the response', function () {
    $mockClient = new MockClient([
        GetUnitTypesRequest::class => MockResponse::make([
            'data' => [
                ['uuid' => 'u1', 'name' => 'Type A'],
                ['uuid' => 'u2', 'name' => 'Type B'],
            ],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $response = $connector->unitTypes('proj-1')->list();

    expect($response)->toBeInstanceOf(Response::class)
        ->and($response->json())->toBe([
            'data' => [
                ['uuid' => 'u1', 'name' => 'Type A'],
                ['uuid' => 'u2', 'name' => 'Type B'],
            ],
        ]);

    $mockClient->assertSent(function ($request) {
        return $request instanceof GetUnitTypesRequest
            && $request->projectUuid === 'proj-1'
            && $request->resolveEndpoint() === '/projects/proj-1/projectwoningen/';
    });
});

it('get() sends a GetUnitTypeRequest with the right project uuid and uuid', function () {
    $mockClient = new MockClient([
        GetUnitTypeRequest::class => MockResponse::make([
            'uuid' => 'unit-9',
            'name' => 'Type Z',
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $response = $connector->unitTypes('proj-1')->get('unit-9');

    expect($response)->toBeInstanceOf(Response::class)
        ->and($response->json())->toBe([
            'uuid' => 'unit-9',
            'name' => 'Type Z',
        ]);

    $mockClient->assertSent(function ($request) {
        return $request instanceof GetUnitTypeRequest
            && $request->projectUuid === 'proj-1'
            && $request->uuid === 'unit-9'
            && $request->resolveEndpoint() === '/projects/proj-1/projectwoningen/unit-9/';
    });
});

it('can be instantiated directly with a connector and project uuid', function () {
    $connector = new NieuwbouwOffice('test-token');

    expect(new UnitTypeResource($connector, 'proj-1'))->toBeInstanceOf(UnitTypeResource::class);
});
