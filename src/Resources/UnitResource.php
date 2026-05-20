<?php

namespace NieuwbouwOffice\PhpSdk\Resources;

use NieuwbouwOffice\PhpSdk\Data\Unit;
use NieuwbouwOffice\PhpSdk\Requests\Units\GetUnitRequest;
use NieuwbouwOffice\PhpSdk\Requests\Units\GetUnitsRequest;
use Saloon\Http\BaseResource;
use Saloon\Http\Connector;

class UnitResource extends BaseResource
{
    public function __construct(
        Connector $connector,
        protected string $projectUuid,
    ) {
        parent::__construct($connector);
    }

    /**
     * @return Unit[]
     */
    public function list(): array
    {
        return $this->connector->send(new GetUnitsRequest($this->projectUuid))->dto();
    }

    public function get(string $uuid): Unit
    {
        return $this->connector->send(new GetUnitRequest($this->projectUuid, $uuid))->dto();
    }
}
