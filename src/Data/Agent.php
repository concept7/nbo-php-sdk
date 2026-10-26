<?php

namespace NieuwbouwOffice\PhpSdk\Data;

class Agent
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly ?string $address,
        public readonly ?string $postal_code,
        public readonly ?string $city,
        public readonly ?string $country_code,
        public readonly ?string $mailing_address,
        public readonly ?string $mailing_postal_code,
        public readonly ?string $mailing_city,
        public readonly ?string $mailing_country_code,
        public readonly ?string $email,
        public readonly ?string $phone,
        public readonly ?string $website_url,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            uuid: $data['Makelaar_UUId'],
            name: $data['Rechtspersoon'],
            address: $data['Adres'] ?? null,
            postal_code: $data['Postcode'] ?? null,
            city: $data['Plaats'] ?? null,
            country_code: $data['Landcode'] ?? null,
            mailing_address: $data['Post_Adres'] ?? null,
            mailing_postal_code: $data['Post_Postcode'] ?? null,
            mailing_city: $data['Post_Plaats'] ?? null,
            mailing_country_code: $data['Post_Landcode'] ?? null,
            email: $data['Email'] ?? null,
            phone: $data['Telefoon'] ?? null,
            website_url: $data['URL'] ?? null,
        );
    }
}
