<?php

namespace App\Service;

use App\Dto\CalculatePriceDto;
use App\Entity\Country;
use App\Entity\Discount;
use App\Entity\Product;
use App\Repository\CountryRepository;
use App\Repository\DiscountRepository;
use App\Repository\ProductRepository;

class PurchaseService
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly CountryRepository $countryRepository,
        private readonly DiscountRepository $discountRepository,
    ) {}

    public function calculatePrice(CalculatePriceDto $calculatePriceDto) {
        $product = $this->productRepository->findOneBy(["id" => $calculatePriceDto->getProduct()]);
        if (!$product) {
            throw new \Exception("Incorrect product id");
        }
        $prefix = substr($calculatePriceDto->getTaxNumber(), 0, 2);
        $country = $this->countryRepository->findOneBy(["prefix" => $prefix]);
        if (!$country) {
            throw new \Exception("Tax number for non-existent country");
        }
        $discount = null;
        if ($calculatePriceDto->getCouponCode()) {
            $discount = $this->discountRepository->findOneBy(["code" => $calculatePriceDto->getCouponCode()]);
            if (!$discount) {
                throw new \Exception("Discount coupon not found");
            }
        }

        return $this->getPrice($product, $country, $discount);
    }

    private function getPrice(Product $product, Country $country, ?Discount $discount) {
        $price = $product->getPrice() * (1 + $country->getTax() / 100);
        if ($discount) {
            if ($discount->getType() == Discount::TYPE_PERCENT) {
                $price = max(0, $price * (1 - $discount->getDiscount() / 100));
            } else {
                $price = max(0, $price - $discount->getDiscount());
            }
        }
        return round($price, 2);
    }
}