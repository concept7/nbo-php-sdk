<?php

namespace NieuwbouwOffice\PhpSdk\Resources;

use NieuwbouwOffice\PhpSdk\Data\Media;
use NieuwbouwOffice\PhpSdk\Data\UnitType;
use NieuwbouwOffice\PhpSdk\Requests\Media\GetMediaRequest;
use NieuwbouwOffice\PhpSdk\Requests\UnitTypes\GetUnitTypeRequest;
use NieuwbouwOffice\PhpSdk\Requests\UnitTypes\GetUnitTypesRequest;
use Saloon\Http\BaseResource;
use Saloon\Http\Connector;

class UnitTypeResource extends BaseResource
{
    public function __construct(
        Connector $connector,
        protected string $projectUuid,
    ) {
        parent::__construct($connector);
    }

    /**
     * @return UnitType[]
     */
    public function list(): array
    {
        return $this->connector->send(new GetUnitTypesRequest($this->projectUuid))->dto();
    }

    public function get(string $uuid): UnitType
    {
        return $this->connector->send(new GetUnitTypeRequest($this->projectUuid, $uuid))->dto();
    }

    /**
     * @return Media[]
     */
    public function media(string $uuid): array
    {
        return $this->connector
            ->send(new GetMediaRequest(new GetUnitTypeRequest($this->projectUuid, $uuid)))
            ->dto();
    }
}
