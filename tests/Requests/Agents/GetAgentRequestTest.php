<?php

use NieuwbouwOffice\PhpSdk\Data\Agent;
use NieuwbouwOffice\PhpSdk\NieuwbouwOffice;
use NieuwbouwOffice\PhpSdk\Requests\Agents\GetAgentRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('uses the GET method', function () {
    expect((new GetAgentRequest('proj-1', 'agent-9'))->getMethod())->toBe(Method::GET);
});

it('stores the project uuid and uuid on public properties', function () {
    $request = new GetAgentRequest('proj-1', 'agent-9');

    expect($request->projectUuid)->toBe('proj-1')
        ->and($request->uuid)->toBe('agent-9');
});

it('resolves to the project-scoped makelaars detail endpoint', function () {
    expect((new GetAgentRequest('proj-1', 'agent-9'))->resolveEndpoint())
        ->toBe('/projects/proj-1/makelaars/agent-9/');
});

it('creates an Agent DTO from the response', function () {
    $mockClient = new MockClient([
        GetAgentRequest::class => MockResponse::make([
            'data' => [
                'object' => [
                    'Makelaar_UUId' => '2d94eecf0cb01d24da9be983a060d530',
                    'Rechtspersoon' => 'Makelaardij Het Zuiden',
                    'Adres' => 'Marktstraat 12',
                    'Postcode' => '9712 AB',
                    'Plaats' => 'Groningen',
                    'Landcode' => 'NL',
                    'Post_Adres' => 'Marktstraat 12',
                    'Post_Postcode' => '9712 AB',
                    'Post_Plaats' => 'GRONINGEN',
                    'Post_Landcode' => 'NL',
                    'Email' => 'info@makelaardij.test',
                    'Telefoon' => '0501234567',
                    'URL' => 'http://www.makelaardij.test',
                ],
            ],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $agent = $connector->send(new GetAgentRequest('proj-1', '2d94eecf0cb01d24da9be983a060d530'))->dto();

    expect($agent)->toBeInstanceOf(Agent::class)
        ->and($agent->uuid)->toBe('2d94eecf0cb01d24da9be983a060d530')
        ->and($agent->name)->toBe('Makelaardij Het Zuiden')
        ->and($agent->address)->toBe('Marktstraat 12')
        ->and($agent->postal_code)->toBe('9712 AB')
        ->and($agent->city)->toBe('Groningen')
        ->and($agent->country_code)->toBe('NL')
        ->and($agent->mailing_city)->toBe('GRONINGEN')
        ->and($agent->email)->toBe('info@makelaardij.test')
        ->and($agent->phone)->toBe('0501234567')
        ->and($agent->website_url)->toBe('http://www.makelaardij.test');
});
