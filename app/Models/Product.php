<?php

namespace App\Models;

use App\Enum\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * @return string
     */
    public function presentCurrency(): string
    {
        return optional(Currency::fromId($this->currency))->getIcon();
    }

    /**
     * @return string
     */
    public function presentPrice(): string
    {
        return "<span> $this->price </span>" . optional(Currency::fromId($this->currency))->getIcon();
    }

    /**
     * @return bool
     */
    public function existsInCart(): bool
    {
        $productsInCart = collect(session('cart.products'));
        return $productsInCart->contains(function ($product) {
            return $product['id'] === $this->id;
        });
    }
}
