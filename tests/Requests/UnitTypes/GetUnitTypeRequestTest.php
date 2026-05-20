<?php

use NieuwbouwOffice\PhpSdk\Data\UnitType;
use NieuwbouwOffice\PhpSdk\NieuwbouwOffice;
use NieuwbouwOffice\PhpSdk\Requests\UnitTypes\GetUnitTypeRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('uses the GET method', function () {
    expect((new GetUnitTypeRequest('proj-1', 'unit-9'))->getMethod())->toBe(Method::GET);
});

it('stores the project uuid and uuid on public properties', function () {
    $request = new GetUnitTypeRequest('proj-1', 'unit-9');

    expect($request->projectUuid)->toBe('proj-1')
        ->and($request->uuid)->toBe('unit-9');
});

it('resolves to the project-scoped projectwoningen detail endpoint', function () {
    expect((new GetUnitTypeRequest('proj-1', 'unit-9'))->resolveEndpoint())
        ->toBe('/projects/proj-1/projectwoningen/unit-9/');
});

it('creates a UnitType DTO from the response', function () {
    $mockClient = new MockClient([
        GetUnitTypeRequest::class => MockResponse::make([
            'data' => [
                'object' => [
                    'Projectwoning_UUId' => '631c2a57a0ce5edc989c67d3661f4711',
                    'Projectwoning_Online' => '-1',
                    'Plandeel' => null,
                    'Projectwoning_Titel' => 'Rug-aan-rug woning',
                    'Woning_Type' => 'Tussenwoning',
                    'Projectwoning_Volgorde' => '1',
                    'Projectwoning_Beschrijving_Kort' => null,
                    'Projectwoning_Beschrijving_Lang' => null,
                    'Projectwoning_Beschrijving_HTML' => null,
                    'Projectwoning_Aantal' => '22',
                    'Projectwoning_PrijsVan' => '317600',
                    'Projectwoning_PrijsTot' => '423300',
                    'Projectwoning_KavelOppVan' => null,
                    'Projectwoning_KavelOppTot' => null,
                    'Projectwoning_WoonOppVan' => '79',
                    'Projectwoning_WoonOppTot' => '79',
                    'Projectwoning_InhoudVan' => null,
                    'Projectwoning_InhoudTot' => null,
                    'Projectwoning_SlaapkamersVan' => '2',
                    'Projectwoning_SlaapkamersTot' => '2',
                    'Eigendom' => 'Eigendom',
                    'Huurkoop' => 'Koopwoning',
                    'NrWoningen' => '22',
                    'NrMedia' => '7',
                    'Projectwoning_KamersVan' => null,
                    'Projectwoning_KamersTot' => null,
                ],
            ],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $unitType = $connector->send(new GetUnitTypeRequest('proj-1', '631c2a57a0ce5edc989c67d3661f4711'))->dto();

    expect($unitType)->toBeInstanceOf(UnitType::class)
        ->and($unitType->uuid)->toBe('631c2a57a0ce5edc989c67d3661f4711')
        ->and($unitType->is_online)->toBeTrue()
        ->and($unitType->title)->toBe('Rug-aan-rug woning')
        ->and($unitType->kind)->toBe('Tussenwoning')
        ->and($unitType->order)->toBe(1)
        ->and($unitType->count)->toBe(22)
        ->and($unitType->price_from)->toBe(317600)
        ->and($unitType->price_to)->toBe(423300)
        ->and($unitType->living_area_from)->toBe(79)
        ->and($unitType->bedrooms_from)->toBe(2)
        ->and($unitType->rooms_from)->toBeNull()
        ->and($unitType->ownership)->toBe('Eigendom')
        ->and($unitType->tenure)->toBe('Koopwoning')
        ->and($unitType->home_count)->toBe(22)
        ->and($unitType->media_count)->toBe(7);
});
