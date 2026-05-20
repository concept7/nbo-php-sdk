<?php

namespace NieuwbouwOffice\PhpSdk\Enums;

enum UnitStatus: string
{
    case ForSale = 'Te Koop';
    case SaleUnderOption = 'Koop in Optie';
    case Sold = 'Verkocht';
    case ForRent = 'Te Huur';
    case RentUnderOption = 'Huur in Optie';
    case Rented = 'Verhuurd';
    case Unavailable = 'Niet beschikbaar';
    case SoldSubjectToConditions = 'Verkocht onder voorbehoud';
    case Reserved = 'Gereserveerd';
    case Delivered = 'Geleverd';
    case Withdrawn = 'Teruggetrokken';
    case RentedSubjectToConditions = 'Verhuurd onder voorbehoud';
    case DeliveredAsRental = 'Geleverd (verhuurd)';
    case ComingSoon = 'Binnenkort beschikbaar';
}
