<?php

use NieuwbouwOffice\PhpSdk\Data\UnitType;
use NieuwbouwOffice\PhpSdk\NieuwbouwOffice;
use NieuwbouwOffice\PhpSdk\Requests\UnitTypes\GetUnitTypesRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('uses the GET method', function () {
    expect((new GetUnitTypesRequest('proj-1'))->getMethod())->toBe(Method::GET);
});

it('stores the project uuid on a public property', function () {
    expect((new GetUnitTypesRequest('proj-1'))->projectUuid)->toBe('proj-1');
});

it('resolves to the project-scoped projectwoningen endpoint', function () {
    expect((new GetUnitTypesRequest('proj-1'))->resolveEndpoint())
        ->toBe('/projects/proj-1/projectwoningen/');
});

it('creates an array of UnitType DTOs from the response', function () {
    $mockClient = new MockClient([
        GetUnitTypesRequest::class => MockResponse::make([
            'data' => [
                'objects' => [
                    [
                        'Projectwoning_UUId' => 'dc28a597e2661a3bf7f84737eb1f38c9',
                        'Projectwoning_Online' => '-1',
                        'Projectwoning_Titel' => 'Gezinswoning M',
                        'Woning_Type' => 'Tussenwoning',
                        'Projectwoning_Volgorde' => '2',
                        'Projectwoning_Beschrijving_Kort' => null,
                        'NrWoningen' => '2',
                        'NrMedia' => '6',
                    ],
                    [
                        'Projectwoning_UUId' => 'a8caa9dc5a353a938440361e8005d06d',
                        'Projectwoning_Online' => '-1',
                        'Projectwoning_Titel' => 'Appartement',
                        'Woning_Type' => 'Appartement',
                        'Projectwoning_Volgorde' => '5',
                        'Projectwoning_Beschrijving_Kort' => null,
                        'NrWoningen' => '14',
                        'NrMedia' => '5',
                    ],
                ],
            ],
            'meta' => ['count' => 2],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $unitTypes = $connector->send(new GetUnitTypesRequest('proj-1'))->dto();

    expect($unitTypes)->toBeArray()->toHaveCount(2)
        ->and($unitTypes[0])->toBeInstanceOf(UnitType::class)
        ->and($unitTypes[0]->uuid)->toBe('dc28a597e2661a3bf7f84737eb1f38c9')
        ->and($unitTypes[0]->is_online)->toBeTrue()
        ->and($unitTypes[0]->title)->toBe('Gezinswoning M')
        ->and($unitTypes[0]->kind)->toBe('Tussenwoning')
        ->and($unitTypes[0]->order)->toBe(2)
        ->and($unitTypes[0]->home_count)->toBe(2)
        ->and($unitTypes[0]->media_count)->toBe(6)
        ->and($unitTypes[0]->price_from)->toBeNull()
        ->and($unitTypes[1])->toBeInstanceOf(UnitType::class)
        ->and($unitTypes[1]->uuid)->toBe('a8caa9dc5a353a938440361e8005d06d')
        ->and($unitTypes[1]->title)->toBe('Appartement')
        ->and($unitTypes[1]->kind)->toBe('Appartement')
        ->and($unitTypes[1]->order)->toBe(5)
        ->and($unitTypes[1]->home_count)->toBe(14);
});
