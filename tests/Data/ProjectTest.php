<?php

use Carbon\CarbonImmutable;
use NieuwbouwOffice\PhpSdk\Data\Project;

it('exposes its properties as readonly public values', function () {
    $createdAt = CarbonImmutable::parse('2026-01-01T00:00:00Z');
    $updatedAt = CarbonImmutable::parse('2026-02-01T00:00:00Z');
    $presaleDate = CarbonImmutable::parse('2025-12-11');

    $project = new Project(
        uuid: 'abc-123',
        id: 16958,
        parent_uuid: 'parent-uuid',
        title: 'Project ABC',
        municipality: 'Groningen',
        municipality_domain: 'nieuwbouw-groningen.nl',
        city: 'Groningen',
        district: 'Centrum',
        neighborhood: 'Binnenstad',
        postal_code: '9711',
        longitude: 6.53264602,
        latitude: 53.20888251,
        location_description: 'Description',
        location_description_html: '<p>Description</p>',
        phase: 'Actueel aanbod',
        internal_status: 'In verkoop / verhuur',
        reference_number: 'REF-1',
        description: 'Long description',
        description_html: '<p>Long</p>',
        html: '<p>HTML</p>',
        has_purchase: true,
        has_rental: false,
        purchase_count: 48,
        purchase_price_from: 250000,
        purchase_price_to: 500000,
        rental_count: null,
        rental_price_from: null,
        rental_price_to: null,
        lot_area_from: 100,
        lot_area_to: 200,
        living_area_from: 80,
        living_area_to: 150,
        volume_from: 250,
        volume_to: 400,
        bedrooms_from: 2,
        bedrooms_to: 4,
        development_date: null,
        presale_date: $presaleDate,
        sale_date: null,
        construction_date: null,
        delivery_end_date: null,
        realization_year: null,
        realization_quarter: null,
        presale_year: 2025,
        presale_quarter: 4,
        sale_year: null,
        sale_quarter: null,
        delivery_start_year: null,
        delivery_start_quarter: null,
        delivery_end_year: null,
        delivery_end_quarter: null,
        construction_year: null,
        construction_quarter: null,
        warranty_institute: 'SWK',
        warranty_institute_plan_number: null,
        lead_party: null,
        privacy_statement_url: null,
        project_site_url: 'https://wonenindesuikerzijde.nl/',
        site_url: 'https://wonenindesuikerzijde.nl/',
        children_count: 4,
        created_at: $createdAt,
        updated_at: $updatedAt,
    );

    expect($project->uuid)->toBe('abc-123')
        ->and($project->id)->toBe(16958)
        ->and($project->parent_uuid)->toBe('parent-uuid')
        ->and($project->title)->toBe('Project ABC')
        ->and($project->municipality)->toBe('Groningen')
        ->and($project->municipality_domain)->toBe('nieuwbouw-groningen.nl')
        ->and($project->city)->toBe('Groningen')
        ->and($project->district)->toBe('Centrum')
        ->and($project->neighborhood)->toBe('Binnenstad')
        ->and($project->postal_code)->toBe('9711')
        ->and($project->longitude)->toBe(6.53264602)
        ->and($project->latitude)->toBe(53.20888251)
        ->and($project->location_description)->toBe('Description')
        ->and($project->location_description_html)->toBe('<p>Description</p>')
        ->and($project->phase)->toBe('Actueel aanbod')
        ->and($project->internal_status)->toBe('In verkoop / verhuur')
        ->and($project->reference_number)->toBe('REF-1')
        ->and($project->description)->toBe('Long description')
        ->and($project->description_html)->toBe('<p>Long</p>')
        ->and($project->html)->toBe('<p>HTML</p>')
        ->and($project->has_purchase)->toBeTrue()
        ->and($project->has_rental)->toBeFalse()
        ->and($project->purchase_count)->toBe(48)
        ->and($project->purchase_price_from)->toBe(250000)
        ->and($project->purchase_price_to)->toBe(500000)
        ->and($project->rental_count)->toBeNull()
        ->and($project->rental_price_from)->toBeNull()
        ->and($project->rental_price_to)->toBeNull()
        ->and($project->lot_area_from)->toBe(100)
        ->and($project->lot_area_to)->toBe(200)
        ->and($project->living_area_from)->toBe(80)
        ->and($project->living_area_to)->toBe(150)
        ->and($project->volume_from)->toBe(250)
        ->and($project->volume_to)->toBe(400)
        ->and($project->bedrooms_from)->toBe(2)
        ->and($project->bedrooms_to)->toBe(4)
        ->and($project->development_date)->toBeNull()
        ->and($project->presale_date)->toBe($presaleDate)
        ->and($project->sale_date)->toBeNull()
        ->and($project->construction_date)->toBeNull()
        ->and($project->delivery_end_date)->toBeNull()
        ->and($project->realization_year)->toBeNull()
        ->and($project->realization_quarter)->toBeNull()
        ->and($project->presale_year)->toBe(2025)
        ->and($project->presale_quarter)->toBe(4)
        ->and($project->sale_year)->toBeNull()
        ->and($project->sale_quarter)->toBeNull()
        ->and($project->delivery_start_year)->toBeNull()
        ->and($project->delivery_start_quarter)->toBeNull()
        ->and($project->delivery_end_year)->toBeNull()
        ->and($project->delivery_end_quarter)->toBeNull()
        ->and($project->construction_year)->toBeNull()
        ->and($project->construction_quarter)->toBeNull()
        ->and($project->warranty_institute)->toBe('SWK')
        ->and($project->warranty_institute_plan_number)->toBeNull()
        ->and($project->lead_party)->toBeNull()
        ->and($project->privacy_statement_url)->toBeNull()
        ->and($project->project_site_url)->toBe('https://wonenindesuikerzijde.nl/')
        ->and($project->site_url)->toBe('https://wonenindesuikerzijde.nl/')
        ->and($project->children_count)->toBe(4)
        ->and($project->created_at)->toBe($createdAt)
        ->and($project->updated_at)->toBe($updatedAt);
});
