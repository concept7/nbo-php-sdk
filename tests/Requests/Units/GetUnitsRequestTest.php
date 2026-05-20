<?php

use NieuwbouwOffice\PhpSdk\Data\Unit;
use NieuwbouwOffice\PhpSdk\NieuwbouwOffice;
use NieuwbouwOffice\PhpSdk\Requests\Units\GetUnitsRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('uses the GET method', function () {
    expect((new GetUnitsRequest('proj-1'))->getMethod())->toBe(Method::GET);
});

it('stores the project uuid on a public property', function () {
    expect((new GetUnitsRequest('proj-1'))->projectUuid)->toBe('proj-1');
});

it('resolves to the project-scoped woningen endpoint', function () {
    expect((new GetUnitsRequest('proj-1'))->resolveEndpoint())
        ->toBe('/projects/proj-1/woningen/');
});

it('creates an array of Unit DTOs from the response', function () {
    $mockClient = new MockClient([
        GetUnitsRequest::class => MockResponse::make([
            'data' => [
                'objects' => [
                    [
                        'Woning_UUId' => '08562ed46e91768b9fbe38422da510a0',
                        'Projectwoning_UUId' => 'dc28a597e2661a3bf7f84737eb1f38c9',
                        'Woning_Bouwnr' => '20 - fase 2',
                        'Woning_Online' => '-1',
                    ],
                    [
                        'Woning_UUId' => '3af3937ae6360f807228798932704d02',
                        'Projectwoning_UUId' => 'dc28a597e2661a3bf7f84737eb1f38c9',
                        'Woning_Bouwnr' => '31 - fase 2',
                        'Woning_Online' => '0',
                    ],
                ],
            ],
            'meta' => ['count' => 2],
        ]),
    ]);

    $connector = new NieuwbouwOffice('test-token');
    $connector->withMockClient($mockClient);

    $units = $connector->send(new GetUnitsRequest('proj-1'))->dto();

    expect($units)->toBeArray()->toHaveCount(2)
        ->and($units[0])->toBeInstanceOf(Unit::class)
        ->and($units[0]->uuid)->toBe('08562ed46e91768b9fbe38422da510a0')
        ->and($units[0]->unit_type_uuid)->toBe('dc28a597e2661a3bf7f84737eb1f38c9')
        ->and($units[0]->construction_number)->toBe('20 - fase 2')
        ->and($units[0]->is_online)->toBeTrue()
        ->and($units[0]->price)->toBeNull()
        ->and($units[0]->living_area)->toBeNull()
        ->and($units[1])->toBeInstanceOf(Unit::class)
        ->and($units[1]->uuid)->toBe('3af3937ae6360f807228798932704d02')
        ->and($units[1]->construction_number)->toBe('31 - fase 2')
        ->and($units[1]->is_online)->toBeFalse();
});
