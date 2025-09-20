<?php declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers\de_DE;

use Bambamboole\ExtendedFaker\Providers\Product as BaseProduct;

class Product extends BaseProduct
{
    /**
     * German product names across various categories
     */
    protected static $productNames = [
        // Electronics
        'Samsung Galaxy S24 Ultra',
        'iPhone 15 Pro Max',
        'MacBook Air M2',
        'Dell XPS 13 Laptop',
        'Sony WH-1000XM4 Kopfhörer',
        'iPad Air 10.9 Zoll',
        'Nintendo Switch OLED',
        'PlayStation 5 Konsole',
        'AirPods Pro 2. Generation',
        'LG OLED55C3 Fernseher',
        'Canon EOS R6 Kamera',
        'Kindle Paperwhite E-Reader',

        // Clothing
        'Levi\'s 501 Original Jeans',
        'Adidas Originals Stan Smith',
        'Nike Air Max 90 Sneaker',
        'H&M Basic T-Shirt',
        'Zara Wollmantel Damen',
        'Tommy Hilfiger Poloshirt',
        'Hugo Boss Anzug Herren',
        'Mango Sommerkleid',
        'Converse Chuck Taylor Schuhe',
        'Patagonia Outdoor-Jacke',

        // Home & Garden
        'IKEA Billy Bücherregal',
        'Philips Hue LED-Leuchten',
        'Bosch Akkuschrauber PSR 18',
        'WMF Topfset Provence Plus',
        'Dyson V15 Detect Staubsauger',
        'Siemens Geschirrspüler',
        'Weber Genesis Gasgrill',
        'Gardena Bewässerungsset',
        'Nespresso Vertuo Kaffeemaschine',
        'Tempur Cloud Matratze',

        // Books & Media
        'Der Schwarm - Frank Schätzing',
        'Harry Potter Gesamtausgabe',
        'Spotify Premium Jahresabo',
        'Netflix Geschenkgutschein',
        'Das Parfum - Patrick Süskind',
        'Die Unendliche Geschichte',
        'Adobe Creative Suite Lizenz',
        'Microsoft Office 365',

        // Food & Beverages
        'Ritter Sport Schokolade',
        'Haribo Goldbären 200g',
        'Lavazza Espresso Bohnen',
        'Teekanne Früchtetee Mix',
        'Beck\'s Pils 20x0,5l',
        'Ferrero Rocher Pralinen',
        'Milka Alpenmilch Tafel',
        'Dallmayr Kaffee Classic',

        // Sports & Outdoor
        'Adidas Fußball Tiro 23',
        'Nike Dri-FIT Laufshirt',
        'Decathlon Fahrradhelm',
        'Salomon Wanderschuhe',
        'Yoga-Matte rutschfest',
        'Kettler Hantelset',
        'Thule Fahrradanhänger',
        'Mammut Kletterseil',

        // Health & Beauty
        'Nivea Creme Dose 150ml',
        'L\'Oréal Shampoo Elvital',
        'Braun Oral-B Zahnbürste',
        'Dior Sauvage Parfum',
        'Eucerin Gesichtscreme',
        'Gillette Fusion5 Rasierer',
        'Schwarzkopf Haarfarbe',
        'The Ordinary Serum Set',
    ];

    /**
     * German product descriptions with varied lengths and styles
     */
    protected static $productDescriptions = [
        // Tech descriptions
        'Hochmodernes Smartphone mit 6,8 Zoll Dynamic AMOLED Display, 200MP Kamera und bis zu 1TB Speicher. Perfekt für Fotografen und Tech-Enthusiasten.',
        'Revolutionärer Laptop mit Apple M2 Chip, der außergewöhnliche Leistung bei unglaublicher Energieeffizienz bietet. Ideal für kreative Profis.',
        'Professionelle Noise-Cancelling Kopfhörer mit branchenführender Geräuschunterdrückung und bis zu 30 Stunden Akkulaufzeit.',
        'Gaming-Konsole der nächsten Generation mit 4K-Grafik, blitzschnellen Ladezeiten und einer umfangreichen Spielebibliothek.',
        'Ultra-scharfes OLED-Display mit Dolby Vision HDR und webOS Smart-TV-Plattform für das ultimative Heimkino-Erlebnis.',

        // Fashion descriptions
        'Klassische Jeans aus 100% Baumwolle mit authentischer Vintage-Waschung. Zeitloser Style, der zu jedem Outfit passt.',
        'Legendäre Sneaker aus weißem Leder mit grünen Akzenten. Ein echter Klassiker, der Komfort und Style perfekt vereint.',
        'Eleganter Wollmantel in zeitlosem Design, perfekt für die kalte Jahreszeit. Hochwertige Verarbeitung und wärmende Eigenschaften.',
        'Bequemes Poloshirt aus 100% Baumwolle mit klassischem Logo-Stickerei. Perfekt für Freizeit und Business-Casual.',

        // Home descriptions
        'Praktisches Bücherregal aus nachhaltiger Forstwirtschaft mit verstellbaren Einlegeböden. Einfache Montage dank IKEA-System.',
        'Intelligente LED-Beleuchtung mit 16 Millionen Farben, steuerbar per App. Schaffen Sie die perfekte Atmosphäre für jeden Anlass.',
        'Leistungsstarker Akkuschrauber mit bürstenlosem Motor und zwei Akkus. Ideal für Heimwerker und professionelle Anwendungen.',
        'Hochwertiges Topfset aus Edelstahl mit Antihaftbeschichtung. Geeignet für alle Herdarten inklusive Induktion.',

        // Short descriptions
        'Premium-Qualität zum fairen Preis.',
        'Nachhaltig produziert in Deutschland.',
        'Bestseller mit über 10.000 positiven Bewertungen.',
        'Limitierte Auflage - nur solange Vorrat reicht.',
        'Handgefertigt von lokalen Kunsthandwerkern.',
        'Garantie: 2 Jahre Herstellergarantie inklusive.',

        // Food descriptions
        'Zarte Vollmilchschokolade mit gerösteten Haselnüssen aus nachhaltiger Produktion. Ein Genuss für alle Sinne.',
        'Aromatische Espresso-Bohnen aus fairem Handel, perfekt geröstet für den authentischen italienischen Geschmack.',
        'Fruchtig-süße Gummibärchen in den klassischen fünf Geschmacksrichtungen. Der beliebte Snack für Groß und Klein.',

        // Long detailed descriptions
        'Dieses innovative Produkt vereint modernste Technologie mit benutzerfreundlichem Design. Die hochwertige Verarbeitung und die durchdachten Details machen es zum perfekten Begleiter für den Alltag. Mit seiner energieeffizienten Bauweise und der intuitiven Bedienung setzt es neue Maßstäbe in seiner Kategorie. Kundenbewertungen loben besonders die Langlebigkeit und das ausgezeichnete Preis-Leistungs-Verhältnis.',
        'Hergestellt in Deutschland nach strengsten Qualitätsstandards, überzeugt dieses Produkt durch seine Robustheit und Zuverlässigkeit. Die sorgfältig ausgewählten Materialien und die präzise Fertigung garantieren eine lange Lebensdauer. Dank der modernen Produktionstechniken wird höchste Präzision bei gleichzeitig umweltschonender Herstellung gewährleistet.',
    ];

    /**
     * German product categories
     */
    protected static $productCategories = [
        'Elektronik',
        'Computer & Zubehör',
        'Smartphones & Handys',
        'TV & Audio',
        'Foto & Kamera',
        'Gaming',

        'Mode & Accessoires',
        'Herrenmode',
        'Damenmode',
        'Schuhe',
        'Uhren & Schmuck',
        'Taschen & Koffer',

        'Haus & Garten',
        'Möbel',
        'Küche & Haushalt',
        'Garten & Terrasse',
        'Heimwerken & Werkzeug',
        'Beleuchtung',

        'Sport & Freizeit',
        'Fitness',
        'Outdoor',
        'Fahrräder',
        'Sportbekleidung',
        'Camping & Wandern',

        'Gesundheit & Schönheit',
        'Körperpflege',
        'Parfüm & Kosmetik',
        'Medizin & Wellness',
        'Nahrungsergänzung',

        'Bücher & Medien',
        'Bücher',
        'E-Books',
        'Filme & Serien',
        'Musik',
        'Games & Software',

        'Lebensmittel & Getränke',
        'Süßwaren',
        'Getränke',
        'Bio-Produkte',
        'Spezialitäten',

        'Auto & Motorrad',
        'Autozubehör',
        'Motorrad',
        'Ersatzteile',

        'Baby & Kind',
        'Babykleidung',
        'Spielzeug',
        'Schulbedarf',

        'Tierbedarf',
        'Hundefutter',
        'Katzenzubehör',
        'Aquaristik',
    ];
}
