<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image;

use Bambamboole\ExtendedFaker\Image\Motif\BallMotif;
use Bambamboole\ExtendedFaker\Image\Motif\BookMotif;
use Bambamboole\ExtendedFaker\Image\Motif\BottleMotif;
use Bambamboole\ExtendedFaker\Image\Motif\BoxMotif;
use Bambamboole\ExtendedFaker\Image\Motif\BriefcaseMotif;
use Bambamboole\ExtendedFaker\Image\Motif\CandyMotif;
use Bambamboole\ExtendedFaker\Image\Motif\CarMotif;
use Bambamboole\ExtendedFaker\Image\Motif\ChairMotif;
use Bambamboole\ExtendedFaker\Image\Motif\ChartMotif;
use Bambamboole\ExtendedFaker\Image\Motif\CoffeeMotif;
use Bambamboole\ExtendedFaker\Image\Motif\CookieMotif;
use Bambamboole\ExtendedFaker\Image\Motif\DocumentMotif;
use Bambamboole\ExtendedFaker\Image\Motif\ElectronicsMotif;
use Bambamboole\ExtendedFaker\Image\Motif\EnvelopeMotif;
use Bambamboole\ExtendedFaker\Image\Motif\FallbackMotif;
use Bambamboole\ExtendedFaker\Image\Motif\InfoMotif;
use Bambamboole\ExtendedFaker\Image\Motif\LaptopMotif;
use Bambamboole\ExtendedFaker\Image\Motif\LipstickMotif;
use Bambamboole\ExtendedFaker\Image\Motif\LockMotif;
use Bambamboole\ExtendedFaker\Image\Motif\NewspaperMotif;
use Bambamboole\ExtendedFaker\Image\Motif\NoteMotif;
use Bambamboole\ExtendedFaker\Image\Motif\PeopleMotif;
use Bambamboole\ExtendedFaker\Image\Motif\PhoneMotif;
use Bambamboole\ExtendedFaker\Image\Motif\PlantMotif;
use Bambamboole\ExtendedFaker\Image\Motif\PlateMotif;
use Bambamboole\ExtendedFaker\Image\Motif\PotMotif;
use Bambamboole\ExtendedFaker\Image\Motif\ShirtMotif;
use Bambamboole\ExtendedFaker\Image\Motif\ShoeMotif;
use Bambamboole\ExtendedFaker\Image\Motif\SpeechBubbleMotif;
use Bambamboole\ExtendedFaker\Image\Motif\TagMotif;
use Bambamboole\ExtendedFaker\Image\Motif\TankTopMotif;
use Bambamboole\ExtendedFaker\Image\Motif\WatchMotif;

final class MotifRegistry
{
    /** @var array<string, Motif> */
    private array $motifs;

    private Motif $fallback;

    public function __construct()
    {
        $this->fallback = new FallbackMotif;
        $this->motifs = [
            // Categories
            'electronics' => new ElectronicsMotif,
            'computers-accessories' => new LaptopMotif,
            'wearable-technology' => new WatchMotif,
            'cell-phones-smartphones' => new PhoneMotif,
            'coffee-tea' => new CoffeeMotif,
            'snacks-candy' => new CandyMotif,
            'gourmet-food' => new PlateMotif,
            'kitchen-dining' => new PotMotif,
            'books' => new BookMotif,
            'music' => new NoteMotif,
            'mens-clothing' => new ShirtMotif,
            'clothing-apparel' => new ShirtMotif,
            'athletic-apparel' => new TankTopMotif,
            'shoes-footwear' => new ShoeMotif,
            'makeup-cosmetics' => new LipstickMotif,
            'skin-care' => new BottleMotif,
            'furniture' => new ChairMotif,
            'home-garden' => new PlantMotif,
            'sports-outdoors' => new BallMotif,
            'car-accessories' => new CarMotif,

            // Pages
            'about' => new InfoMotif,
            'contact' => new EnvelopeMotif,
            'pricing' => new TagMotif,
            'faq' => new SpeechBubbleMotif,
            'careers' => new BriefcaseMotif,
            'team' => new PeopleMotif,
            'press' => new NewspaperMotif,
            'investors' => new ChartMotif,
            'privacy' => new LockMotif,
            'cookie-policy' => new CookieMotif,
            'terms' => new DocumentMotif,
            'shipping-returns' => new BoxMotif,
        ];
    }

    public function for(string $key): Motif
    {
        return $this->motifs[$key] ?? $this->fallback;
    }

    public function has(string $key): bool
    {
        return isset($this->motifs[$key]);
    }

    /** @return list<string> */
    public function keys(): array
    {
        return array_keys($this->motifs);
    }
}
