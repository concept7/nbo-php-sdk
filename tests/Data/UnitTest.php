<?php

use Carbon\CarbonImmutable;
use NieuwbouwOffice\PhpSdk\Data\Unit;

it('exposes its properties as readonly public values', function () {
    $availableFrom = CarbonImmutable::parse('2026-01-15');
    $signedAt = CarbonImmutable::parse('2026-02-01');
    $transferredAt = CarbonImmutable::parse('2026-03-01');
    $constructionDate = CarbonImmutable::parse('2026-04-01');
    $deliveryDate = CarbonImmutable::parse('2026-05-01');

    $unit = new Unit(
        uuid: 'unit-1',
        unit_type_uuid: 'type-1',
        construction_number: '20 - fase 2',
        order: 1,
        is_online: true,
        status: 'Verkocht',
        publication_status: 'gepubliceerd',
        is_directly_available: false,
        available_from: $availableFrom,
        tenure: 'Koop',
        phase: 'regulier fase 2',
        block: 'A',
        address: 'Energieweg 9',
        street: 'Energieweg',
        house_number: '9',
        house_letter: 'A',
        house_number_addition: 'bis',
        postal_code: '9743 AM',
        city: 'Groningen',
        price: 545800,
        show_price: true,
        price_from: 530000,
        price_to: 550000,
        show_price_range: false,
        land_price: 100000,
        construction_cost: 400000,
        service_costs: 50,
        deposit: 1000,
        rent_condition: 'per maand',
        lot_area: 120.5,
        living_area: 111.0,
        water_area: 0.0,
        other_indoor_area: 5.5,
        building_bound_outdoor_area: 8.0,
        external_storage_area: 3.0,
        volume: 320.0,
        bedrooms: 3,
        rooms: 5,
        bathroom_count: 1,
        floor: '1',
        building_layers: 3,
        frontage: 5.4,
        storage: 'eigen berging',
        parking: 'in buurtstalling',
        garage: null,
        garage_area_included: null,
        balcony_area: 6.0,
        balcony_orientation: 'zuid',
        loggia_area: null,
        roof_terrace_area: null,
        terrace_area: 12.0,
        terrace_orientation: 'west',
        garden_orientation: 'noord',
        garden_finish: 'gras',
        garden_width: 4.0,
        garden_length: 8.0,
        garden_area: 32.0,
        lot_width: 5.0,
        lot_length: 24.0,
        kitchen_finish: 'standaard',
        bathroom_finish: 'standaard',
        bathroom_amenities: 'douche, toilet, wastafel',
        living_room_location: 'eerste verdieping',
        other_rooms: null,
        playroom_possible: 'ja',
        extra_bedroom_possible: 'nee',
        sustainable_wood: 'ja',
        gasless: 'ja',
        solar_panels: 'ja',
        heat_pump: 'ja',
        floor_heating: 'ja',
        epc: null,
        energy_label: 'A',
        beng: null,
        kind: 'Tussenwoning',
        kind_text: 'Gezinswoning',
        description: 'beschrijving',
        description_html: '<p>beschrijving</p>',
        extra_info: 'extra info',
        alt_link: null,
        link: 'https://example.com/unit-1',
        map_shape: 'poly',
        map_coords: '1,2,3,4',
        json: '[]',
        purchase_agreement_signed: true,
        purchase_agreement_signed_at: $signedAt,
        transferred: false,
        transferred_at: $transferredAt,
        fallback_buyer: null,
        construction_date: $constructionDate,
        delivery_date: $deliveryDate,
        cadastral_municipality: 'Groningen',
        cadastral_section: 'A',
        cadastral_parcel_number: '123',
        cadastral_area: 150.0,
        cadastral_parcel_number_2: '124',
        cadastral_area_2: 75.0,
        cadastral_extra: null,
        leasehold_annual_price: 500,
        leasehold_buyout_50: 8000,
        leasehold_buyout_perpetual: 16000,
        leasehold_price_total: 20000,
        leasehold_canon_excluding_buyout: 100,
        external_reference: 'EXT-1',
    );

    expect($unit->uuid)->toBe('unit-1')
        ->and($unit->unit_type_uuid)->toBe('type-1')
        ->and($unit->construction_number)->toBe('20 - fase 2')
        ->and($unit->order)->toBe(1)
        ->and($unit->is_online)->toBeTrue()
        ->and($unit->status)->toBe('Verkocht')
        ->and($unit->publication_status)->toBe('gepubliceerd')
        ->and($unit->is_directly_available)->toBeFalse()
        ->and($unit->available_from)->toBe($availableFrom)
        ->and($unit->tenure)->toBe('Koop')
        ->and($unit->phase)->toBe('regulier fase 2')
        ->and($unit->block)->toBe('A')
        ->and($unit->address)->toBe('Energieweg 9')
        ->and($unit->street)->toBe('Energieweg')
        ->and($unit->house_number)->toBe('9')
        ->and($unit->house_letter)->toBe('A')
        ->and($unit->house_number_addition)->toBe('bis')
        ->and($unit->postal_code)->toBe('9743 AM')
        ->and($unit->city)->toBe('Groningen')
        ->and($unit->price)->toBe(545800)
        ->and($unit->show_price)->toBeTrue()
        ->and($unit->price_from)->toBe(530000)
        ->and($unit->price_to)->toBe(550000)
        ->and($unit->show_price_range)->toBeFalse()
        ->and($unit->land_price)->toBe(100000)
        ->and($unit->construction_cost)->toBe(400000)
        ->and($unit->service_costs)->toBe(50)
        ->and($unit->deposit)->toBe(1000)
        ->and($unit->rent_condition)->toBe('per maand')
        ->and($unit->lot_area)->toBe(120.5)
        ->and($unit->living_area)->toBe(111.0)
        ->and($unit->water_area)->toBe(0.0)
        ->and($unit->other_indoor_area)->toBe(5.5)
        ->and($unit->building_bound_outdoor_area)->toBe(8.0)
        ->and($unit->external_storage_area)->toBe(3.0)
        ->and($unit->volume)->toBe(320.0)
        ->and($unit->bedrooms)->toBe(3)
        ->and($unit->rooms)->toBe(5)
        ->and($unit->bathroom_count)->toBe(1)
        ->and($unit->floor)->toBe('1')
        ->and($unit->building_layers)->toBe(3)
        ->and($unit->frontage)->toBe(5.4)
        ->and($unit->storage)->toBe('eigen berging')
        ->and($unit->parking)->toBe('in buurtstalling')
        ->and($unit->garage)->toBeNull()
        ->and($unit->garage_area_included)->toBeNull()
        ->and($unit->balcony_area)->toBe(6.0)
        ->and($unit->balcony_orientation)->toBe('zuid')
        ->and($unit->loggia_area)->toBeNull()
        ->and($unit->roof_terrace_area)->toBeNull()
        ->and($unit->terrace_area)->toBe(12.0)
        ->and($unit->terrace_orientation)->toBe('west')
        ->and($unit->garden_orientation)->toBe('noord')
        ->and($unit->garden_finish)->toBe('gras')
        ->and($unit->garden_width)->toBe(4.0)
        ->and($unit->garden_length)->toBe(8.0)
        ->and($unit->garden_area)->toBe(32.0)
        ->and($unit->lot_width)->toBe(5.0)
        ->and($unit->lot_length)->toBe(24.0)
        ->and($unit->kitchen_finish)->toBe('standaard')
        ->and($unit->bathroom_finish)->toBe('standaard')
        ->and($unit->bathroom_amenities)->toBe('douche, toilet, wastafel')
        ->and($unit->living_room_location)->toBe('eerste verdieping')
        ->and($unit->other_rooms)->toBeNull()
        ->and($unit->playroom_possible)->toBe('ja')
        ->and($unit->extra_bedroom_possible)->toBe('nee')
        ->and($unit->sustainable_wood)->toBe('ja')
        ->and($unit->gasless)->toBe('ja')
        ->and($unit->solar_panels)->toBe('ja')
        ->and($unit->heat_pump)->toBe('ja')
        ->and($unit->floor_heating)->toBe('ja')
        ->and($unit->epc)->toBeNull()
        ->and($unit->energy_label)->toBe('A')
        ->and($unit->beng)->toBeNull()
        ->and($unit->kind)->toBe('Tussenwoning')
        ->and($unit->kind_text)->toBe('Gezinswoning')
        ->and($unit->description)->toBe('beschrijving')
        ->and($unit->description_html)->toBe('<p>beschrijving</p>')
        ->and($unit->extra_info)->toBe('extra info')
        ->and($unit->alt_link)->toBeNull()
        ->and($unit->link)->toBe('https://example.com/unit-1')
        ->and($unit->map_shape)->toBe('poly')
        ->and($unit->map_coords)->toBe('1,2,3,4')
        ->and($unit->json)->toBe('[]')
        ->and($unit->purchase_agreement_signed)->toBeTrue()
        ->and($unit->purchase_agreement_signed_at)->toBe($signedAt)
        ->and($unit->transferred)->toBeFalse()
        ->and($unit->transferred_at)->toBe($transferredAt)
        ->and($unit->fallback_buyer)->toBeNull()
        ->and($unit->construction_date)->toBe($constructionDate)
        ->and($unit->delivery_date)->toBe($deliveryDate)
        ->and($unit->cadastral_municipality)->toBe('Groningen')
        ->and($unit->cadastral_section)->toBe('A')
        ->and($unit->cadastral_parcel_number)->toBe('123')
        ->and($unit->cadastral_area)->toBe(150.0)
        ->and($unit->cadastral_parcel_number_2)->toBe('124')
        ->and($unit->cadastral_area_2)->toBe(75.0)
        ->and($unit->cadastral_extra)->toBeNull()
        ->and($unit->leasehold_annual_price)->toBe(500)
        ->and($unit->leasehold_buyout_50)->toBe(8000)
        ->and($unit->leasehold_buyout_perpetual)->toBe(16000)
        ->and($unit->leasehold_price_total)->toBe(20000)
        ->and($unit->leasehold_canon_excluding_buyout)->toBe(100)
        ->and($unit->external_reference)->toBe('EXT-1');
});
