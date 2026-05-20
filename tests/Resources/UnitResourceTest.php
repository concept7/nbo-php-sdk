<?php

use NieuwbouwOffice\PhpSdk\Data\Media;
use NieuwbouwOffice\PhpSdk\Data\Unit;
use NieuwbouwOffice\PhpSdk\NieuwbouwOffice;
use NieuwbouwOffice\PhpSdk\Requests\Media\GetMediaRequest;
use NieuwbouwOffice\PhpSdk\Requests\Units\GetUnitRequest;
use NieuwbouwOffice\PhpSdk\Requests\Units\GetUnitsRequest;
use NieuwbouwOffice\PhpSdk\Resources\UnitResource;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('list() sends a GetUnitsRequest scoped to the project and returns an array of Unit DTOs', function () {
    $mockClient = new MockClient([
        GetUnitsRequest::class => MockResponse::make([
            'data' => [
                'objects' => [
                    [
                        'Woning_UUId' => 'u1',
                        'Projectwoning_UUId' => 't1',
                        'Woning_Bouwnr' => '1',
                    ],
                    [
                        'Woning_UUId' => 'u2',
                        'Projectwoning_UUId' => 't1',
                        'Woning_Bouwnr' => '2',
                    ],
                ],
            ],
            'meta' => ['count' => 2],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $units = $connector->units('proj-1')->list();

    expect($units)->toBeArray()->toHaveCount(2)
        ->and($units[0])->toBeInstanceOf(Unit::class)
        ->and($units[0]->uuid)->toBe('u1')
        ->and($units[1]->uuid)->toBe('u2');

    $mockClient->assertSent(function ($request) {
        return $request instanceof GetUnitsRequest
            && $request->projectUuid === 'proj-1'
            && $request->resolveEndpoint() === '/projects/proj-1/woningen/';
    });
});

it('get() sends a GetUnitRequest with the right project uuid and uuid and returns a Unit DTO', function () {
    $mockClient = new MockClient([
        GetUnitRequest::class => MockResponse::make([
            'data' => [
                'object' => [
                    'Woning_UUId' => 'unit-9',
                    'Projectwoning_UUId' => 'type-1',
                    'Woning_Bouwnr' => '9',
                ],
            ],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $unit = $connector->units('proj-1')->get('unit-9');

    expect($unit)->toBeInstanceOf(Unit::class)
        ->and($unit->uuid)->toBe('unit-9')
        ->and($unit->construction_number)->toBe('9');

    $mockClient->assertSent(function ($request) {
        return $request instanceof GetUnitRequest
            && $request->projectUuid === 'proj-1'
            && $request->uuid === 'unit-9'
            && $request->resolveEndpoint() === '/projects/proj-1/woningen/unit-9/';
    });
});

it('media() sends a GetMediaRequest wrapping a GetUnitRequest and returns an array of Media DTOs', function () {
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

    $media = $connector->units('proj-1')->media('unit-9');

    expect($media)->toBeArray()->toHaveCount(1)
        ->and($media[0])->toBeInstanceOf(Media::class)
        ->and($media[0]->uuid)->toBe('m1');

    $mockClient->assertSent(function ($request) {
        return $request instanceof GetMediaRequest
            && $request->resolveEndpoint() === '/projects/proj-1/woningen/unit-9/media/';
    });
});

it('can be instantiated directly with a connector and project uuid', function () {
    $connector = new NieuwbouwOffice('test-token');

    expect(new UnitResource($connector, 'proj-1'))->toBeInstanceOf(UnitResource::class);
});
