<?php

namespace NieuwbouwOffice\PhpSdk\Resources;

use NieuwbouwOffice\PhpSdk\Data\Agent;
use NieuwbouwOffice\PhpSdk\Data\Media;
use NieuwbouwOffice\PhpSdk\Requests\Agents\GetAgentRequest;
use NieuwbouwOffice\PhpSdk\Requests\Agents\GetAgentsRequest;
use NieuwbouwOffice\PhpSdk\Requests\Media\GetMediaRequest;
use Saloon\Http\BaseResource;
use Saloon\Http\Connector;

class AgentResource extends BaseResource
{
    public function __construct(
        Connector $connector,
        protected string $projectUuid,
    ) {
        parent::__construct($connector);
    }

    /**
     * @return Agent[]
     */
    public function list(): array
    {
        return $this->connector->send(new GetAgentsRequest($this->projectUuid))->dto();
    }

    public function get(string $uuid): Agent
    {
        return $this->connector->send(new GetAgentRequest($this->projectUuid, $uuid))->dto();
    }

    /**
     * @return Media[]
     */
    public function media(string $uuid): array
    {
        return $this->connector
            ->send(new GetMediaRequest(new GetAgentRequest($this->projectUuid, $uuid)))
            ->dto();
    }
}
