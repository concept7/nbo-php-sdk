<?php

use Carbon\CarbonImmutable;
use NieuwbouwOffice\PhpSdk\Data\Project;
use NieuwbouwOffice\PhpSdk\NieuwbouwOffice;
use NieuwbouwOffice\PhpSdk\Requests\Projects\GetProjectsRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('uses the GET method', function () {
    expect((new GetProjectsRequest)->getMethod())->toBe(Method::GET);
});

it('resolves to the /projects/ endpoint', function () {
    expect((new GetProjectsRequest)->resolveEndpoint())->toBe('/projects/');
});

it('creates an array of Project DTOs from the response', function () {
    $mockClient = new MockClient([
        GetProjectsRequest::class => MockResponse::make([
            'data' => [
                'objects' => [
                    [
                        'Project_UUId' => 'e00afb7a1791a22eb8bca3707687c549',
                        'Project_Parent_UUId' => null,
                        'Project_Titel' => 'De Suikerzijde',
                        'Gemeente' => 'Groningen',
                        'Plaats' => 'Groningen',
                        'Project_Timestamp' => '2025-12-02 14:43:53',
                        'Laatst_Bijgewerkt' => '2025-12-02 14:43:53',
                    ],
                    [
                        'Project_UUId' => 'e51d280c47f8ed8b780adfc1bb25436a',
                        'Project_Parent_UUId' => 'e00afb7a1791a22eb8bca3707687c549',
                        'Project_Titel' => 'Suikerzijde - Hanny van den Horsthof',
                        'Gemeente' => 'Groningen',
                        'Plaats' => 'Groningen',
                        'Project_Timestamp' => '2025-06-12 16:53:48',
                        'Laatst_Bijgewerkt' => '2026-05-07 08:47:23',
                    ],
                ],
            ],
            'meta' => ['count' => 2],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $projects = $connector->send(new GetProjectsRequest)->dto();

    expect($projects)->toBeArray()->toHaveCount(2)
        ->and($projects[0])->toBeInstanceOf(Project::class)
        ->and($projects[0]->uuid)->toBe('e00afb7a1791a22eb8bca3707687c549')
        ->and($projects[0]->parent_uuid)->toBeNull()
        ->and($projects[0]->title)->toBe('De Suikerzijde')
        ->and($projects[0]->municipality)->toBe('Groningen')
        ->and($projects[0]->city)->toBe('Groningen')
        ->and($projects[0]->longitude)->toBeNull()
        ->and($projects[0]->has_purchase)->toBeNull()
        ->and($projects[0]->created_at)->toBeInstanceOf(CarbonImmutable::class)
        ->and($projects[0]->created_at->toDateTimeString())->toBe('2025-12-02 14:43:53')
        ->and($projects[0]->updated_at->toDateTimeString())->toBe('2025-12-02 14:43:53')
        ->and($projects[1])->toBeInstanceOf(Project::class)
        ->and($projects[1]->uuid)->toBe('e51d280c47f8ed8b780adfc1bb25436a')
        ->and($projects[1]->parent_uuid)->toBe('e00afb7a1791a22eb8bca3707687c549')
        ->and($projects[1]->title)->toBe('Suikerzijde - Hanny van den Horsthof')
        ->and($projects[1]->municipality)->toBe('Groningen')
        ->and($projects[1]->city)->toBe('Groningen')
        ->and($projects[1]->created_at->toDateTimeString())->toBe('2025-06-12 16:53:48')
        ->and($projects[1]->updated_at->toDateTimeString())->toBe('2026-05-07 08:47:23');
});
