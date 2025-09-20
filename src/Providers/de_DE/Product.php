<?php declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers\de_DE;

use Bambamboole\ExtendedFaker\Providers\Product as BaseProduct;

class Product extends BaseProduct
{
    /**
     * German product data with name-description-category mappings
     */
    protected static $products = [
        // Electronics
        [
            'name' => 'Samsung Galaxy S24 Ultra',
            'description' => 'Hochmodernes Smartphone mit 6,8 Zoll Dynamic AMOLED Display, 200MP Kamera und bis zu 1TB Speicher. Perfekt für Fotografen und Tech-Enthusiasten.',
            'category' => 'Smartphones & Handys',
        ],
        [
            'name' => 'iPhone 15 Pro Max',
            'description' => 'Premium iPhone mit Titan-Design und A17 Pro Chip. Revolutionäre Kamera mit 5x Zoom und professioneller Videoqualität.',
            'category' => 'Smartphones & Handys',
        ],
        [
            'name' => 'MacBook Air M2',
            'description' => 'Revolutionärer Laptop mit Apple M2 Chip, der außergewöhnliche Leistung bei unglaublicher Energieeffizienz bietet. Ideal für kreative Profis.',
            'category' => 'Computer & Zubehör',
        ],
        [
            'name' => 'Dell XPS 13 Laptop',
            'description' => 'Premium Ultrabook mit randlosem InfinityEdge Display und modernsten Intel Prozessoren. Für Produktivität und Mobilität konzipiert.',
            'category' => 'Computer & Zubehör',
        ],
        [
            'name' => 'Sony WH-1000XM4 Kopfhörer',
            'description' => 'Professionelle Noise-Cancelling Kopfhörer mit branchenführender Geräuschunterdrückung und bis zu 30 Stunden Akkulaufzeit.',
            'category' => 'TV & Audio',
        ],
        [
            'name' => 'iPad Air 10.9 Zoll',
            'description' => 'Leistungsstarkes Tablet mit M1 Chip und brillantem Liquid Retina Display. Perfekt für Kreativität und Produktivität unterwegs.',
            'category' => 'Computer & Zubehör',
        ],
        [
            'name' => 'Nintendo Switch OLED',
            'description' => 'Gaming-Konsole der nächsten Generation mit lebendigem OLED-Display und verbessertem Audio. Spielen Sie überall und jederzeit.',
            'category' => 'Gaming',
        ],
        [
            'name' => 'PlayStation 5 Konsole',
            'description' => 'Gaming-Konsole der nächsten Generation mit 4K-Grafik, blitzschnellen Ladezeiten und einer umfangreichen Spielebibliothek.',
            'category' => 'Gaming',
        ],
        [
            'name' => 'AirPods Pro 2. Generation',
            'description' => 'Fortschrittliche kabellose Kopfhörer mit aktiver Geräuschunterdrückung und 3D-Audio. Premium Sound in kompaktem Design.',
            'category' => 'TV & Audio',
        ],
        [
            'name' => 'LG OLED55C3 Fernseher',
            'description' => 'Ultra-scharfes OLED-Display mit Dolby Vision HDR und webOS Smart-TV-Plattform für das ultimative Heimkino-Erlebnis.',
            'category' => 'TV & Audio',
        ],
        [
            'name' => 'Canon EOS R6 Kamera',
            'description' => 'Professionelle spiegellose Kamera mit außergewöhnlicher Bildqualität und fortschrittlichem Autofokus. Perfekt für Fotografie-Enthusiasten.',
            'category' => 'Foto & Kamera',
        ],
        [
            'name' => 'Kindle Paperwhite E-Reader',
            'description' => 'Premium E-Reader mit hochauflösendem Display und wochenlanger Akkulaufzeit. Tausende Bücher in einem leichten Gerät.',
            'category' => 'Elektronik',
        ],

        // Clothing & Fashion
        [
            'name' => 'Levi\'s 501 Original Jeans',
            'description' => 'Klassische Jeans aus 100% Baumwolle mit authentischer Vintage-Waschung. Zeitloser Style, der zu jedem Outfit passt.',
            'category' => 'Herrenmode',
        ],
        [
            'name' => 'Adidas Originals Stan Smith',
            'description' => 'Legendäre Sneaker aus weißem Leder mit grünen Akzenten. Ein echter Klassiker, der Komfort und Style perfekt vereint.',
            'category' => 'Schuhe',
        ],
        [
            'name' => 'Nike Air Max 90 Sneaker',
            'description' => 'Ikonische Laufschuhe mit sichtbarer Air-Dämpfung und zeitlosem Design. Ein Streetwear-Klassiker seit Jahrzehnten.',
            'category' => 'Schuhe',
        ],
        [
            'name' => 'H&M Basic T-Shirt',
            'description' => 'Hochwertiges Baumwoll-T-Shirt mit bequemer Passform und modernem Schnitt. Perfektes Basic für jeden Kleiderschrank.',
            'category' => 'Damenmode',
        ],
        [
            'name' => 'Zara Wollmantel Damen',
            'description' => 'Eleganter Wollmantel in zeitlosem Design, perfekt für die kalte Jahreszeit. Hochwertige Verarbeitung und wärmende Eigenschaften.',
            'category' => 'Damenmode',
        ],
        [
            'name' => 'Tommy Hilfiger Poloshirt',
            'description' => 'Bequemes Poloshirt aus 100% Baumwolle mit klassischem Logo-Stickerei. Perfekt für Freizeit und Business-Casual.',
            'category' => 'Herrenmode',
        ],
        [
            'name' => 'Hugo Boss Anzug Herren',
            'description' => 'Eleganter Business-Anzug aus feinster Schurwolle mit perfekter Passform. Für den modernen Geschäftsmann konzipiert.',
            'category' => 'Herrenmode',
        ],
        [
            'name' => 'Mango Sommerkleid',
            'description' => 'Leichtes Sommerkleid aus atmungsaktivem Material mit femininem Schnitt. Perfekt für warme Tage und besondere Anlässe.',
            'category' => 'Damenmode',
        ],
        [
            'name' => 'Converse Chuck Taylor Schuhe',
            'description' => 'Klassische Canvas-Sneaker mit Vintage-Design und verbessertem Komfort. Eine Ikone der Jugendkultur.',
            'category' => 'Schuhe',
        ],
        [
            'name' => 'Patagonia Outdoor-Jacke',
            'description' => 'Funktionale Outdoor-Jacke aus recyceltem Material mit wind- und wasserabweisenden Eigenschaften. Nachhaltigkeit trifft Performance.',
            'category' => 'Sportbekleidung',
        ],

        // Home & Garden
        [
            'name' => 'IKEA Billy Bücherregal',
            'description' => 'Praktisches Bücherregal aus nachhaltiger Forstwirtschaft mit verstellbaren Einlegeböden. Einfache Montage dank IKEA-System.',
            'category' => 'Möbel',
        ],
        [
            'name' => 'Philips Hue LED-Leuchten',
            'description' => 'Intelligente LED-Beleuchtung mit 16 Millionen Farben, steuerbar per App. Schaffen Sie die perfekte Atmosphäre für jeden Anlass.',
            'category' => 'Beleuchtung',
        ],
        [
            'name' => 'Bosch Akkuschrauber PSR 18',
            'description' => 'Leistungsstarker Akkuschrauber mit bürstenlosem Motor und zwei Akkus. Ideal für Heimwerker und professionelle Anwendungen.',
            'category' => 'Heimwerken & Werkzeug',
        ],
        [
            'name' => 'WMF Topfset Provence Plus',
            'description' => 'Hochwertiges Topfset aus Edelstahl mit Antihaftbeschichtung. Geeignet für alle Herdarten inklusive Induktion.',
            'category' => 'Küche & Haushalt',
        ],
        [
            'name' => 'Dyson V15 Detect Staubsauger',
            'description' => 'Kabelloser Staubsauger mit Laser-Stauberkennung und fortschrittlicher Filtration. Reinigen Sie Ihr Zuhause effizienter denn je.',
            'category' => 'Küche & Haushalt',
        ],
        [
            'name' => 'Siemens Geschirrspüler',
            'description' => 'Energieeffizienter Geschirrspüler mit intelligenten Programmen und leiser Bedienung. Deutsche Ingenieurskunst für perfekte Sauberkeit.',
            'category' => 'Küche & Haushalt',
        ],
        [
            'name' => 'Weber Genesis Gasgrill',
            'description' => 'Premium-Gasgrill mit porzellanemaillierten Grillrosten und präziser Temperaturkontrolle. Perfekt für Outdoor-Genuss.',
            'category' => 'Garten & Terrasse',
        ],
        [
            'name' => 'Gardena Bewässerungsset',
            'description' => 'Automatisches Bewässerungssystem für Garten und Balkon. Intelligente Pflanzenversorgung auch im Urlaub.',
            'category' => 'Garten & Terrasse',
        ],
        [
            'name' => 'Nespresso Vertuo Kaffeemaschine',
            'description' => 'Premium-Kaffeemaschine mit Kapsel-System für perfekten Espresso und Lungo. Barista-Qualität für zu Hause.',
            'category' => 'Küche & Haushalt',
        ],
        [
            'name' => 'Tempur Cloud Matratze',
            'description' => 'Premium-Matratze aus viskoelastischem Schaum mit optimaler Druckentlastung. Für erholsamen Schlaf und Komfort.',
            'category' => 'Möbel',
        ],

        // Books & Media
        [
            'name' => 'Der Schwarm - Frank Schätzing',
            'description' => 'Spannender Thriller über die Geheimnisse der Tiefsee. Ein internationaler Bestseller, der Wissenschaft und Spannung vereint.',
            'category' => 'Bücher',
        ],
        [
            'name' => 'Harry Potter Gesamtausgabe',
            'description' => 'Komplette Harry Potter Saga in einer hochwertigen Ausgabe. Die magische Welt von J.K. Rowling zum Sammeln.',
            'category' => 'Bücher',
        ],
        [
            'name' => 'Spotify Premium Jahresabo',
            'description' => 'Premium-Musik-Streaming ohne Werbung mit Offline-Downloads. Zugang zu über 100 Millionen Songs und Podcasts.',
            'category' => 'Musik',
        ],
        [
            'name' => 'Netflix Geschenkgutschein',
            'description' => 'Digitaler Geschenkgutschein für Netflix Streaming-Service. Das perfekte Geschenk für Entertainment-Liebhaber.',
            'category' => 'Filme & Serien',
        ],
        [
            'name' => 'Das Parfum - Patrick Süskind',
            'description' => 'Literarischer Klassiker über einen Mann mit außergewöhnlichem Geruchssinn. Ein Meisterwerk der deutschen Literatur.',
            'category' => 'Bücher',
        ],
        [
            'name' => 'Die Unendliche Geschichte',
            'description' => 'Fantasy-Klassiker von Michael Ende über die magische Welt Phantásien. Ein zeitloser Roman für alle Altersgruppen.',
            'category' => 'Bücher',
        ],
        [
            'name' => 'Adobe Creative Suite Lizenz',
            'description' => 'Komplette Kreativ-Software mit Photoshop, Illustrator und Premiere Pro. Professionelle Tools für kreative Projekte.',
            'category' => 'Games & Software',
        ],
        [
            'name' => 'Microsoft Office 365',
            'description' => 'Vollständige Produktivitäts-Suite mit Word, Excel, PowerPoint und Cloud-Speicher. Alles für Beruf und Privat.',
            'category' => 'Games & Software',
        ],

        // Food & Beverages
        [
            'name' => 'Ritter Sport Schokolade',
            'description' => 'Zarte Vollmilchschokolade mit gerösteten Haselnüssen aus nachhaltiger Produktion. Ein Genuss für alle Sinne.',
            'category' => 'Süßwaren',
        ],
        [
            'name' => 'Haribo Goldbären 200g',
            'description' => 'Fruchtig-süße Gummibärchen in den klassischen fünf Geschmacksrichtungen. Der beliebte Snack für Groß und Klein.',
            'category' => 'Süßwaren',
        ],
        [
            'name' => 'Lavazza Espresso Bohnen',
            'description' => 'Aromatische Espresso-Bohnen aus fairem Handel, perfekt geröstet für den authentischen italienischen Geschmack.',
            'category' => 'Getränke',
        ],
        [
            'name' => 'Teekanne Früchtetee Mix',
            'description' => 'Vielfältige Auswahl an Früchtetees mit natürlichen Aromen. Perfekt für entspannende Momente am Tag.',
            'category' => 'Getränke',
        ],
        [
            'name' => 'Beck\'s Pils 20x0,5l',
            'description' => 'Deutsches Premium-Pilsener mit charakteristischem Geschmack. Gebraut nach dem deutschen Reinheitsgebot.',
            'category' => 'Getränke',
        ],
        [
            'name' => 'Ferrero Rocher Pralinen',
            'description' => 'Edle Pralinen mit ganzer gerösteter Haselnuss, umhüllt von zarter Schokolade und knusprigen Haselnuss-Stückchen.',
            'category' => 'Süßwaren',
        ],
        [
            'name' => 'Milka Alpenmilch Tafel',
            'description' => 'Cremige Alpenmilch-Schokolade aus den besten Zutaten. Die zarteste Versuchung, seit es Schokolade gibt.',
            'category' => 'Süßwaren',
        ],
        [
            'name' => 'Dallmayr Kaffee Classic',
            'description' => 'Traditioneller deutscher Röstkaffee mit ausgewogenem Aroma. Seit 1700 Münchner Kaffee-Tradition.',
            'category' => 'Getränke',
        ],

        // Sports & Outdoor
        [
            'name' => 'Adidas Fußball Tiro 23',
            'description' => 'Professioneller Trainingsball mit FIFA-Zulassung. Optimale Flugeigenschaften für Training und Spiel.',
            'category' => 'Sport & Freizeit',
        ],
        [
            'name' => 'Nike Dri-FIT Laufshirt',
            'description' => 'Funktionsshirt mit Feuchtigkeitstransport für optimalen Tragekomfort beim Sport. Entwickelt für Höchstleistungen.',
            'category' => 'Sportbekleidung',
        ],
        [
            'name' => 'Decathlon Fahrradhelm',
            'description' => 'Sicherheitshelm mit optimaler Belüftung und verstellbarem Größensystem. CE-zertifiziert für maximalen Schutz.',
            'category' => 'Fahrräder',
        ],
        [
            'name' => 'Salomon Wanderschuhe',
            'description' => 'Wasserdichte Wanderschuhe mit rutschfester Sohle und optimaler Dämpfung. Für anspruchsvolle Outdoor-Abenteuer.',
            'category' => 'Camping & Wandern',
        ],
        [
            'name' => 'Yoga-Matte rutschfest',
            'description' => 'Premium Yoga-Matte mit überlegenem Grip und Dämpfung. Perfekt für Yoga, Pilates und Fitness-Übungen.',
            'category' => 'Fitness',
        ],
        [
            'name' => 'Kettler Hantelset',
            'description' => 'Verstellbares Hantelset für effektives Krafttraining zu Hause. Ersetzt komplette Gewichts-Sammlung.',
            'category' => 'Fitness',
        ],
        [
            'name' => 'Thule Fahrradanhänger',
            'description' => 'Sicherer Fahrradanhänger für Kinder mit 5-Punkt-Gurt und Federung. Höchste Sicherheitsstandards für Familienausflüge.',
            'category' => 'Fahrräder',
        ],
        [
            'name' => 'Mammut Kletterseil',
            'description' => 'Professionelles Kletterseil mit UIAA-Zertifizierung. Maximale Sicherheit für Alpinisten und Kletterer.',
            'category' => 'Camping & Wandern',
        ],

        // Health & Beauty
        [
            'name' => 'Nivea Creme Dose 150ml',
            'description' => 'Klassische Hautcreme mit bewährter Formel für die ganze Familie. Seit über 100 Jahren vertraute Hautpflege.',
            'category' => 'Körperpflege',
        ],
        [
            'name' => 'L\'Oréal Shampoo Elvital',
            'description' => 'Pflegendes Shampoo mit wertvollen Inhaltsstoffen für gesundes und glänzendes Haar. Professionelle Haarpflege für zu Hause.',
            'category' => 'Körperpflege',
        ],
        [
            'name' => 'Braun Oral-B Zahnbürste',
            'description' => 'Elektrische Zahnbürste mit oszillierend-rotierender Technologie. Klinisch bewiesene Plaque-Entfernung.',
            'category' => 'Körperpflege',
        ],
        [
            'name' => 'Dior Sauvage Parfum',
            'description' => 'Maskuliner Duft mit frischen und würzigen Noten. Ein moderner Klassiker der französischen Parfümerie.',
            'category' => 'Parfüm & Kosmetik',
        ],
        [
            'name' => 'Eucerin Gesichtscreme',
            'description' => 'Dermatologisch getestete Gesichtscreme für empfindliche Haut. Entwickelt in deutschen Forschungslaboren.',
            'category' => 'Körperpflege',
        ],
        [
            'name' => 'Gillette Fusion5 Rasierer',
            'description' => 'Präzisionsrasierer mit fünf Klingen und Gleitstreifen. Sorgt für eine gründliche und komfortable Rasur.',
            'category' => 'Körperpflege',
        ],
        [
            'name' => 'Schwarzkopf Haarfarbe',
            'description' => 'Professionelle Haarfarbe mit langanhaltender Farbbrillanz. Schonende Formel für salon-ähnliche Ergebnisse zu Hause.',
            'category' => 'Körperpflege',
        ],
        [
            'name' => 'The Ordinary Serum Set',
            'description' => 'Klinische Hautpflege-Serie mit konzentrierten Wirkstoffen. Erschwingliche, wissenschaftlich fundierte Kosmetik.',
            'category' => 'Parfüm & Kosmetik',
        ],
    ];

    /**
     * Legacy arrays for backward compatibility
     * @deprecated Use $products instead
     */
    protected static $productNames = [];
    protected static $productDescriptions = [];
    protected static $productCategories = [];
}