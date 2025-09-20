<?php declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers\en_US;

use Bambamboole\ExtendedFaker\Providers\Product as BaseProduct;

class Product extends BaseProduct
{
    /**
     * English product names across various categories
     */
    protected static $productNames = [
        // Electronics
        'Samsung Galaxy S24 Ultra 5G',
        'iPhone 15 Pro Max 256GB',
        'MacBook Air M2 13-inch',
        'Dell XPS 13 Plus Laptop',
        'Sony WH-1000XM5 Headphones',
        'iPad Air 5th Generation',
        'Nintendo Switch OLED Console',
        'PlayStation 5 Digital Edition',
        'Apple AirPods Pro 2nd Gen',
        'LG C3 55" OLED Smart TV',
        'Canon EOS R6 Mark II',
        'Amazon Kindle Paperwhite',
        'Google Pixel 8 Pro',
        'Microsoft Surface Pro 9',

        // Clothing & Fashion
        'Levi\'s 501 Original Fit Jeans',
        'Adidas Stan Smith Sneakers',
        'Nike Air Force 1 Low',
        'Champion Powerblend Hoodie',
        'Patagonia Better Sweater Jacket',
        'Ray-Ban Aviator Sunglasses',
        'Calvin Klein Cotton T-Shirt',
        'The North Face Nuptse Jacket',
        'Converse Chuck 70 High Top',
        'Under Armour HeatGear Shirt',
        'Timberland 6-Inch Premium Boots',
        'Polo Ralph Lauren Oxford Shirt',

        // Home & Garden
        'Instant Pot Duo 7-in-1',
        'Dyson V15 Detect Cordless Vacuum',
        'KitchenAid Stand Mixer',
        'Ninja Foodi Personal Blender',
        'Keurig K-Elite Coffee Maker',
        'Roomba i7+ Robot Vacuum',
        'Philips Hue Smart Bulbs',
        'Weber Genesis II Gas Grill',
        'Casper Original Mattress',
        'Black+Decker Drill Set',
        'Shark Navigator Vacuum',
        'Cuisinart Food Processor',

        // Books & Media
        'Where the Crawdads Sing',
        'The Seven Husbands of Evelyn Hugo',
        'Spotify Premium Annual Plan',
        'Netflix Gift Card $50',
        'The Thursday Murder Club',
        'Atomic Habits by James Clear',
        'Adobe Creative Cloud License',
        'Microsoft 365 Personal',
        'Audible Premium Plus',
        'Disney+ Annual Subscription',

        // Food & Beverages
        'Ghirardelli Dark Chocolate',
        'Starbucks Pike Place Coffee',
        'KIND Protein Bars Variety Pack',
        'Blue Diamond Almonds',
        'Ben & Jerry\'s Ice Cream',
        'Clif Bar Energy Bars',
        'Harney & Sons Tea Selection',
        'Lindt Lindor Truffles',
        'Whole Foods Organic Honey',
        'Trader Joe\'s Everything Bagel',

        // Sports & Fitness
        'Nike Dri-FIT Running Shorts',
        'Adidas Ultraboost 22 Shoes',
        'Yeti Rambler Water Bottle',
        'Fitbit Charge 5 Tracker',
        'Wilson Tennis Racket',
        'Spalding NBA Basketball',
        'Yoga Mat Non-Slip Extra Thick',
        'Bowflex Adjustable Dumbbells',
        'Peloton Bike+ Accessories',
        'New Balance Fresh Foam Shoes',

        // Health & Beauty
        'CeraVe Moisturizing Cream',
        'The Ordinary Niacinamide Serum',
        'Neutrogena Ultra Sheer Sunscreen',
        'Olaplex Hair Treatment Set',
        'Fenty Beauty Foundation',
        'Clinique Dramatically Different Lotion',
        'Gillette Fusion5 Razor',
        'Bath & Body Works Hand Cream',
        'Drunk Elephant Vitamin C Serum',
        'Charlotte Tilbury Lipstick',

        // Baby & Kids
        'Fisher-Price Rock \'n Play',
        'Baby Einstein Activity Table',
        'Pampers Baby Dry Diapers',
        'Chicco KeyFit Car Seat',
        'Skip Hop Diaper Bag',
        'VTech Learning Tablet',
        'Melissa & Doug Wooden Puzzles',
        'Crayola Art Supplies Set',

        // Automotive
        'WeatherTech Floor Mats',
        'Chemical Guys Car Wash Kit',
        'Garmin DriveSmart GPS',
        'Armor All Cleaning Wipes',
        'Rain-X Windshield Treatment',
        'Michelin Wiper Blades',
    ];

    /**
     * English product descriptions with varied lengths and styles
     */
    protected static $productDescriptions = [
        // Tech descriptions
        'Cutting-edge smartphone featuring a 6.8-inch Dynamic AMOLED display, 200MP camera system, and up to 1TB storage. Perfect for photography enthusiasts and power users.',
        'Revolutionary laptop powered by Apple\'s M2 chip, delivering exceptional performance with incredible battery life. Ideal for creative professionals and students alike.',
        'Industry-leading noise-canceling headphones with 30-hour battery life and premium sound quality. Experience music like never before.',
        'Next-generation gaming console with 4K graphics, lightning-fast loading times, and an extensive game library. The ultimate gaming experience awaits.',
        'Ultra-sharp OLED display with Dolby Vision HDR and smart TV capabilities. Transform your living room into a home theater.',

        // Fashion descriptions
        'Classic straight-leg jeans crafted from 100% cotton denim with authentic vintage wash. Timeless style that never goes out of fashion.',
        'Iconic white leather sneakers with green accents. A true classic that combines comfort, style, and versatility for any occasion.',
        'Premium cotton hoodie with kangaroo pocket and adjustable drawstring hood. Perfect for casual wear and athletic activities.',
        'Lightweight jacket made from recycled polyester fleece. Sustainable fashion that doesn\'t compromise on warmth or style.',

        // Home descriptions
        '7-in-1 multi-functional pressure cooker that replaces multiple kitchen appliances. Cook meals up to 70% faster while retaining nutrients and flavor.',
        'Powerful cordless vacuum with laser dust detection and advanced filtration. Clean your home more efficiently than ever before.',
        'Professional-grade stand mixer with 10-speed motor and multiple attachments. The perfect tool for serious bakers and cooking enthusiasts.',
        'Smart lighting system with 16 million colors and app control. Create the perfect ambiance for any mood or occasion.',

        // Short descriptions
        'Premium quality at an affordable price.',
        'Made in USA with sustainable materials.',
        'Bestseller with over 50,000 five-star reviews.',
        'Limited edition - while supplies last.',
        'Handcrafted by skilled artisans.',
        'Lifetime warranty included.',
        'Award-winning design and functionality.',
        'Customer favorite for three years running.',

        // Food descriptions
        'Rich dark chocolate made with ethically sourced cocoa beans. Indulge in the perfect balance of sweetness and intensity.',
        'Medium roast coffee blend with notes of cocoa and toasted nuts. Enjoy the signature Starbucks taste at home.',
        'Protein-packed energy bars made with real ingredients. Fuel your active lifestyle with delicious, nutritious snacks.',

        // Long detailed descriptions
        'This innovative product combines state-of-the-art technology with user-friendly design. The premium construction and thoughtful details make it the perfect companion for daily use. With its energy-efficient design and intuitive operation, it sets new standards in its category. Customer reviews consistently praise its durability and exceptional value for money.',
        'Manufactured in the United States to the highest quality standards, this product excels in both performance and reliability. The carefully selected materials and precise manufacturing ensure long-lasting durability. Advanced production techniques guarantee precision while maintaining environmentally responsible manufacturing practices.',
        'Designed by award-winning engineers and tested by industry professionals, this product delivers unmatched performance in its class. The ergonomic design and premium materials ensure comfort during extended use, while the advanced features provide professional-grade results. Backed by our comprehensive warranty and world-class customer service.',
    ];

    /**
     * English product categories
     */
    protected static $productCategories = [
        'Electronics',
        'Computers & Accessories',
        'Cell Phones & Smartphones',
        'TV & Home Audio',
        'Camera & Photo',
        'Video Games',
        'Wearable Technology',

        'Clothing & Fashion',
        'Men\'s Clothing',
        'Women\'s Clothing',
        'Shoes & Footwear',
        'Jewelry & Watches',
        'Bags & Luggage',
        'Accessories',

        'Home & Garden',
        'Furniture',
        'Kitchen & Dining',
        'Patio & Garden',
        'Tools & Hardware',
        'Lighting & Electrical',
        'Home Décor',
        'Bedding & Bath',

        'Sports & Outdoors',
        'Exercise & Fitness',
        'Outdoor Recreation',
        'Bicycles & Accessories',
        'Athletic Apparel',
        'Camping & Hiking',
        'Water Sports',

        'Health & Beauty',
        'Personal Care',
        'Makeup & Cosmetics',
        'Health & Wellness',
        'Vitamins & Supplements',
        'Skin Care',
        'Hair Care',

        'Books & Media',
        'Books',
        'eBooks & Audiobooks',
        'Movies & TV Shows',
        'Music',
        'Software & Games',
        'Magazines',

        'Food & Beverages',
        'Snacks & Candy',
        'Beverages',
        'Organic & Natural',
        'Gourmet Food',
        'Coffee & Tea',

        'Automotive',
        'Car Accessories',
        'Motorcycle & ATV',
        'Replacement Parts',
        'Car Care',
        'Tools & Equipment',

        'Baby & Kids',
        'Baby Clothing',
        'Toys & Games',
        'School Supplies',
        'Baby Gear',
        'Nursery',

        'Pet Supplies',
        'Dog Supplies',
        'Cat Supplies',
        'Fish & Aquatic Pets',
        'Small Animals',
        'Pet Health',
    ];
}
