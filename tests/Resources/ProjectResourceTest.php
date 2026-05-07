<?php

use NieuwbouwOffice\PhpSdk\Data\Project;
use NieuwbouwOffice\PhpSdk\NieuwbouwOffice;
use NieuwbouwOffice\PhpSdk\Requests\Projects\GetProjectRequest;
use NieuwbouwOffice\PhpSdk\Requests\Projects\GetProjectsRequest;
use NieuwbouwOffice\PhpSdk\Resources\ProjectResource;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('list() sends a GetProjectsRequest and returns an array of Project DTOs', function () {
    $mockClient = new MockClient([
        GetProjectsRequest::class => MockResponse::make([
            'data' => [
                'objects' => [
                    [
                        'Project_UUId' => 'a',
                        'Project_Titel' => 'Project A',
                        'Project_Timestamp' => '2025-12-02 14:43:53',
                        'Laatst_Bijgewerkt' => '2025-12-02 14:43:53',
                    ],
                    [
                        'Project_UUId' => 'b',
                        'Project_Titel' => 'Project B',
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

    $projects = $connector->projects()->list();

    expect($projects)->toBeArray()->toHaveCount(2)
        ->and($projects[0])->toBeInstanceOf(Project::class)
        ->and($projects[0]->uuid)->toBe('a')
        ->and($projects[1]->uuid)->toBe('b');

    $mockClient->assertSent(GetProjectsRequest::class);
});

it('get() sends a GetProjectRequest with the given uuid and returns a Project DTO', function () {
    $mockClient = new MockClient([
        GetProjectRequest::class => MockResponse::make([
            'data' => [
                'object' => [
                    'Project_UUId' => 'abc-123',
                    'Project_Titel' => 'Project ABC',
                    'Project_Timestamp' => '2025-12-02 14:43:53',
                ],
            ],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $project = $connector->projects()->get('abc-123');

    expect($project)->toBeInstanceOf(Project::class)
        ->and($project->uuid)->toBe('abc-123')
        ->and($project->title)->toBe('Project ABC');

    $mockClient->assertSent(function ($request) {
        return $request instanceof GetProjectRequest
            && $request->uuid === 'abc-123'
            && $request->resolveEndpoint() === '/projects/abc-123/';
    });
});

it('can be instantiated directly with a connector', function () {
    $connector = new NieuwbouwOffice('test-token');

    expect(new ProjectResource($connector))->toBeInstanceOf(ProjectResource::class);
});
