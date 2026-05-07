<?php

namespace NieuwbouwOffice\PhpSdk\Data;

class Project
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $title,
        public readonly string $created_at,
        public readonly string $updated_at,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            uuid: $data['Project_UUId'],
            title: $data['Project_Titel'],
            created_at: $data['Project_Timestamp'],
            updated_at: $data['Laatst_Bijgewerkt'] ?? $data['Project_Timestamp'],
        );
    }
}
