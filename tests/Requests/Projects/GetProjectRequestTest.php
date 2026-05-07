<?php

use NieuwbouwOffice\PhpSdk\Data\Project;
use NieuwbouwOffice\PhpSdk\NieuwbouwOffice;
use NieuwbouwOffice\PhpSdk\Requests\Projects\GetProjectRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('uses the GET method', function () {
    expect((new GetProjectRequest('abc-123'))->getMethod())->toBe(Method::GET);
});

it('stores the uuid on a public property', function () {
    expect((new GetProjectRequest('abc-123'))->uuid)->toBe('abc-123');
});

it('resolves to the /projects/{uuid}/ endpoint', function () {
    expect((new GetProjectRequest('abc-123'))->resolveEndpoint())
        ->toBe('/projects/abc-123/');
});

it('creates a Project DTO from the response', function () {
    $mockClient = new MockClient([
        GetProjectRequest::class => MockResponse::make([
            'data' => [
                'object' => [
                    'Project_UUId' => 'e00afb7a1791a22eb8bca3707687c549',
                    'Project_Titel' => 'De Suikerzijde',
                    'Project_Timestamp' => '2025-12-02 14:43:53',
                ],
            ],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $project = $connector->send(new GetProjectRequest('e00afb7a1791a22eb8bca3707687c549'))->dto();

    expect($project)->toBeInstanceOf(Project::class)
        ->and($project->uuid)->toBe('e00afb7a1791a22eb8bca3707687c549')
        ->and($project->title)->toBe('De Suikerzijde')
        ->and($project->created_at)->toBe('2025-12-02 14:43:53')
        ->and($project->updated_at)->toBe('2025-12-02 14:43:53');
});
