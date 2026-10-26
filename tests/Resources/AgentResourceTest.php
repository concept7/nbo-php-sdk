<?php

use NieuwbouwOffice\PhpSdk\Data\Agent;
use NieuwbouwOffice\PhpSdk\Data\Media;
use NieuwbouwOffice\PhpSdk\NieuwbouwOffice;
use NieuwbouwOffice\PhpSdk\Requests\Agents\GetAgentRequest;
use NieuwbouwOffice\PhpSdk\Requests\Agents\GetAgentsRequest;
use NieuwbouwOffice\PhpSdk\Requests\Media\GetMediaRequest;
use NieuwbouwOffice\PhpSdk\Resources\AgentResource;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('list() sends a GetAgentsRequest scoped to the project and returns an array of Agent DTOs', function () {
    $mockClient = new MockClient([
        GetAgentsRequest::class => MockResponse::make([
            'data' => [
                'objects' => [
                    [
                        'Makelaar_UUId' => 'a1',
                        'Rechtspersoon' => 'Agent A',
                    ],
                    [
                        'Makelaar_UUId' => 'a2',
                        'Rechtspersoon' => 'Agent B',
                    ],
                ],
            ],
            'meta' => ['count' => 2],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $agents = $connector->agents('proj-1')->list();

    expect($agents)->toBeArray()->toHaveCount(2)
        ->and($agents[0])->toBeInstanceOf(Agent::class)
        ->and($agents[0]->uuid)->toBe('a1')
        ->and($agents[1]->uuid)->toBe('a2');

    $mockClient->assertSent(function ($request) {
        return $request instanceof GetAgentsRequest
            && $request->projectUuid === 'proj-1'
            && $request->resolveEndpoint() === '/projects/proj-1/makelaars/';
    });
});

it('get() sends a GetAgentRequest with the right project uuid and uuid and returns an Agent DTO', function () {
    $mockClient = new MockClient([
        GetAgentRequest::class => MockResponse::make([
            'data' => [
                'object' => [
                    'Makelaar_UUId' => 'agent-9',
                    'Rechtspersoon' => 'Agent Z',
                    'Email' => 'z@agent.test',
                ],
            ],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $agent = $connector->agents('proj-1')->get('agent-9');

    expect($agent)->toBeInstanceOf(Agent::class)
        ->and($agent->uuid)->toBe('agent-9')
        ->and($agent->name)->toBe('Agent Z')
        ->and($agent->email)->toBe('z@agent.test');

    $mockClient->assertSent(function ($request) {
        return $request instanceof GetAgentRequest
            && $request->projectUuid === 'proj-1'
            && $request->uuid === 'agent-9'
            && $request->resolveEndpoint() === '/projects/proj-1/makelaars/agent-9/';
    });
});

it('media() sends a GetMediaRequest wrapping a GetAgentRequest and returns an array of Media DTOs', function () {
    $mockClient = new MockClient([
        GetMediaRequest::class => MockResponse::make([
            'data' => [
                'objects' => [
                    [
                        'Media_UUId' => 'logo-1',
                        'Media_Filename' => 'logo.jpg',
                        'Media_Titel' => null,
                        'Media_Extensie' => 'jpg',
                        'URL' => '//static.nbo.nl//media/lo/logo-1/O/logo.jpg',
                        'Volgorde' => '1',
                        'Media_Timestamp' => '2023-05-22 15:46:53',
                    ],
                ],
            ],
            'meta' => ['count' => 1],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $media = $connector->agents('proj-1')->media('agent-9');

    expect($media)->toBeArray()->toHaveCount(1)
        ->and($media[0])->toBeInstanceOf(Media::class)
        ->and($media[0]->uuid)->toBe('logo-1')
        ->and($media[0]->label)->toBeNull();

    $mockClient->assertSent(function ($request) {
        return $request instanceof GetMediaRequest
            && $request->resolveEndpoint() === '/projects/proj-1/makelaars/agent-9/media/';
    });
});

it('can be instantiated directly with a connector and project uuid', function () {
    $connector = new NieuwbouwOffice('test-token');

    expect(new AgentResource($connector, 'proj-1'))->toBeInstanceOf(AgentResource::class);
});
