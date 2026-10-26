<?php

use NieuwbouwOffice\PhpSdk\Data\Agent;
use NieuwbouwOffice\PhpSdk\NieuwbouwOffice;
use NieuwbouwOffice\PhpSdk\Requests\Agents\GetAgentsRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('uses the GET method', function () {
    expect((new GetAgentsRequest('proj-1'))->getMethod())->toBe(Method::GET);
});

it('stores the project uuid on a public property', function () {
    expect((new GetAgentsRequest('proj-1'))->projectUuid)->toBe('proj-1');
});

it('resolves to the project-scoped makelaars endpoint', function () {
    expect((new GetAgentsRequest('proj-1'))->resolveEndpoint())
        ->toBe('/projects/proj-1/makelaars/');
});

it('creates an array of Agent DTOs from the response', function () {
    $mockClient = new MockClient([
        GetAgentsRequest::class => MockResponse::make([
            'data' => [
                'objects' => [
                    [
                        'Makelaar_UUId' => '2d94eecf0cb01d24da9be983a060d530',
                        'Rechtspersoon' => 'Makelaardij Het Zuiden',
                        'Adres' => 'Marktstraat 12',
                        'Postcode' => '9712 AB',
                        'Plaats' => 'Groningen',
                        'Landcode' => 'NL',
                    ],
                    [
                        'Makelaar_UUId' => '8f3c1a0b7e6d5c4b3a291807f6e5d4c3',
                        'Rechtspersoon' => 'Woonmakelaars Noord',
                        'Adres' => 'Stationsweg 4',
                        'Postcode' => '9401 KJ',
                        'Plaats' => 'Assen',
                        'Landcode' => 'NL',
                    ],
                ],
            ],
            'meta' => ['count' => 2],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $agents = $connector->send(new GetAgentsRequest('proj-1'))->dto();

    expect($agents)->toBeArray()->toHaveCount(2)
        ->and($agents[0])->toBeInstanceOf(Agent::class)
        ->and($agents[0]->uuid)->toBe('2d94eecf0cb01d24da9be983a060d530')
        ->and($agents[0]->name)->toBe('Makelaardij Het Zuiden')
        ->and($agents[0]->email)->toBeNull()
        ->and($agents[1]->name)->toBe('Woonmakelaars Noord')
        ->and($agents[1]->city)->toBe('Assen');
});

it('returns an empty array when the project has no agents', function () {
    $mockClient = new MockClient([
        GetAgentsRequest::class => MockResponse::make([
            'data' => ['objects' => []],
            'meta' => ['count' => 0],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    expect($connector->send(new GetAgentsRequest('proj-1'))->dto())->toBe([]);
});
