<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Dto;

enum ContactRole: string
{
    case Management = 'management';
    case ProjectManagement = 'project-management';
    case SiteManagement = 'site-management';
    case Purchasing = 'purchasing';
    case Sales = 'sales';
    case Accounting = 'accounting';
    case Support = 'support';
    case Logistics = 'logistics';
}
