<?php

use NieuwbouwOffice\PhpSdk\Data\Project;
use NieuwbouwOffice\PhpSdk\NieuwbouwOffice;
use NieuwbouwOffice\PhpSdk\Requests\Projects\GetProjectRequest;
use NieuwbouwOffice\PhpSdk\Requests\Projects\GetProjectsRequest;
use NieuwbouwOffice\PhpSdk\Resources\ProjectResource;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Response;

it('list() sends a GetProjectsRequest and returns the response', function () {
    $mockClient = new MockClient([
        GetProjectsRequest::class => MockResponse::make([
            'data' => [
                ['uuid' => 'a', 'name' => 'Project A'],
                ['uuid' => 'b', 'name' => 'Project B'],
            ],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $response = $connector->projects()->list();

    expect($response)->toBeInstanceOf(Response::class)
        ->and($response->json())->toBe([
            'data' => [
                ['uuid' => 'a', 'name' => 'Project A'],
                ['uuid' => 'b', 'name' => 'Project B'],
            ],
        ]);

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
