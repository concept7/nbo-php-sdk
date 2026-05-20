<?php

use NieuwbouwOffice\PhpSdk\Data\Media;
use NieuwbouwOffice\PhpSdk\NieuwbouwOffice;
use NieuwbouwOffice\PhpSdk\Requests\Media\GetMediaRequest;
use NieuwbouwOffice\PhpSdk\Requests\Projects\GetProjectRequest;
use NieuwbouwOffice\PhpSdk\Requests\Units\GetUnitRequest;
use NieuwbouwOffice\PhpSdk\Requests\UnitTypes\GetUnitTypeRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('uses the GET method', function () {
    expect((new GetMediaRequest(new GetProjectRequest('proj-1')))->getMethod())->toBe(Method::GET);
});

it('appends /media/ to the parent project endpoint', function () {
    expect((new GetMediaRequest(new GetProjectRequest('proj-1')))->resolveEndpoint())
        ->toBe('/projects/proj-1/media/');
});

it('appends /media/ to the parent unit-type endpoint', function () {
    expect((new GetMediaRequest(new GetUnitTypeRequest('proj-1', 'type-9')))->resolveEndpoint())
        ->toBe('/projects/proj-1/projectwoningen/type-9/media/');
});

it('appends /media/ to the parent unit endpoint', function () {
    expect((new GetMediaRequest(new GetUnitRequest('proj-1', 'unit-9')))->resolveEndpoint())
        ->toBe('/projects/proj-1/woningen/unit-9/media/');
});

it('creates an array of Media DTOs from the response', function () {
    $mockClient = new MockClient([
        GetMediaRequest::class => MockResponse::make([
            'data' => [
                'objects' => [
                    [
                        'Media_UUId' => 'f40985b31bf3ef6e78dded76be712c0e',
                        'Media_Filename' => '33800-ext-02-appartementen-klein.jpg',
                        'Media_Titel' => null,
                        'Media_Extensie' => 'jpg',
                        'Media_Timestamp' => '2025-12-02 14:43:30',
                        'URL' => '//static.nbo.nl//media/f4/f40985b31bf3ef6e78dded76be712c0e/O/33800-ext-02-appartementen-klein.jpg',
                        'Label' => 'Algemeen',
                        'Volgorde' => '1',
                    ],
                    [
                        'Media_UUId' => 'ab59d24f8a6204830700e8ecac697d9a',
                        'Media_Filename' => '33800-ext-01-rijwoningen-poort-klein.jpg',
                        'Media_Titel' => null,
                        'Media_Extensie' => 'jpg',
                        'Media_Timestamp' => '2025-12-02 14:43:30',
                        'URL' => '//static.nbo.nl//media/ab/ab59d24f8a6204830700e8ecac697d9a/O/33800-ext-01-rijwoningen-poort-klein.jpg',
                        'Label' => 'Algemeen',
                        'Volgorde' => '2',
                    ],
                ],
            ],
            'meta' => ['count' => 2],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $media = $connector->send(new GetMediaRequest(new GetProjectRequest('proj-1')))->dto();

    expect($media)->toBeArray()->toHaveCount(2)
        ->and($media[0])->toBeInstanceOf(Media::class)
        ->and($media[0]->uuid)->toBe('f40985b31bf3ef6e78dded76be712c0e')
        ->and($media[0]->filename)->toBe('33800-ext-02-appartementen-klein.jpg')
        ->and($media[0]->extension)->toBe('jpg')
        ->and($media[0]->label)->toBe('Algemeen')
        ->and($media[0]->order)->toBe(1)
        ->and($media[0]->created_at->toDateTimeString())->toBe('2025-12-02 14:43:30')
        ->and($media[1]->order)->toBe(2);
});
