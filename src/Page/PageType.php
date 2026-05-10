<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Page;

enum PageType: string
{
    case About = 'about';
    case Careers = 'careers';
    case Contact = 'contact';
    case CookiePolicy = 'cookie-policy';
    case Faq = 'faq';
    case Investors = 'investors';
    case Press = 'press';
    case Pricing = 'pricing';
    case Privacy = 'privacy';
    case ShippingReturns = 'shipping-returns';
    case Team = 'team';
    case Terms = 'terms';
}
