<?php

namespace NieuwbouwOffice\PhpSdk\Data;

class UnitType
{
    public function __construct(
        public readonly string $uuid,
        public readonly ?bool $is_online,
        public readonly string $title,
        public readonly ?string $kind,
        public readonly ?int $order,
        public readonly ?string $short_description,
        public readonly ?int $home_count,
        public readonly ?int $media_count,
        public readonly ?string $plan_part,
        public readonly ?string $description,
        public readonly ?string $description_html,
        public readonly ?int $count,
        public readonly ?int $price_from,
        public readonly ?int $price_to,
        public readonly ?int $lot_area_from,
        public readonly ?int $lot_area_to,
        public readonly ?int $living_area_from,
        public readonly ?int $living_area_to,
        public readonly ?int $volume_from,
        public readonly ?int $volume_to,
        public readonly ?int $bedrooms_from,
        public readonly ?int $bedrooms_to,
        public readonly ?int $rooms_from,
        public readonly ?int $rooms_to,
        public readonly ?string $ownership,
        public readonly ?string $tenure,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            uuid: $data['Projectwoning_UUId'],
            is_online: self::toBool($data['Projectwoning_Online'] ?? null),
            title: $data['Projectwoning_Titel'],
            kind: $data['Woning_Type'] ?? null,
            order: self::toInt($data['Projectwoning_Volgorde'] ?? null),
            short_description: $data['Projectwoning_Beschrijving_Kort'] ?? null,
            home_count: self::toInt($data['NrWoningen'] ?? null),
            media_count: self::toInt($data['NrMedia'] ?? null),
            plan_part: $data['Plandeel'] ?? null,
            description: $data['Projectwoning_Beschrijving_Lang'] ?? null,
            description_html: $data['Projectwoning_Beschrijving_HTML'] ?? null,
            count: self::toInt($data['Projectwoning_Aantal'] ?? null),
            price_from: self::toInt($data['Projectwoning_PrijsVan'] ?? null),
            price_to: self::toInt($data['Projectwoning_PrijsTot'] ?? null),
            lot_area_from: self::toInt($data['Projectwoning_KavelOppVan'] ?? null),
            lot_area_to: self::toInt($data['Projectwoning_KavelOppTot'] ?? null),
            living_area_from: self::toInt($data['Projectwoning_WoonOppVan'] ?? null),
            living_area_to: self::toInt($data['Projectwoning_WoonOppTot'] ?? null),
            volume_from: self::toInt($data['Projectwoning_InhoudVan'] ?? null),
            volume_to: self::toInt($data['Projectwoning_InhoudTot'] ?? null),
            bedrooms_from: self::toInt($data['Projectwoning_SlaapkamersVan'] ?? null),
            bedrooms_to: self::toInt($data['Projectwoning_SlaapkamersTot'] ?? null),
            rooms_from: self::toInt($data['Projectwoning_KamersVan'] ?? null),
            rooms_to: self::toInt($data['Projectwoning_KamersTot'] ?? null),
            ownership: $data['Eigendom'] ?? null,
            tenure: $data['Huurkoop'] ?? null,
        );
    }

    private static function toInt(mixed $value): ?int
    {
        return $value === null ? null : (int) $value;
    }

    private static function toBool(mixed $value): ?bool
    {
        return $value === null ? null : (bool) (int) $value;
    }
}
