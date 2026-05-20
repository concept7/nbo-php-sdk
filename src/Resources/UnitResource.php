<?php

namespace NieuwbouwOffice\PhpSdk\Resources;

use NieuwbouwOffice\PhpSdk\Requests\Units\GetUnitRequest;
use NieuwbouwOffice\PhpSdk\Requests\Units\GetUnitsRequest;
use Saloon\Http\BaseResource;
use Saloon\Http\Connector;
use Saloon\Http\Response;

class UnitResource extends BaseResource
{
    public function __construct(
        Connector $connector,
        protected string $projectUuid,
    ) {
        parent::__construct($connector);
    }

    public function list(): Response
    {
        return $this->connector->send(new GetUnitsRequest($this->projectUuid));
    }

    public function get(string $uuid): Response
    {
        return $this->connector->send(new GetUnitRequest($this->projectUuid, $uuid));
    }
}
