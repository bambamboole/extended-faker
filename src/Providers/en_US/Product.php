<?php declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers\en_US;

use Bambamboole\ExtendedFaker\Providers\Product as BaseProduct;

class Product extends BaseProduct
{
    /**
     * English product data with name-description-category mappings
     */
    protected static $products = [
        // Electronics
        [
            'name' => 'Samsung Galaxy S24 Ultra 5G',
            'description' => 'Cutting-edge smartphone featuring a 6.8-inch Dynamic AMOLED display, 200MP camera system, and up to 1TB storage. Perfect for photography enthusiasts and power users.',
            'category' => 'Cell Phones & Smartphones',
        ],
        [
            'name' => 'iPhone 15 Pro Max 256GB',
            'description' => 'Revolutionary smartphone with titanium design and advanced A17 Pro chip. Features Pro camera system with incredible detail and next-generation performance.',
            'category' => 'Cell Phones & Smartphones',
        ],
        [
            'name' => 'MacBook Air M2 13-inch',
            'description' => 'Revolutionary laptop powered by Apple\'s M2 chip, delivering exceptional performance with incredible battery life. Ideal for creative professionals and students alike.',
            'category' => 'Computers & Accessories',
        ],
        [
            'name' => 'Dell XPS 13 Plus Laptop',
            'description' => 'Premium ultrabook with stunning InfinityEdge display and latest Intel processors. Engineered for productivity and designed for portability.',
            'category' => 'Computers & Accessories',
        ],
        [
            'name' => 'Sony WH-1000XM5 Headphones',
            'description' => 'Industry-leading noise-canceling headphones with 30-hour battery life and premium sound quality. Experience music like never before.',
            'category' => 'Electronics',
        ],
        [
            'name' => 'iPad Air 5th Generation',
            'description' => 'Powerful tablet with M1 chip and stunning Liquid Retina display. Perfect for creativity, productivity, and entertainment on the go.',
            'category' => 'Electronics',
        ],
        [
            'name' => 'Nintendo Switch OLED Console',
            'description' => 'Next-generation gaming console with vibrant OLED screen and enhanced audio. Play your favorite games anywhere, anytime.',
            'category' => 'Video Games',
        ],
        [
            'name' => 'PlayStation 5 Digital Edition',
            'description' => 'Next-generation gaming console with 4K graphics, lightning-fast loading times, and an extensive game library. The ultimate gaming experience awaits.',
            'category' => 'Video Games',
        ],
        [
            'name' => 'Apple AirPods Pro 2nd Gen',
            'description' => 'Advanced wireless earbuds with active noise cancellation and spatial audio. Premium sound quality in a compact, comfortable design.',
            'category' => 'Wearable Technology',
        ],
        [
            'name' => 'LG C3 55" OLED Smart TV',
            'description' => 'Ultra-sharp OLED display with Dolby Vision HDR and smart TV capabilities. Transform your living room into a home theater.',
            'category' => 'TV & Home Audio',
        ],
        [
            'name' => 'Canon EOS R6 Mark II',
            'description' => 'Professional mirrorless camera with exceptional image quality and advanced autofocus. Perfect for photography enthusiasts and professionals.',
            'category' => 'Camera & Photo',
        ],
        [
            'name' => 'Amazon Kindle Paperwhite',
            'description' => 'Premium e-reader with high-resolution display and weeks of battery life. Enjoy thousands of books in a lightweight, portable device.',
            'category' => 'Electronics',
        ],
        [
            'name' => 'Google Pixel 8 Pro',
            'description' => 'AI-powered smartphone with advanced camera system and pure Android experience. Capture stunning photos with computational photography.',
            'category' => 'Cell Phones & Smartphones',
        ],
        [
            'name' => 'Microsoft Surface Pro 9',
            'description' => 'Versatile 2-in-1 laptop and tablet with touchscreen display. Perfect for professionals who need flexibility and performance.',
            'category' => 'Computers & Accessories',
        ],

        // Clothing & Fashion
        [
            'name' => 'Levi\'s 501 Original Fit Jeans',
            'description' => 'Classic straight-leg jeans crafted from 100% cotton denim with authentic vintage wash. Timeless style that never goes out of fashion.',
            'category' => 'Men\'s Clothing',
        ],
        [
            'name' => 'Adidas Stan Smith Sneakers',
            'description' => 'Iconic white leather sneakers with green accents. A true classic that combines comfort, style, and versatility for any occasion.',
            'category' => 'Shoes & Footwear',
        ],
        [
            'name' => 'Nike Air Force 1 Low',
            'description' => 'Legendary basketball shoes with premium leather construction and Air-Sole cushioning. A streetwear icon for over four decades.',
            'category' => 'Shoes & Footwear',
        ],
        [
            'name' => 'Champion Powerblend Hoodie',
            'description' => 'Premium cotton hoodie with kangaroo pocket and adjustable drawstring hood. Perfect for casual wear and athletic activities.',
            'category' => 'Men\'s Clothing',
        ],
        [
            'name' => 'Patagonia Better Sweater Jacket',
            'description' => 'Lightweight jacket made from recycled polyester fleece. Sustainable fashion that doesn\'t compromise on warmth or style.',
            'category' => 'Clothing & Fashion',
        ],
        [
            'name' => 'Ray-Ban Aviator Sunglasses',
            'description' => 'Classic aviator sunglasses with premium UV protection and iconic design. A timeless accessory that never goes out of style.',
            'category' => 'Accessories',
        ],
        [
            'name' => 'Calvin Klein Cotton T-Shirt',
            'description' => 'Premium cotton t-shirt with comfortable fit and modern styling. Essential wardrobe staple with superior quality and comfort.',
            'category' => 'Men\'s Clothing',
        ],
        [
            'name' => 'The North Face Nuptse Jacket',
            'description' => 'Insulated down jacket with water-resistant fabric and packable design. Perfect for outdoor adventures and urban exploration.',
            'category' => 'Clothing & Fashion',
        ],
        [
            'name' => 'Converse Chuck 70 High Top',
            'description' => 'Premium canvas sneakers with vintage-inspired design and enhanced comfort. A classic silhouette with modern improvements.',
            'category' => 'Shoes & Footwear',
        ],
        [
            'name' => 'Under Armour HeatGear Shirt',
            'description' => 'Moisture-wicking athletic shirt with anti-odor technology. Designed for peak performance during intense workouts.',
            'category' => 'Athletic Apparel',
        ],
        [
            'name' => 'Timberland 6-Inch Premium Boots',
            'description' => 'Durable waterproof boots with premium leather construction. Built to withstand tough conditions while maintaining classic style.',
            'category' => 'Shoes & Footwear',
        ],
        [
            'name' => 'Polo Ralph Lauren Oxford Shirt',
            'description' => 'Classic button-down shirt with premium cotton construction and timeless design. Perfect for business casual and formal occasions.',
            'category' => 'Men\'s Clothing',
        ],

        // Home & Garden
        [
            'name' => 'Instant Pot Duo 7-in-1',
            'description' => '7-in-1 multi-functional pressure cooker that replaces multiple kitchen appliances. Cook meals up to 70% faster while retaining nutrients and flavor.',
            'category' => 'Kitchen & Dining',
        ],
        [
            'name' => 'Dyson V15 Detect Cordless Vacuum',
            'description' => 'Powerful cordless vacuum with laser dust detection and advanced filtration. Clean your home more efficiently than ever before.',
            'category' => 'Home & Garden',
        ],
        [
            'name' => 'KitchenAid Stand Mixer',
            'description' => 'Professional-grade stand mixer with 10-speed motor and multiple attachments. The perfect tool for serious bakers and cooking enthusiasts.',
            'category' => 'Kitchen & Dining',
        ],
        [
            'name' => 'Ninja Foodi Personal Blender',
            'description' => 'Compact personal blender with powerful motor and portable cups. Perfect for smoothies, protein shakes, and on-the-go nutrition.',
            'category' => 'Kitchen & Dining',
        ],
        [
            'name' => 'Keurig K-Elite Coffee Maker',
            'description' => 'Premium single-serve coffee maker with strong brew setting and multiple cup sizes. Enjoy café-quality coffee at home.',
            'category' => 'Kitchen & Dining',
        ],
        [
            'name' => 'Roomba i7+ Robot Vacuum',
            'description' => 'Smart robot vacuum with automatic dirt disposal and advanced navigation. Clean your home hands-free with intelligent mapping.',
            'category' => 'Home & Garden',
        ],
        [
            'name' => 'Philips Hue Smart Bulbs',
            'description' => 'Smart lighting system with 16 million colors and app control. Create the perfect ambiance for any mood or occasion.',
            'category' => 'Lighting & Electrical',
        ],
        [
            'name' => 'Weber Genesis II Gas Grill',
            'description' => 'Premium gas grill with porcelain-enameled cooking grates and precise temperature control. Perfect for outdoor entertaining.',
            'category' => 'Patio & Garden',
        ],
        [
            'name' => 'Casper Original Mattress',
            'description' => 'Premium memory foam mattress with zoned support and cooling technology. Designed for optimal comfort and temperature regulation.',
            'category' => 'Bedding & Bath',
        ],
        [
            'name' => 'Black+Decker Drill Set',
            'description' => 'Cordless drill set with multiple bits and carrying case. Essential tool for home improvement and DIY projects.',
            'category' => 'Tools & Hardware',
        ],
        [
            'name' => 'Shark Navigator Vacuum',
            'description' => 'Powerful upright vacuum with HEPA filtration and swivel steering. Deep clean carpets and hard floors with ease.',
            'category' => 'Home & Garden',
        ],
        [
            'name' => 'Cuisinart Food Processor',
            'description' => 'Versatile food processor with multiple attachments and large capacity bowl. Essential kitchen appliance for meal preparation.',
            'category' => 'Kitchen & Dining',
        ],

        // Books & Media
        [
            'name' => 'Where the Crawdads Sing',
            'description' => 'Bestselling novel combining mystery, coming-of-age, and nature writing. A captivating story that has touched millions of readers worldwide.',
            'category' => 'Books',
        ],
        [
            'name' => 'The Seven Husbands of Evelyn Hugo',
            'description' => 'Compelling novel about a reclusive Hollywood icon finally ready to tell her story. A tale of ambition, love, and the price of fame.',
            'category' => 'Books',
        ],
        [
            'name' => 'Spotify Premium Annual Plan',
            'description' => 'Premium music streaming service with ad-free listening and offline downloads. Access to over 100 million songs and podcasts.',
            'category' => 'Music',
        ],
        [
            'name' => 'Netflix Gift Card $50',
            'description' => 'Digital gift card for Netflix streaming service. Perfect gift for entertainment lovers to enjoy movies, series, and documentaries.',
            'category' => 'Movies & TV Shows',
        ],
        [
            'name' => 'The Thursday Murder Club',
            'description' => 'Charming mystery novel featuring four unlikely detectives in a retirement community. A delightful blend of humor and suspense.',
            'category' => 'Books',
        ],
        [
            'name' => 'Atomic Habits by James Clear',
            'description' => 'Transformative guide to building good habits and breaking bad ones. Practical strategies for personal and professional development.',
            'category' => 'Books',
        ],
        [
            'name' => 'Adobe Creative Cloud License',
            'description' => 'Complete creative software suite including Photoshop, Illustrator, and Premiere Pro. Essential tools for creative professionals.',
            'category' => 'Software & Games',
        ],
        [
            'name' => 'Microsoft 365 Personal',
            'description' => 'Complete productivity suite with Word, Excel, PowerPoint, and cloud storage. Everything you need for work and personal projects.',
            'category' => 'Software & Games',
        ],
        [
            'name' => 'Audible Premium Plus',
            'description' => 'Premium audiobook service with unlimited listening and exclusive content. Transform your commute into learning time.',
            'category' => 'eBooks & Audiobooks',
        ],
        [
            'name' => 'Disney+ Annual Subscription',
            'description' => 'Streaming service with Disney, Marvel, Star Wars, and National Geographic content. Family-friendly entertainment for all ages.',
            'category' => 'Movies & TV Shows',
        ],

        // Food & Beverages
        [
            'name' => 'Ghirardelli Dark Chocolate',
            'description' => 'Rich dark chocolate made with ethically sourced cocoa beans. Indulge in the perfect balance of sweetness and intensity.',
            'category' => 'Gourmet Food',
        ],
        [
            'name' => 'Starbucks Pike Place Coffee',
            'description' => 'Medium roast coffee blend with notes of cocoa and toasted nuts. Enjoy the signature Starbucks taste at home.',
            'category' => 'Coffee & Tea',
        ],
        [
            'name' => 'KIND Protein Bars Variety Pack',
            'description' => 'Protein-packed energy bars made with real ingredients. Fuel your active lifestyle with delicious, nutritious snacks.',
            'category' => 'Snacks & Candy',
        ],
        [
            'name' => 'Blue Diamond Almonds',
            'description' => 'Premium roasted almonds with bold flavors and natural ingredients. Healthy snacking that doesn\'t compromise on taste.',
            'category' => 'Snacks & Candy',
        ],
        [
            'name' => 'Ben & Jerry\'s Ice Cream',
            'description' => 'Premium ice cream made with the finest ingredients and creative flavor combinations. Indulgent treat for any occasion.',
            'category' => 'Food & Beverages',
        ],
        [
            'name' => 'Clif Bar Energy Bars',
            'description' => 'Organic energy bars made with wholesome ingredients. Perfect fuel for athletes and outdoor enthusiasts.',
            'category' => 'Snacks & Candy',
        ],
        [
            'name' => 'Harney & Sons Tea Selection',
            'description' => 'Premium tea collection with diverse flavors and exceptional quality. Elevate your tea experience with artisanal blends.',
            'category' => 'Coffee & Tea',
        ],
        [
            'name' => 'Lindt Lindor Truffles',
            'description' => 'Smooth melting chocolate truffles with irresistible centers. Premium Swiss chocolate craftsmanship in every bite.',
            'category' => 'Gourmet Food',
        ],
        [
            'name' => 'Whole Foods Organic Honey',
            'description' => 'Pure organic honey sourced from sustainable beekeepers. Natural sweetener with rich flavor and nutritional benefits.',
            'category' => 'Organic & Natural',
        ],
        [
            'name' => 'Trader Joe\'s Everything Bagel',
            'description' => 'Artisanal bagels topped with everything seasoning blend. Perfect base for breakfast sandwiches and creative toppings.',
            'category' => 'Food & Beverages',
        ],

        // Sports & Fitness
        [
            'name' => 'Nike Dri-FIT Running Shorts',
            'description' => 'Lightweight running shorts with moisture-wicking technology. Designed for comfort and performance during intense workouts.',
            'category' => 'Athletic Apparel',
        ],
        [
            'name' => 'Adidas Ultraboost 22 Shoes',
            'description' => 'High-performance running shoes with responsive cushioning and energy return. Engineered for runners who demand the best.',
            'category' => 'Athletic Apparel',
        ],
        [
            'name' => 'Yeti Rambler Water Bottle',
            'description' => 'Insulated stainless steel water bottle that keeps drinks cold for 24 hours or hot for 12 hours. Built for adventure.',
            'category' => 'Sports & Outdoors',
        ],
        [
            'name' => 'Fitbit Charge 5 Tracker',
            'description' => 'Advanced fitness tracker with heart rate monitoring, GPS, and health insights. Track your wellness journey 24/7.',
            'category' => 'Wearable Technology',
        ],
        [
            'name' => 'Wilson Tennis Racket',
            'description' => 'Professional tennis racket with optimal weight distribution and string tension. Elevate your game with precision engineering.',
            'category' => 'Sports & Outdoors',
        ],
        [
            'name' => 'Spalding NBA Basketball',
            'description' => 'Official NBA basketball with composite leather construction. Professional quality for serious players and enthusiasts.',
            'category' => 'Sports & Outdoors',
        ],
        [
            'name' => 'Yoga Mat Non-Slip Extra Thick',
            'description' => 'Premium yoga mat with superior grip and cushioning. Perfect for yoga, pilates, and home workout routines.',
            'category' => 'Exercise & Fitness',
        ],
        [
            'name' => 'Bowflex Adjustable Dumbbells',
            'description' => 'Space-saving adjustable dumbbells that replace entire weight sets. Perfect for home gym and strength training.',
            'category' => 'Exercise & Fitness',
        ],
        [
            'name' => 'Peloton Bike+ Accessories',
            'description' => 'Premium accessories for enhanced Peloton experience. Transform your home into a professional cycling studio.',
            'category' => 'Exercise & Fitness',
        ],
        [
            'name' => 'New Balance Fresh Foam Shoes',
            'description' => 'Comfortable running shoes with advanced foam cushioning. Designed for runners who prioritize comfort and performance.',
            'category' => 'Athletic Apparel',
        ],

        // Health & Beauty
        [
            'name' => 'CeraVe Moisturizing Cream',
            'description' => 'Daily moisturizing cream with essential ceramides and hyaluronic acid. Dermatologist-recommended for healthy skin.',
            'category' => 'Skin Care',
        ],
        [
            'name' => 'The Ordinary Niacinamide Serum',
            'description' => 'Concentrated serum that reduces appearance of skin blemishes and congestion. Clinical-strength skincare at affordable prices.',
            'category' => 'Skin Care',
        ],
        [
            'name' => 'Neutrogena Ultra Sheer Sunscreen',
            'description' => 'Lightweight sunscreen with broad-spectrum SPF protection. Non-greasy formula that absorbs quickly for daily use.',
            'category' => 'Personal Care',
        ],
        [
            'name' => 'Olaplex Hair Treatment Set',
            'description' => 'Professional hair treatment system that repairs and strengthens damaged hair. Salon-quality results at home.',
            'category' => 'Hair Care',
        ],
        [
            'name' => 'Fenty Beauty Foundation',
            'description' => 'Long-wearing foundation with extensive shade range and buildable coverage. Inclusive beauty for all skin tones.',
            'category' => 'Makeup & Cosmetics',
        ],
        [
            'name' => 'Clinique Dramatically Different Lotion',
            'description' => 'Iconic moisturizing lotion that strengthens skin\'s moisture barrier. Dermatologist-developed for healthier-looking skin.',
            'category' => 'Skin Care',
        ],
        [
            'name' => 'Gillette Fusion5 Razor',
            'description' => 'Advanced razor with five precision blades and lubrication strip. Delivers a close, comfortable shave every time.',
            'category' => 'Personal Care',
        ],
        [
            'name' => 'Bath & Body Works Hand Cream',
            'description' => 'Nourishing hand cream with signature fragrances and moisturizing ingredients. Keeps hands soft and beautifully scented.',
            'category' => 'Personal Care',
        ],
        [
            'name' => 'Drunk Elephant Vitamin C Serum',
            'description' => 'Potent vitamin C serum that brightens and firms skin. Award-winning skincare with clinically-proven ingredients.',
            'category' => 'Skin Care',
        ],
        [
            'name' => 'Charlotte Tilbury Lipstick',
            'description' => 'Luxury lipstick with rich color payoff and comfortable wear. Iconic beauty products from celebrity makeup artist.',
            'category' => 'Makeup & Cosmetics',
        ],

        // Baby & Kids
        [
            'name' => 'Fisher-Price Rock \'n Play',
            'description' => 'Portable infant seat with gentle rocking motion and compact design. Perfect for naptime and quiet play.',
            'category' => 'Baby Gear',
        ],
        [
            'name' => 'Baby Einstein Activity Table',
            'description' => 'Interactive activity table with lights, sounds, and educational content. Encourages learning and development through play.',
            'category' => 'Toys & Games',
        ],
        [
            'name' => 'Pampers Baby Dry Diapers',
            'description' => 'Ultra-absorbent diapers with 12-hour protection and soft, comfortable fit. Trusted by parents for superior performance.',
            'category' => 'Baby & Kids',
        ],
        [
            'name' => 'Chicco KeyFit Car Seat',
            'description' => 'Top-rated infant car seat with easy installation and superior safety ratings. Peace of mind for every journey.',
            'category' => 'Baby Gear',
        ],
        [
            'name' => 'Skip Hop Diaper Bag',
            'description' => 'Stylish diaper bag with multiple compartments and practical features. Fashion meets function for modern parents.',
            'category' => 'Baby Gear',
        ],
        [
            'name' => 'VTech Learning Tablet',
            'description' => 'Educational tablet with age-appropriate content and interactive learning games. Screen time that supports development.',
            'category' => 'Toys & Games',
        ],
        [
            'name' => 'Melissa & Doug Wooden Puzzles',
            'description' => 'High-quality wooden puzzles that develop problem-solving skills and creativity. Classic toys that stand the test of time.',
            'category' => 'Toys & Games',
        ],
        [
            'name' => 'Crayola Art Supplies Set',
            'description' => 'Complete art set with crayons, markers, and paper for creative expression. Inspire young artists with quality supplies.',
            'category' => 'School Supplies',
        ],

        // Automotive
        [
            'name' => 'WeatherTech Floor Mats',
            'description' => 'Custom-fit floor mats with superior protection against dirt, water, and wear. Premium automotive accessories made in USA.',
            'category' => 'Car Accessories',
        ],
        [
            'name' => 'Chemical Guys Car Wash Kit',
            'description' => 'Professional car detailing kit with premium soaps, waxes, and microfiber towels. Achieve showroom-quality results at home.',
            'category' => 'Car Care',
        ],
        [
            'name' => 'Garmin DriveSmart GPS',
            'description' => 'Advanced GPS navigator with lifetime maps and traffic updates. Smart features that enhance your driving experience.',
            'category' => 'Electronics',
        ],
        [
            'name' => 'Armor All Cleaning Wipes',
            'description' => 'Convenient cleaning wipes for automotive interior surfaces. Quick and easy way to maintain your vehicle\'s appearance.',
            'category' => 'Car Care',
        ],
        [
            'name' => 'Rain-X Windshield Treatment',
            'description' => 'Advanced windshield treatment that repels rain and improves visibility. Essential for safe driving in wet conditions.',
            'category' => 'Car Care',
        ],
        [
            'name' => 'Michelin Wiper Blades',
            'description' => 'Premium wiper blades with advanced rubber technology and aerodynamic design. Superior visibility in all weather conditions.',
            'category' => 'Replacement Parts',
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