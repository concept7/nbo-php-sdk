<?php

namespace NieuwbouwOffice\PhpSdk\Data;

use Carbon\CarbonImmutable;

class Project
{
    public function __construct(
        public readonly string $uuid,
        public readonly ?int $id,
        public readonly ?string $parent_uuid,
        public readonly string $title,
        public readonly ?string $municipality,
        public readonly ?string $municipality_domain,
        public readonly ?string $city,
        public readonly ?string $district,
        public readonly ?string $neighborhood,
        public readonly ?string $postal_code,
        public readonly ?float $longitude,
        public readonly ?float $latitude,
        public readonly ?string $location_description,
        public readonly ?string $location_description_html,
        public readonly ?string $phase,
        public readonly ?string $internal_status,
        public readonly ?string $reference_number,
        public readonly ?string $description,
        public readonly ?string $description_html,
        public readonly ?string $html,
        public readonly ?bool $has_purchase,
        public readonly ?bool $has_rental,
        public readonly ?int $purchase_count,
        public readonly ?int $purchase_price_from,
        public readonly ?int $purchase_price_to,
        public readonly ?int $rental_count,
        public readonly ?int $rental_price_from,
        public readonly ?int $rental_price_to,
        public readonly ?int $lot_area_from,
        public readonly ?int $lot_area_to,
        public readonly ?int $living_area_from,
        public readonly ?int $living_area_to,
        public readonly ?int $volume_from,
        public readonly ?int $volume_to,
        public readonly ?int $bedrooms_from,
        public readonly ?int $bedrooms_to,
        public readonly ?CarbonImmutable $development_date,
        public readonly ?CarbonImmutable $presale_date,
        public readonly ?CarbonImmutable $sale_date,
        public readonly ?CarbonImmutable $construction_date,
        public readonly ?CarbonImmutable $delivery_end_date,
        public readonly ?int $realization_year,
        public readonly ?int $realization_quarter,
        public readonly ?int $presale_year,
        public readonly ?int $presale_quarter,
        public readonly ?int $sale_year,
        public readonly ?int $sale_quarter,
        public readonly ?int $delivery_start_year,
        public readonly ?int $delivery_start_quarter,
        public readonly ?int $delivery_end_year,
        public readonly ?int $delivery_end_quarter,
        public readonly ?int $construction_year,
        public readonly ?int $construction_quarter,
        public readonly ?string $warranty_institute,
        public readonly ?string $warranty_institute_plan_number,
        public readonly ?string $lead_party,
        public readonly ?string $privacy_statement_url,
        public readonly ?string $project_site_url,
        public readonly ?string $site_url,
        public readonly ?int $children_count,
        public readonly CarbonImmutable $created_at,
        public readonly CarbonImmutable $updated_at,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            uuid: $data['Project_UUId'],
            id: self::toInt($data['Project_Id'] ?? null),
            parent_uuid: $data['Project_Parent_UUId'] ?? null,
            title: $data['Project_Titel'],
            municipality: $data['Gemeente'] ?? null,
            municipality_domain: $data['Gemeente_Domein'] ?? null,
            city: $data['Plaats'] ?? null,
            district: $data['Project_Wijk'] ?? null,
            neighborhood: $data['Project_Buurt'] ?? null,
            postal_code: $data['Project_Postcode'] ?? null,
            longitude: self::toFloat($data['Lng'] ?? null),
            latitude: self::toFloat($data['Lat'] ?? null),
            location_description: $data['Project_Locatie_Beschrijving'] ?? null,
            location_description_html: $data['Project_Locatie_Beschrijving_HTML'] ?? null,
            phase: $data['Project_Fase'] ?? null,
            internal_status: $data['Project_Status_Intern'] ?? null,
            reference_number: $data['Project_Referentienummer'] ?? null,
            description: $data['Project_Beschrijving_Lang'] ?? null,
            description_html: $data['Project_Beschrijving_HTML'] ?? null,
            html: $data['Project_HTML'] ?? null,
            has_purchase: self::toBool($data['Project_HasKoop'] ?? null),
            has_rental: self::toBool($data['Project_HasHuur'] ?? null),
            purchase_count: self::toInt($data['Project_Woning_Koop_Aantal'] ?? null),
            purchase_price_from: self::toInt($data['Project_Woning_Koop_PrijsVan'] ?? null),
            purchase_price_to: self::toInt($data['Project_Woning_Koop_PrijsTot'] ?? null),
            rental_count: self::toInt($data['Project_Woning_Huur_Aantal'] ?? null),
            rental_price_from: self::toInt($data['Project_Woning_Huur_PrijsVan'] ?? null),
            rental_price_to: self::toInt($data['Project_Woning_Huur_PrijsTot'] ?? null),
            lot_area_from: self::toInt($data['Project_Woning_KavelOppVan'] ?? null),
            lot_area_to: self::toInt($data['Project_Woning_KavelOppTot'] ?? null),
            living_area_from: self::toInt($data['Project_Woning_WoonOppVan'] ?? null),
            living_area_to: self::toInt($data['Project_Woning_WoonOppTot'] ?? null),
            volume_from: self::toInt($data['Project_Woning_InhoudVan'] ?? null),
            volume_to: self::toInt($data['Project_Woning_InhoudTot'] ?? null),
            bedrooms_from: self::toInt($data['Project_Woning_SlaapkamersVan'] ?? null),
            bedrooms_to: self::toInt($data['Project_Woning_SlaapkamersTot'] ?? null),
            development_date: self::toCarbon($data['Project_Ontwikkeling_Datum'] ?? null),
            presale_date: self::toCarbon($data['Project_Voorverkoop_Datum'] ?? null),
            sale_date: self::toCarbon($data['Project_Verkoop_Datum'] ?? null),
            construction_date: self::toCarbon($data['Project_Bouw_Datum'] ?? null),
            delivery_end_date: self::toCarbon($data['Project_Oplevering_Eind_Datum'] ?? null),
            realization_year: self::toInt($data['Project_Realisatie_Jaar'] ?? null),
            realization_quarter: self::toInt($data['Project_Realisatie_Kwartaal'] ?? null),
            presale_year: self::toInt($data['Project_Voorverkoop_Jaar'] ?? null),
            presale_quarter: self::toInt($data['Project_Voorverkoop_Kwartaal'] ?? null),
            sale_year: self::toInt($data['Project_Verkoop_Jaar'] ?? null),
            sale_quarter: self::toInt($data['Project_Verkoop_Kwartaal'] ?? null),
            delivery_start_year: self::toInt($data['Project_Oplevering_Start_Jaar'] ?? null),
            delivery_start_quarter: self::toInt($data['Project_Oplevering_Start_Kwartaal'] ?? null),
            delivery_end_year: self::toInt($data['Project_Oplevering_Eind_Jaar'] ?? null),
            delivery_end_quarter: self::toInt($data['Project_Oplevering_Eind_Kwartaal'] ?? null),
            construction_year: self::toInt($data['Project_Bouw_Jaar'] ?? null),
            construction_quarter: self::toInt($data['Project_Bouw_Kwartaal'] ?? null),
            warranty_institute: $data['Garantie_Instituut'] ?? null,
            warranty_institute_plan_number: $data['Plannummer_Garantie_Instituut'] ?? null,
            lead_party: $data['Penvoerder'] ?? null,
            privacy_statement_url: $data['Privacystatement_URL'] ?? null,
            project_site_url: $data['Projectsite_URL'] ?? null,
            site_url: $data['Site_URL'] ?? null,
            children_count: self::toInt($data['AantalDochters'] ?? null),
            created_at: CarbonImmutable::parse($data['Project_Timestamp']),
            updated_at: CarbonImmutable::parse($data['Laatst_Bijgewerkt'] ?? $data['Project_Timestamp']),
        );
    }

    private static function toInt(mixed $value): ?int
    {
        return $value === null ? null : (int) $value;
    }

    private static function toFloat(mixed $value): ?float
    {
        return $value === null ? null : (float) $value;
    }

    private static function toBool(mixed $value): ?bool
    {
        return $value === null ? null : (bool) (int) $value;
    }

    private static function toCarbon(mixed $value): ?CarbonImmutable
    {
        return $value === null ? null : CarbonImmutable::parse($value);
    }
}
