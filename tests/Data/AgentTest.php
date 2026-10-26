<?php

use NieuwbouwOffice\PhpSdk\Data\Agent;

it('exposes its properties as readonly public values', function () {
    $agent = new Agent(
        uuid: '2d94eecf0cb01d24da9be983a060d530',
        name: 'Makelaardij Het Zuiden',
        address: 'Marktstraat 12',
        postal_code: '9712 AB',
        city: 'Groningen',
        country_code: 'NL',
        mailing_address: 'Postbus 100',
        mailing_postal_code: '9700 AC',
        mailing_city: 'GRONINGEN',
        mailing_country_code: 'NL',
        email: 'info@makelaardij.test',
        phone: '0501234567',
        website_url: 'https://makelaardij.test',
    );

    expect($agent->uuid)->toBe('2d94eecf0cb01d24da9be983a060d530')
        ->and($agent->name)->toBe('Makelaardij Het Zuiden')
        ->and($agent->address)->toBe('Marktstraat 12')
        ->and($agent->postal_code)->toBe('9712 AB')
        ->and($agent->city)->toBe('Groningen')
        ->and($agent->country_code)->toBe('NL')
        ->and($agent->mailing_address)->toBe('Postbus 100')
        ->and($agent->mailing_postal_code)->toBe('9700 AC')
        ->and($agent->mailing_city)->toBe('GRONINGEN')
        ->and($agent->mailing_country_code)->toBe('NL')
        ->and($agent->email)->toBe('info@makelaardij.test')
        ->and($agent->phone)->toBe('0501234567')
        ->and($agent->website_url)->toBe('https://makelaardij.test');
});

it('maps the detail payload via fromResponse()', function () {
    $agent = Agent::fromResponse([
        'Makelaar_UUId' => '2d94eecf0cb01d24da9be983a060d530',
        'Rechtspersoon' => 'Makelaardij Het Zuiden',
        'Adres' => 'Marktstraat 12',
        'Postcode' => '9712 AB',
        'Plaats' => 'Groningen',
        'Landcode' => 'NL',
        'Post_Adres' => 'Postbus 100',
        'Post_Postcode' => '9700 AC',
        'Post_Plaats' => 'GRONINGEN',
        'Post_Landcode' => 'NL',
        'Email' => 'info@makelaardij.test',
        'Telefoon' => '0501234567',
        'URL' => 'https://makelaardij.test',
    ]);

    expect($agent->name)->toBe('Makelaardij Het Zuiden')
        ->and($agent->mailing_address)->toBe('Postbus 100')
        ->and($agent->email)->toBe('info@makelaardij.test')
        ->and($agent->phone)->toBe('0501234567')
        ->and($agent->website_url)->toBe('https://makelaardij.test');
});

it('leaves the detail-only fields null when mapping the list payload', function () {
    $agent = Agent::fromResponse([
        'Makelaar_UUId' => '2d94eecf0cb01d24da9be983a060d530',
        'Rechtspersoon' => 'Makelaardij Het Zuiden',
        'Adres' => 'Marktstraat 12',
        'Postcode' => '9712 AB',
        'Plaats' => 'Groningen',
        'Landcode' => 'NL',
    ]);

    expect($agent->city)->toBe('Groningen')
        ->and($agent->mailing_address)->toBeNull()
        ->and($agent->mailing_postal_code)->toBeNull()
        ->and($agent->mailing_city)->toBeNull()
        ->and($agent->mailing_country_code)->toBeNull()
        ->and($agent->email)->toBeNull()
        ->and($agent->phone)->toBeNull()
        ->and($agent->website_url)->toBeNull();
});
