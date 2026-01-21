<?php

namespace App\Http\Services\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function store(array $data): Product
    {
        $data['slug'] = !empty($data['slug'])
            ? Str::slug($data['slug'])
            : Str::slug($data['name']);

        if (isset($data['thumbnail'])) {
            $data['thumbnail'] = $data['thumbnail']->store('products', 'public');
        }

        if (isset($data['images'])) {
            $imgs = [];
            foreach ($data['images'] as $img) {
                $imgs[] = $img->store('products/gallery', 'public');
            }
            $data['images'] = $imgs;
        }

        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $data['slug'] = !empty($data['slug'])
            ? Str::slug($data['slug'])
            : Str::slug($data['name']);

        if (isset($data['thumbnail'])) {
            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            $data['thumbnail'] = $data['thumbnail']->store('products', 'public');
        }

        if (isset($data['images'])) {
            if ($product->images) {
                foreach ($product->images as $img) {
                    Storage::disk('public')->delete($img);
                }
            }

            $imgs = [];
            foreach ($data['images'] as $img) {
                $imgs[] = $img->store('products/gallery', 'public');
            }
            $data['images'] = $imgs;
        }

        $product->update($data);
        return $product;
    }

    public function delete(Product $product): void
    {
        if ($product->thumbnail) {
            Storage::disk('public')->delete($product->thumbnail);
        }

        if ($product->images) {
            foreach ($product->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        $product->delete();
    }
}
