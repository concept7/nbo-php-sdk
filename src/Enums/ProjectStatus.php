<?php

namespace NieuwbouwOffice\PhpSdk\Enums;

enum ProjectStatus: string
{
    case Acquisition = 'Acquisitiefase';
    case Development = 'Ontwikkelingsfase';
    case ForSaleOrRent = 'In verkoop / verhuur';
    case ForSaleOrRentUnderConstruction = 'In verkoop / verhuur, in aanbouw';
    case ForSaleOrRentConstructionCompleted = 'In verkoop / verhuur, bouw afgerond';
    case SoldOutConstructionCompleted = 'Project uitverkocht, bouw afgerond';
    case Cancelled = 'Geannuleerd';
    case PreSaleOrPreRent = 'Pre-sale / pre-rent';
    case SoldOutUnderConstruction = 'Project uitverkocht, in aanbouw';

    public static function parse(null|int|string|self $value): ?static
    {
        if ($value instanceof self) {
            return $value;
        }

        if ($value === null) {
            return null;
        }

        if (is_int($value)) {
            return match ($value) {
                1 => self::Acquisition,
                2 => self::Development,
                3 => self::ForSaleOrRent,
                4 => self::ForSaleOrRentUnderConstruction,
                5 => self::ForSaleOrRentConstructionCompleted,
                6 => self::SoldOutConstructionCompleted,
                7 => self::Cancelled,
                8 => self::PreSaleOrPreRent,
                9 => self::SoldOutUnderConstruction,
                default => null,
            };
        }

        return self::tryFrom($value);
    }
}
