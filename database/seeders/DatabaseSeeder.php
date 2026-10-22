<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $password = (string) env('ADMIN_PASSWORD', '');
        $email = (string) env('ADMIN_EMAIL', 'admin@furnicasa.test');
        if (strlen($password) < 12) {
            throw new \RuntimeException('Set a strong ADMIN_PASSWORD (12+ characters) in .env before running db:seed.');
        }
        User::firstOrCreate(['email' => $email], ['name' => env('ADMIN_NAME', 'FurniCasa Admin'), 'password' => $password, 'role' => 'admin', 'is_active' => true]);
        $cats = [
            ['Living Room', 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=900&q=85'],
            ['Bedroom', 'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?auto=format&fit=crop&w=900&q=85'],
            ['Dining Room', 'https://images.unsplash.com/photo-1617806118233-18e1de247200?auto=format&fit=crop&w=900&q=85'],
            ['Office', 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=900&q=85'],
            ['Outdoor', 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=900&q=85'],
            ['Storage', 'https://images.unsplash.com/photo-1594620302200-9a762244a156?auto=format&fit=crop&w=900&q=85'],
        ];
        foreach ($cats as $index => $item) {
            Category::firstOrCreate(['slug' => Str::slug($item[0])], ['name' => $item[0], 'image' => $item[1], 'description' => 'Well-designed furniture for your '.$item[0], 'sort_order' => $index + 1, 'is_active' => true]);
        }
        $products = [
            ['Living Room', 'Luna 3-Seater Sofa', 'FC-LR-001', 699, 899, 24, 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=1000&q=85', 'Linen upholstery', '210 × 90 × 82 cm', 1],
            ['Living Room', 'Velvet Accent Chair', 'FC-LR-002', 199, 269, 18, 'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?auto=format&fit=crop&w=1000&q=85', 'Velvet / solid wood', '76 × 80 × 82 cm', 1],
            ['Living Room', 'Nordic Oak Coffee Table', 'FC-LR-003', 249, 359, 32, 'https://images.unsplash.com/photo-1499933374294-4584851497cc?auto=format&fit=crop&w=1000&q=85', 'Oak veneer', '90 × 90 × 44 cm', 1],
            ['Bedroom', 'Aurora Upholstered Bed', 'FC-BR-001', 899, 1199, 12, 'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?auto=format&fit=crop&w=1000&q=85', 'Soft woven fabric', 'Queen size', 1],
            ['Bedroom', 'Milo Bedside Table', 'FC-BR-002', 179, 299, 36, 'https://images.unsplash.com/photo-1615874694520-474822394e73?auto=format&fit=crop&w=1000&q=85', 'Engineered wood', '45 × 40 × 54 cm', 0],
            ['Bedroom', 'Serene Bedroom Dresser', 'FC-BR-003', 479, 649, 9, 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1000&q=85', 'Ash wood finish', '130 × 45 × 80 cm', 0],
            ['Dining Room', 'Modern Dining Table Set', 'FC-DR-001', 299, 399, 15, 'https://images.unsplash.com/photo-1617806118233-18e1de247200?auto=format&fit=crop&w=1000&q=85', 'Oak and metal', '6 seater', 1],
            ['Dining Room', 'Scandinavian Dining Chair', 'FC-DR-002', 129, 169, 48, 'https://images.unsplash.com/photo-1503602642458-232111445657?auto=format&fit=crop&w=1000&q=85', 'Natural oak', '48 × 55 × 80 cm', 0],
            ['Dining Room', 'Haven Round Dining Table', 'FC-DR-003', 499, 699, 8, 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1000&q=85', 'Solid hardwood', '110 × 110 × 74 cm', 0],
            ['Office', 'ErgoComfort Office Chair', 'FC-OF-001', 299, 399, 25, 'https://images.unsplash.com/photo-1505797149-43b0069ec26b?auto=format&fit=crop&w=1000&q=85', 'Mesh and steel', 'Adjustable', 1],
            ['Office', 'Atlas Work Desk', 'FC-OF-002', 399, 549, 16, 'https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=1000&q=85', 'Oak and steel', '140 × 70 × 75 cm', 0],
            ['Office', 'Focus Task Lamp', 'FC-OF-003', 89, 129, 41, 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=1000&q=85', 'Powder-coated steel', 'Adjustable arm', 0],
            ['Outdoor', 'Solstice Patio Lounge', 'FC-OU-001', 849, 1149, 11, 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=1000&q=85', 'Weather-resistant fabric', '3-piece set', 0],
            ['Outdoor', 'Terrace Bistro Table', 'FC-OU-002', 259, 349, 23, 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&w=1000&q=85', 'Metal and tempered glass', '70 cm round', 0],
            ['Outdoor', 'Coastal Accent Seat', 'FC-OU-003', 189, 259, 4, 'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=1000&q=85', 'Woven wicker', '70 × 75 × 85 cm', 0],
            ['Storage', 'Minimalist Storage Cabinet', 'FC-ST-001', 349, 499, 17, 'https://images.unsplash.com/photo-1594620302200-9a762244a156?auto=format&fit=crop&w=1000&q=85', 'Natural oak finish', '120 × 40 × 80 cm', 1],
            ['Storage', 'Brooklyn Bookshelf', 'FC-ST-002', 279, 379, 29, 'https://images.unsplash.com/photo-1497366858526-0766cadbe8fa?auto=format&fit=crop&w=1000&q=85', 'Wood and metal', '90 × 34 × 180 cm', 0],
            ['Storage', 'Compact Entry Console', 'FC-ST-003', 219, 289, 3, 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1000&q=85', 'Walnut finish', '100 × 35 × 74 cm', 0],
        ];
        foreach ($products as [$cat,$name,$sku,$price,$compare,$stock,$image,$material,$dimensions,$featured]) {
            $product = Product::firstOrCreate(['sku' => $sku], [
                'category_id' => Category::where('name', $cat)->value('id'), 'name' => $name, 'slug' => Str::slug($name), 'description' => 'Elevate your space with the '.$name.'. Designed with refined details, quality materials and lasting everyday comfort. A beautiful addition to any modern home.',
                'price' => $price, 'compare_at_price' => $compare, 'stock' => $stock, 'low_stock_threshold' => 5, 'image' => $image, 'material' => $material, 'dimensions' => $dimensions, 'is_active' => true, 'is_featured' => (bool) $featured,
            ]);
            if ($product->wasRecentlyCreated && $stock > 0) {
                InventoryMovement::create(['product_id' => $product->id, 'user_id' => User::where('email', $email)->value('id'), 'change' => $stock, 'stock_after' => $stock, 'reason' => 'opening_stock', 'notes' => 'Demo seed stock']);
            }
        }
        foreach ([
            'store_name' => 'FurniCasa', 'support_email' => 'hello@furnicasa.com', 'support_phone' => '+1 234 567 8900',
            'address' => '123 Furniture Street, New York, NY 10001',
            'announcement' => 'FREE DELIVERY on all orders over $499',
            'bank_instructions' => 'Contact our support team for verified bank transfer details and include your order number as the reference.',
        ] as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
        Coupon::firstOrCreate(['code' => 'WELCOME10'], ['type' => 'percent', 'value' => 10, 'min_order' => 150, 'usage_limit' => 100, 'is_active' => true]);
    }
}
