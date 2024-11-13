<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Tag;
use App\Models\User;
use App\Models\Address;
use App\Models\Product;
use App\Models\Category;
use  App\Models\Attribute;
use Illuminate\Support\Str;
use App\Models\AttributeValue;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionsSeeder::class,
            PermissionsValueSeeder::class,
            UserSeeder::class
            // PaymentGatewaysSeeder::class
        ]);


       // $faker = \Faker\Factory::create();



        // for ($i = 0; $i < 100; $i++) {
        //     User::create([
        //         'username' => $faker->unique()->userName,
        //         'email' => $faker->unique()->safeEmail,
        //         'password' => Hash::make('password'), // use a default password
        //         'language' => $faker->randomElement(['en', 'fr', 'de', 'es', 'vi']),
        //         'currency' => $faker->randomElement(['USD', 'EUR', 'VND']),
        //         'loyalty_points' => $faker->numberBetween(0, 1000),
        //         'is_verified' => $faker->boolean,
        //         'profile_picture' => $faker->imageUrl(200, 200, 'people'),
        //         'date_of_birth' => $faker->date('Y-m-d', '2003-12-31'),
        //         'gender' => $faker->randomElement(['male', 'female', 'other']),
        //         'phone_number' => $faker->unique()->numerify('0#########'),
        //         'status' => $faker->randomElement(['active', 'inactive', 'suspended']),
        //         'email_verified_at' => $faker->optional()->dateTime,
        //         'last_login_at' => $faker->optional()->dateTime,
        //         'created_by' => null, // Adjust if you have specific user relations
        //         'updated_by' => null,
        //         'deleted_by' => null,
        //     ]);
        // }

        // for ($i = 0; $i < 50; $i++) {
        //     Address::create([
        //         'specific_address' => $faker->streetAddress,
        //         'ward' => $faker->citySuffix,
        //         'district' => $faker->city,
        //         'city' => $faker->state,
        //         'active' => $faker->boolean,
        //     ]);
        // }
        // for ($i = 0; $i < 20; $i++) {
        //     Category::create([
        //         'name' => $faker->words(2, true),
        //         'description' => $faker->sentence,
        //         'image' => $faker->imageUrl(640, 480, 'category'),
        //         'parent_id' => $i > 5 ? rand(1, 5) : null, // First 5 categories are parent categories
        //         'is_active' => $faker->boolean(80), // 80% chance of being active
        //     ]);
        // }

        // $attributes = [
        //     'Size', 'Color', 'Material', 'Brand', 'Weight',
        //     'Length', 'Width', 'Height', 'Capacity', 'Style'
        // ];

        // foreach ($attributes as $attribute) {
        //     Attribute::create([
        //         'attribute_name' => $attribute,
        //         'description' => 'Description for ' . $attribute,
        //     ]);
        // }

        // $attributes = Attribute::all();
        // // Ensure there are attributes to assign values to
        // if ($attributes->isEmpty()) {
        //     $this->command->info('No attributes found. Please seed the attributes table first.');
        //     return;
        // }

        // foreach (range(1, 50) as $index) {
        //     $attribute = $attributes->random(); // Randomly select an attribute

        //     AttributeValue::create([
        //         'id_attributes' => $attribute->id,
        //         'attribute_value' => 'Value ' . $index,
        //     ]);
        // }


        // $categories = Category::all();

        // if ($categories->isEmpty()) {
        //     $this->command->info('No categories found. Please seed the categories table first.');
        //     return;
        // }

        // foreach (range(1, 50) as $index) {
        //     $category = $categories->random();

        //     Product::create([
        //         'category_id' => $category->id,
        //         'code' => 'PRD' . Str::random(5) . $index,
        //         'name' => 'Product ' . $index,
        //         'short_description' => 'Short description for product ' . $index,
        //         'content' => 'Detailed description for product ' . $index,
        //         'price_regular' => rand(100000, 1000000), // Example price range
        //         'price_sale' => rand(50000, 800000), // Example sale price range
        //         'stock' => rand(0, 100),
        //         'rating' => rand(1, 5),
        //         'warranty_period' => rand(6, 24), // Between 6 and 24 months
        //         'view' => rand(0, 500),
        //         'buycount' => rand(0, 200),
        //         'wishlistscount' => rand(0, 300),
        //         'is_active' => (bool)rand(0, 1),
        //         'is_hot_deal' => (bool)rand(0, 1),
        //         'is_show_home' => (bool)rand(0, 1),
        //         'is_new' => (bool)rand(0, 1),
        //         'is_good_deal' => (bool)rand(0, 1),
        //         'slug' => Str::slug('Product ' . $index),
        //         'meta_title' => 'SEO title for Product ' . $index,
        //         'meta_description' => 'SEO description for Product ' . $index,
        //     ]);
        // }

        // $products = Product::all();

        // if ($products->isEmpty()) {
        //     $this->command->info('No products found. Please seed the products table first.');
        //     return;
        // }

        // foreach (range(1, 100) as $index) {
        //     $product = $products->random();

        //     ProductVariant::create([
        //         'product_id' => $product->id,
        //         'price_modifier' => rand(10000, 500000), // Modifier price range example
        //         'stock' => rand(1, 50),
        //         'sku' => 'SKU' . Str::random(6) . $index,
        //         'status' => ['available', 'out_of_stock', 'discontinued'][array_rand(['available', 'out_of_stock', 'discontinued'])],
        //         'variant_image' => 'https://via.placeholder.com/150?text=Variant+' . $index,
        //     ]);
        // }

        // $productVariants = ProductVariant::all();
        // $attributeValues = AttributeValue::all();

        // if ($productVariants->isEmpty() || $attributeValues->isEmpty()) {
        //     $this->command->info('No product variants or attribute values found. Please seed these tables first.');
        //     return;
        // }

        // foreach ($productVariants as $variant) {
        //     // Attach random attribute values to each product variant
        //     $randomAttributeValues = $attributeValues->random(rand(1, 3)); // Associate 1 to 3 random attributes for each variant

        //     foreach ($randomAttributeValues as $attributeValue) {
        //         $variant->attributeValues()->attach($attributeValue->id);
        //     }
        // }

        // $tags = [
        //     'Technology', 'Fashion', 'Food', 'Travel', 'Health',
        //     'Education', 'Finance', 'Sports', 'Entertainment', 'Lifestyle'
        // ];

        // foreach ($tags as $tagName) {
        //     Tag::create([
        //         'name' => $tagName,
        //     ]);
        // }
    
    }

    
}
