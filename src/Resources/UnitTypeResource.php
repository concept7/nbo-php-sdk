<?php

namespace NieuwbouwOffice\PhpSdk\Resources;

use NieuwbouwOffice\PhpSdk\Requests\UnitTypes\GetUnitTypeRequest;
use NieuwbouwOffice\PhpSdk\Requests\UnitTypes\GetUnitTypesRequest;
use Saloon\Http\BaseResource;
use Saloon\Http\Connector;
use Saloon\Http\Response;

class UnitTypeResource extends BaseResource
{
    public function __construct(
        Connector $connector,
        protected string $projectUuid,
    ) {
        parent::__construct($connector);
    }

    public function list(): Response
    {
        return $this->connector->send(new GetUnitTypesRequest($this->projectUuid));
    }

    public function get(string $uuid): Response
    {
        return $this->connector->send(new GetUnitTypeRequest($this->projectUuid, $uuid));
    }
}
