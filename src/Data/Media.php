<?php

namespace NieuwbouwOffice\PhpSdk\Data;

use Carbon\CarbonImmutable;

class Media
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $filename,
        public readonly ?string $title,
        public readonly string $extension,
        public readonly string $url,
        public readonly ?string $label,
        public readonly ?int $order,
        public readonly CarbonImmutable $created_at,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            uuid: $data['Media_UUId'],
            filename: $data['Media_Filename'],
            title: $data['Media_Titel'] ?? null,
            extension: $data['Media_Extensie'],
            url: $data['URL'],
            label: $data['Label'] ?? null,
            order: self::toInt($data['Volgorde'] ?? null),
            created_at: CarbonImmutable::parse($data['Media_Timestamp']),
        );
    }

    private static function toInt(mixed $value): ?int
    {
        return $value === null ? null : (int) $value;
    }
}
