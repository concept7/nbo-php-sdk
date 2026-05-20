<?php

use NieuwbouwOffice\PhpSdk\Data\UnitType;

it('exposes its properties as readonly public values', function () {
    $unitType = new UnitType(
        uuid: 'unit-1',
        is_online: true,
        title: 'Rug-aan-rug woning',
        kind: 'Tussenwoning',
        order: 1,
        short_description: 'Korte beschrijving',
        home_count: 22,
        media_count: 7,
        plan_part: 'Plandeel A',
        description: 'Lange beschrijving',
        description_html: '<p>Lange beschrijving</p>',
        count: 22,
        price_from: 317600,
        price_to: 423300,
        lot_area_from: 50,
        lot_area_to: 80,
        living_area_from: 79,
        living_area_to: 79,
        volume_from: 200,
        volume_to: 240,
        bedrooms_from: 2,
        bedrooms_to: 2,
        rooms_from: 3,
        rooms_to: 3,
        ownership: 'Eigendom',
        tenure: 'Koopwoning',
    );

    expect($unitType->uuid)->toBe('unit-1')
        ->and($unitType->is_online)->toBeTrue()
        ->and($unitType->title)->toBe('Rug-aan-rug woning')
        ->and($unitType->kind)->toBe('Tussenwoning')
        ->and($unitType->order)->toBe(1)
        ->and($unitType->short_description)->toBe('Korte beschrijving')
        ->and($unitType->home_count)->toBe(22)
        ->and($unitType->media_count)->toBe(7)
        ->and($unitType->plan_part)->toBe('Plandeel A')
        ->and($unitType->description)->toBe('Lange beschrijving')
        ->and($unitType->description_html)->toBe('<p>Lange beschrijving</p>')
        ->and($unitType->count)->toBe(22)
        ->and($unitType->price_from)->toBe(317600)
        ->and($unitType->price_to)->toBe(423300)
        ->and($unitType->lot_area_from)->toBe(50)
        ->and($unitType->lot_area_to)->toBe(80)
        ->and($unitType->living_area_from)->toBe(79)
        ->and($unitType->living_area_to)->toBe(79)
        ->and($unitType->volume_from)->toBe(200)
        ->and($unitType->volume_to)->toBe(240)
        ->and($unitType->bedrooms_from)->toBe(2)
        ->and($unitType->bedrooms_to)->toBe(2)
        ->and($unitType->rooms_from)->toBe(3)
        ->and($unitType->rooms_to)->toBe(3)
        ->and($unitType->ownership)->toBe('Eigendom')
        ->and($unitType->tenure)->toBe('Koopwoning');
});
