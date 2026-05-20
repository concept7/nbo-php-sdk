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
}
