<?php

use Carbon\CarbonImmutable;
use NieuwbouwOffice\PhpSdk\Data\Unit;
use NieuwbouwOffice\PhpSdk\NieuwbouwOffice;
use NieuwbouwOffice\PhpSdk\Requests\Units\GetUnitRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('uses the GET method', function () {
    expect((new GetUnitRequest('proj-1', 'unit-9'))->getMethod())->toBe(Method::GET);
});

it('stores the project uuid and uuid on public properties', function () {
    $request = new GetUnitRequest('proj-1', 'unit-9');

    expect($request->projectUuid)->toBe('proj-1')
        ->and($request->uuid)->toBe('unit-9');
});

it('resolves to the project-scoped woningen detail endpoint', function () {
    expect((new GetUnitRequest('proj-1', 'unit-9'))->resolveEndpoint())
        ->toBe('/projects/proj-1/woningen/unit-9/');
});

it('creates a Unit DTO from the response', function () {
    $mockClient = new MockClient([
        GetUnitRequest::class => MockResponse::make([
            'data' => [
                'object' => [
                    'Woning_UUId' => '08562ed46e91768b9fbe38422da510a0',
                    'Projectwoning_UUId' => 'dc28a597e2661a3bf7f84737eb1f38c9',
                    'Woning_Huurkoop' => 'Koop',
                    'Woning_Bouwnr' => '20 - fase 2',
                    'Woning_Status' => 'Verkocht',
                    'Woning_Direct_Beschikbaar' => '0',
                    'Woning_Prijs' => '545800',
                    'Woning_Prijs_Weergeven' => '-1',
                    'Woning_Prijs_Van' => '530000',
                    'Woning_Prijs_Tot' => '550000',
                    'Woning_Prijsrange_Weergeven' => '0',
                    'Woning_Huur_Conditie' => 'per maand',
                    'Woning_WoonOpp' => '111.00',
                    'Woning_Slaapkamers' => '3',
                    'Woning_Online' => '-1',
                    'Woning_Tuinligging' => 'noord',
                    'Woning_Parkeerplaats' => 'in buurtstalling',
                    'Woning_Json' => '[]',
                    'Woning_Beschrijving_HTML' => '<p>Ruimte voor het stads(gezins)leven</p>',
                    'Woning_KAO_Getekend' => '0',
                    'Woning_Getransporteerd' => '0',
                    'Woningtype' => 'Tussenwoning',
                    'Fase' => 'regulier fase 2',
                ],
            ],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $unit = $connector->send(new GetUnitRequest('proj-1', '08562ed46e91768b9fbe38422da510a0'))->dto();

    expect($unit)->toBeInstanceOf(Unit::class)
        ->and($unit->uuid)->toBe('08562ed46e91768b9fbe38422da510a0')
        ->and($unit->unit_type_uuid)->toBe('dc28a597e2661a3bf7f84737eb1f38c9')
        ->and($unit->construction_number)->toBe('20 - fase 2')
        ->and($unit->is_online)->toBeTrue()
        ->and($unit->status)->toBe('Verkocht')
        ->and($unit->is_directly_available)->toBeFalse()
        ->and($unit->tenure)->toBe('Koop')
        ->and($unit->price)->toBe(545800)
        ->and($unit->price_from)->toBe(530000)
        ->and($unit->price_to)->toBe(550000)
        ->and($unit->show_price)->toBeTrue()
        ->and($unit->show_price_range)->toBeFalse()
        ->and($unit->rent_condition)->toBe('per maand')
        ->and($unit->living_area)->toBe(111.0)
        ->and($unit->bedrooms)->toBe(3)
        ->and($unit->garden_orientation)->toBe('noord')
        ->and($unit->parking)->toBe('in buurtstalling')
        ->and($unit->json)->toBe('[]')
        ->and($unit->description_html)->toBe('<p>Ruimte voor het stads(gezins)leven</p>')
        ->and($unit->purchase_agreement_signed)->toBeFalse()
        ->and($unit->purchase_agreement_signed_at)->toBeNull()
        ->and($unit->transferred)->toBeFalse()
        ->and($unit->kind)->toBe('Tussenwoning')
        ->and($unit->phase)->toBe('regulier fase 2')
        ->and($unit->cadastral_parcel_number)->toBeNull()
        ->and($unit->leasehold_annual_price)->toBeNull();
});

it('parses dates into CarbonImmutable instances', function () {
    $mockClient = new MockClient([
        GetUnitRequest::class => MockResponse::make([
            'data' => [
                'object' => [
                    'Woning_UUId' => 'u1',
                    'Projectwoning_UUId' => 't1',
                    'Woning_Bouwnr' => '1',
                    'Woning_Datum_Beschikbaar' => '2026-06-01',
                    'Woning_KAO_GetekendOp' => '2026-02-15',
                    'Woning_GetransporteerdOp' => '2026-04-10',
                    'Woning_Bouw_Datum' => '2026-08-01',
                    'Woning_Oplever_Datum' => '2026-12-31',
                ],
            ],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $unit = $connector->send(new GetUnitRequest('proj-1', 'u1'))->dto();

    expect($unit->available_from)->toBeInstanceOf(CarbonImmutable::class)
        ->and($unit->available_from->toDateString())->toBe('2026-06-01')
        ->and($unit->purchase_agreement_signed_at)->toBeInstanceOf(CarbonImmutable::class)
        ->and($unit->purchase_agreement_signed_at->toDateString())->toBe('2026-02-15')
        ->and($unit->transferred_at->toDateString())->toBe('2026-04-10')
        ->and($unit->construction_date->toDateString())->toBe('2026-08-01')
        ->and($unit->delivery_date->toDateString())->toBe('2026-12-31');
});
