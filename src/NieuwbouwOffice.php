<?php

namespace NieuwbouwOffice\PhpSdk;

use NieuwbouwOffice\PhpSdk\Resources\ProjectResource;
use NieuwbouwOffice\PhpSdk\Resources\UnitResource;
use NieuwbouwOffice\PhpSdk\Resources\UnitTypeResource;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class NieuwbouwOffice extends Connector
{
    use AcceptsJson;
    use AlwaysThrowOnErrors;

    public function __construct(
        protected string $token,
        protected string $baseUrl = 'https://api.nbo.nl/rest',
    ) {}

    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator($this->token, 'apikey');
    }

    public function projects(): ProjectResource
    {
        return new ProjectResource($this);
    }

    public function unitTypes(string $projectUuid): UnitTypeResource
    {
        return new UnitTypeResource($this, $projectUuid);
    }

    public function units(string $projectUuid): UnitResource
    {
        return new UnitResource($this, $projectUuid);
    }
}
