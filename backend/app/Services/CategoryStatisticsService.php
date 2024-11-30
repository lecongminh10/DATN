<?php

namespace App\Services;

use App\Models\Category;

class CategoryStatisticsService
{
    public function getStatistics(Category $category)
    {
        return [
            'name' => $category->name,
            'total_products' => $category->products()->count(),
            'total_revenue' => $this->calculateTotalRevenue($category),
            'best_selling_product' => $this->getBestSellingProduct($category),
            'active_status' => $category->is_active ? 'Active' : 'Inactive',
        ];
    }

    public function getAllStatistics()
    {
        return Category::all()->map(function ($category) {
            return $this->getStatistics($category);
        })->toArray();
    }

    private function calculateTotalRevenue(Category $category)
    {
        return $category->products->sum(function ($product) {
            return $product->price * $product->sold_quantity;
        });
    }

    private function getBestSellingProduct(Category $category)
    {
        $bestSellingProduct = $category->products()->orderBy('sold_quantity', 'desc')->first();
        return $bestSellingProduct ? $bestSellingProduct->name : null;
    }
}
