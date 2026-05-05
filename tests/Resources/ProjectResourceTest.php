<?php

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

it('get() sends a GetProjectRequest with the given uuid and returns the response', function () {
    $mockClient = new MockClient([
        GetProjectRequest::class => MockResponse::make([
            'uuid' => 'abc-123',
            'name' => 'Project ABC',
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $response = $connector->projects()->get('abc-123');

    expect($response)->toBeInstanceOf(Response::class)
        ->and($response->json())->toBe([
            'uuid' => 'abc-123',
            'name' => 'Project ABC',
        ]);

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
