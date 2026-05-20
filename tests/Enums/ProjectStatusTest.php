<?php

use NieuwbouwOffice\PhpSdk\Enums\ProjectStatus;

it('parses null to null', function () {
    expect(ProjectStatus::parse(null))->toBeNull();
});

it('returns an existing instance unchanged', function () {
    expect(ProjectStatus::parse(ProjectStatus::ForSaleOrRent))
        ->toBe(ProjectStatus::ForSaleOrRent);
});

it('parses the Dutch label into the matching case', function (string $label, ProjectStatus $expected) {
    expect(ProjectStatus::parse($label))->toBe($expected);
})->with([
    ['Acquisitiefase', ProjectStatus::Acquisition],
    ['Ontwikkelingsfase', ProjectStatus::Development],
    ['In verkoop / verhuur', ProjectStatus::ForSaleOrRent],
    ['In verkoop / verhuur, in aanbouw', ProjectStatus::ForSaleOrRentUnderConstruction],
    ['In verkoop / verhuur, bouw afgerond', ProjectStatus::ForSaleOrRentConstructionCompleted],
    ['Project uitverkocht, bouw afgerond', ProjectStatus::SoldOutConstructionCompleted],
    ['Geannuleerd', ProjectStatus::Cancelled],
    ['Pre-sale / pre-rent', ProjectStatus::PreSaleOrPreRent],
    ['Project uitverkocht, in aanbouw', ProjectStatus::SoldOutUnderConstruction],
]);

it('parses the numeric id into the matching case', function (int $id, ProjectStatus $expected) {
    expect(ProjectStatus::parse($id))->toBe($expected);
})->with([
    [1, ProjectStatus::Acquisition],
    [2, ProjectStatus::Development],
    [3, ProjectStatus::ForSaleOrRent],
    [4, ProjectStatus::ForSaleOrRentUnderConstruction],
    [5, ProjectStatus::ForSaleOrRentConstructionCompleted],
    [6, ProjectStatus::SoldOutConstructionCompleted],
    [7, ProjectStatus::Cancelled],
    [8, ProjectStatus::PreSaleOrPreRent],
    [9, ProjectStatus::SoldOutUnderConstruction],
]);

it('returns null for unknown values', function () {
    expect(ProjectStatus::parse('Onbekend'))->toBeNull()
        ->and(ProjectStatus::parse(99))->toBeNull();
});
