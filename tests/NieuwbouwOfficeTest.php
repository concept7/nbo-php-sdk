<?php

use NieuwbouwOffice\PhpSdk\NieuwbouwOffice;
use NieuwbouwOffice\PhpSdk\Resources\ProjectResource;
use NieuwbouwOffice\PhpSdk\Resources\UnitTypeResource;
use Saloon\Enums\Method;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Request;

it('extends the saloon connector', function () {
    expect(new NieuwbouwOffice('test-token'))->toBeInstanceOf(Connector::class);
});

it('uses the default base url when none is provided', function () {
    $connector = new NieuwbouwOffice('test-token');

    expect($connector->resolveBaseUrl())->toBe('https://api.nbo.nl/rest');
});

it('allows the base url to be overridden via the constructor', function () {
    $connector = new NieuwbouwOffice('test-token', 'https://staging.nbo.nl/rest');

    expect($connector->resolveBaseUrl())->toBe('https://staging.nbo.nl/rest');
});

it('authenticates requests with an apikey-prefixed token', function () {
    $connector = new NieuwbouwOffice('my-secret-token');

    $authenticator = (function () {
        return $this->defaultAuth();
    })->call($connector);

    expect($authenticator)
        ->toBeInstanceOf(TokenAuthenticator::class)
        ->and($authenticator->token)->toBe('my-secret-token')
        ->and($authenticator->prefix)->toBe('apikey');
});

it('sends the apikey authorization header on outgoing requests', function () {
    $connector = new NieuwbouwOffice('my-secret-token');

    $request = new class extends Request
    {
        protected Method $method = Method::GET;

        public function resolveEndpoint(): string
        {
            return '/ping';
        }
    };

    $pendingRequest = $connector->createPendingRequest($request);

    expect($pendingRequest->headers()->get('Authorization'))
        ->toBe('apikey my-secret-token');
});

it('accepts json by default', function () {
    $connector = new NieuwbouwOffice('test-token');

    $request = new class extends Request
    {
        protected Method $method = Method::GET;

        public function resolveEndpoint(): string
        {
            return '/ping';
        }
    };

    $pendingRequest = $connector->createPendingRequest($request);

    expect($pendingRequest->headers()->get('Accept'))->toBe('application/json');
});

it('exposes the projects resource', function () {
    $connector = new NieuwbouwOffice('test-token');

    expect($connector->projects())->toBeInstanceOf(ProjectResource::class);
});

it('exposes the unit types resource for a project', function () {
    $connector = new NieuwbouwOffice('test-token');

    expect($connector->unitTypes('proj-1'))->toBeInstanceOf(UnitTypeResource::class);
});
