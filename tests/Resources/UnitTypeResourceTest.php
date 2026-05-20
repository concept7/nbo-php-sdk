<?php

use NieuwbouwOffice\PhpSdk\Data\Media;
use NieuwbouwOffice\PhpSdk\Data\UnitType;
use NieuwbouwOffice\PhpSdk\NieuwbouwOffice;
use NieuwbouwOffice\PhpSdk\Requests\Media\GetMediaRequest;
use NieuwbouwOffice\PhpSdk\Requests\UnitTypes\GetUnitTypeRequest;
use NieuwbouwOffice\PhpSdk\Requests\UnitTypes\GetUnitTypesRequest;
use NieuwbouwOffice\PhpSdk\Resources\UnitTypeResource;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('list() sends a GetUnitTypesRequest scoped to the project and returns an array of UnitType DTOs', function () {
    $mockClient = new MockClient([
        GetUnitTypesRequest::class => MockResponse::make([
            'data' => [
                'objects' => [
                    [
                        'Projectwoning_UUId' => 'u1',
                        'Projectwoning_Titel' => 'Type A',
                    ],
                    [
                        'Projectwoning_UUId' => 'u2',
                        'Projectwoning_Titel' => 'Type B',
                    ],
                ],
            ],
            'meta' => ['count' => 2],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $unitTypes = $connector->unitTypes('proj-1')->list();

    expect($unitTypes)->toBeArray()->toHaveCount(2)
        ->and($unitTypes[0])->toBeInstanceOf(UnitType::class)
        ->and($unitTypes[0]->uuid)->toBe('u1')
        ->and($unitTypes[1]->uuid)->toBe('u2');

    $mockClient->assertSent(function ($request) {
        return $request instanceof GetUnitTypesRequest
            && $request->projectUuid === 'proj-1'
            && $request->resolveEndpoint() === '/projects/proj-1/projectwoningen/';
    });
});

it('get() sends a GetUnitTypeRequest with the right project uuid and uuid and returns a UnitType DTO', function () {
    $mockClient = new MockClient([
        GetUnitTypeRequest::class => MockResponse::make([
            'data' => [
                'object' => [
                    'Projectwoning_UUId' => 'unit-9',
                    'Projectwoning_Titel' => 'Type Z',
                ],
            ],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $unitType = $connector->unitTypes('proj-1')->get('unit-9');

    expect($unitType)->toBeInstanceOf(UnitType::class)
        ->and($unitType->uuid)->toBe('unit-9')
        ->and($unitType->title)->toBe('Type Z');

    $mockClient->assertSent(function ($request) {
        return $request instanceof GetUnitTypeRequest
            && $request->projectUuid === 'proj-1'
            && $request->uuid === 'unit-9'
            && $request->resolveEndpoint() === '/projects/proj-1/projectwoningen/unit-9/';
    });
});

it('media() sends a GetMediaRequest wrapping a GetUnitTypeRequest and returns an array of Media DTOs', function () {
    $mockClient = new MockClient([
        GetMediaRequest::class => MockResponse::make([
            'data' => [
                'objects' => [
                    [
                        'Media_UUId' => 'm1',
                        'Media_Filename' => 'a.jpg',
                        'Media_Extensie' => 'jpg',
                        'URL' => '//static.nbo.nl/media/m1.jpg',
                        'Label' => 'Algemeen',
                        'Volgorde' => '1',
                        'Media_Timestamp' => '2025-12-02 14:43:30',
                    ],
                ],
            ],
            'meta' => ['count' => 1],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $media = $connector->unitTypes('proj-1')->media('type-9');

    expect($media)->toBeArray()->toHaveCount(1)
        ->and($media[0])->toBeInstanceOf(Media::class)
        ->and($media[0]->uuid)->toBe('m1');

    $mockClient->assertSent(function ($request) {
        return $request instanceof GetMediaRequest
            && $request->resolveEndpoint() === '/projects/proj-1/projectwoningen/type-9/media/';
    });
});

it('can be instantiated directly with a connector and project uuid', function () {
    $connector = new NieuwbouwOffice('test-token');

    expect(new UnitTypeResource($connector, 'proj-1'))->toBeInstanceOf(UnitTypeResource::class);
});
