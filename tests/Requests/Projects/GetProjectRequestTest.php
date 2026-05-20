<?php

use Carbon\CarbonImmutable;
use NieuwbouwOffice\PhpSdk\Data\Project;
use NieuwbouwOffice\PhpSdk\NieuwbouwOffice;
use NieuwbouwOffice\PhpSdk\Requests\Projects\GetProjectRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('uses the GET method', function () {
    expect((new GetProjectRequest('abc-123'))->getMethod())->toBe(Method::GET);
});

it('stores the uuid on a public property', function () {
    expect((new GetProjectRequest('abc-123'))->uuid)->toBe('abc-123');
});

it('resolves to the /projects/{uuid}/ endpoint', function () {
    expect((new GetProjectRequest('abc-123'))->resolveEndpoint())
        ->toBe('/projects/abc-123/');
});

it('creates a Project DTO from the response', function () {
    $mockClient = new MockClient([
        GetProjectRequest::class => MockResponse::make([
            'data' => [
                'object' => [
                    'Project_UUId' => 'e00afb7a1791a22eb8bca3707687c549',
                    'Project_Id' => '16958',
                    'Project_Parent_UUId' => null,
                    'Project_Ontwikkeling_Datum' => null,
                    'Project_Voorverkoop_Datum' => '2025-12-11',
                    'Project_Verkoop_Datum' => null,
                    'Project_Bouw_Datum' => null,
                    'Project_Wijk' => null,
                    'Project_Buurt' => null,
                    'Project_Titel' => 'De Suikerzijde',
                    'Project_Beschrijving_Lang' => null,
                    'Project_Beschrijving_HTML' => '<strong>START PRESALE FASE 2</strong>',
                    'Project_HasKoop' => '-1',
                    'Project_HasHuur' => '0',
                    'Project_Woning_Koop_Aantal' => '48',
                    'Project_Woning_Koop_PrijsVan' => null,
                    'Project_Woning_Koop_PrijsTot' => null,
                    'Project_Woning_Huur_Aantal' => null,
                    'Project_Woning_Huur_PrijsVan' => null,
                    'Project_Woning_Huur_PrijsTot' => null,
                    'Project_Woning_KavelOppVan' => null,
                    'Project_Woning_KavelOppTot' => null,
                    'Project_Woning_WoonOppVan' => null,
                    'Project_Woning_WoonOppTot' => null,
                    'Project_Woning_InhoudVan' => null,
                    'Project_Woning_InhoudTot' => null,
                    'Project_Woning_SlaapkamersVan' => null,
                    'Project_Woning_SlaapkamersTot' => null,
                    'Lng' => '6.53264602',
                    'Lat' => '53.20888251',
                    'Garantie_Instituut' => 'SWK',
                    'Plannummer_Garantie_Instituut' => null,
                    'Privacystatement_URL' => null,
                    'Project_Timestamp' => '2025-12-02 14:43:53',
                    'Gemeente' => 'Groningen',
                    'Gemeente_Domein' => 'nieuwbouw-groningen.nl',
                    'Project_Fase' => 'Actueel aanbod',
                    'Plaats' => 'Groningen',
                    'Project_Postcode' => null,
                    'Project_Oplevering_Eind_Datum' => null,
                    'Project_Referentienummer' => null,
                    'Project_Locatie_Beschrijving' => null,
                    'Project_Locatie_Beschrijving_HTML' => null,
                    'Project_Realisatie_Jaar' => null,
                    'Project_Realisatie_Kwartaal' => null,
                    'Project_Voorverkoop_Jaar' => '2025',
                    'Project_Voorverkoop_Kwartaal' => '4',
                    'Project_Verkoop_Jaar' => null,
                    'Project_Verkoop_Kwartaal' => null,
                    'Project_Oplevering_Eind_Jaar' => null,
                    'Project_Oplevering_Eind_Kwartaal' => null,
                    'Project_Oplevering_Start_Jaar' => null,
                    'Project_Oplevering_Start_Kwartaal' => null,
                    'Project_Bouw_Jaar' => null,
                    'Project_Bouw_Kwartaal' => null,
                    'Project_HTML' => null,
                    'Project_Status_Intern' => 'In verkoop / verhuur',
                    'Penvoerder' => null,
                    'Projectsite_URL' => 'https://wonenindesuikerzijde.nl/',
                    'Site_URL' => 'https://wonenindesuikerzijde.nl/',
                    'AantalDochters' => '4',
                ],
            ],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $project = $connector->send(new GetProjectRequest('e00afb7a1791a22eb8bca3707687c549'))->dto();

    expect($project)->toBeInstanceOf(Project::class)
        ->and($project->uuid)->toBe('e00afb7a1791a22eb8bca3707687c549')
        ->and($project->id)->toBe(16958)
        ->and($project->parent_uuid)->toBeNull()
        ->and($project->title)->toBe('De Suikerzijde')
        ->and($project->municipality)->toBe('Groningen')
        ->and($project->municipality_domain)->toBe('nieuwbouw-groningen.nl')
        ->and($project->city)->toBe('Groningen')
        ->and($project->phase)->toBe('Actueel aanbod')
        ->and($project->internal_status)->toBe('In verkoop / verhuur')
        ->and($project->description_html)->toBe('<strong>START PRESALE FASE 2</strong>')
        ->and($project->has_purchase)->toBeTrue()
        ->and($project->has_rental)->toBeFalse()
        ->and($project->purchase_count)->toBe(48)
        ->and($project->longitude)->toBe(6.53264602)
        ->and($project->latitude)->toBe(53.20888251)
        ->and($project->presale_date)->toBeInstanceOf(CarbonImmutable::class)
        ->and($project->presale_date->toDateString())->toBe('2025-12-11')
        ->and($project->development_date)->toBeNull()
        ->and($project->presale_year)->toBe(2025)
        ->and($project->presale_quarter)->toBe(4)
        ->and($project->warranty_institute)->toBe('SWK')
        ->and($project->project_site_url)->toBe('https://wonenindesuikerzijde.nl/')
        ->and($project->site_url)->toBe('https://wonenindesuikerzijde.nl/')
        ->and($project->children_count)->toBe(4)
        ->and($project->created_at)->toBeInstanceOf(CarbonImmutable::class)
        ->and($project->created_at->toDateTimeString())->toBe('2025-12-02 14:43:53')
        ->and($project->updated_at->toDateTimeString())->toBe('2025-12-02 14:43:53');
});
