<?php

namespace App\Enums;

enum DefaultCategoryEnum: string
{
    case ELECTRONICS = 'Electronics';
    case FASHION = 'Fashion';
    case HOME_KITCHEN = 'Home & Kitchen';
    case BEAUTY_PERSONAL_CARE = 'Beauty & Personal Care';
    case SPORTS_OUTDOORS = 'Sports & Outdoors';
    case HEALTH_WELLNESS = 'Health & Wellness';
    case BOOKS_STATIONERY = 'Books & Stationery';
    case TOYS_GAMES = 'Toys & Games';
    case AUTOMOTIVE = 'Automotive';
    case PET_SUPPLIES = 'Pet Supplies';
    case BABY_PRODUCTS = 'Baby Products';
    case JEWELRY_WATCHES = 'Jewelry & Watches';
    case OFFICE_SUPPLIES = 'Office Supplies';
    case GARDEN_OUTDOOR = 'Garden & Outdoor';
    case GROCERY_GOURMET_FOOD = 'Grocery & Gourmet Food';
    case FURNITURE = 'Furniture';
    case MUSICAL_INSTRUMENTS = 'Musical Instruments';
    case SOFTWARE = 'Software';
    case TOOLS_HOME_IMPROVEMENT = 'Tools & Home Improvement';
    case VIDEO_GAMES = 'Video Games';
    case CAMERAS_PHOTOGRAPHY = 'Cameras & Photography';
    case MOVIES_TV = 'Movies & TV';
    case HANDMADE_PRODUCTS = 'Handmade Products';
    case LUGGAGE_TRAVEL_GEAR = 'Luggage & Travel Gear';
    case INDUSTRIAL_SCIENTIFIC = 'Industrial & Scientific';


    /**
     * returns all properties in array format
     * @return array
     */
    public static function all(): array
    {
        return array_combine(
            array_map(fn ($case) => $case->name, self::cases()),
            array_map(fn ($case) => $case->value, self::cases())
        );
    }
}
