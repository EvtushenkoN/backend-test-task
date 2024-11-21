<?php

namespace App\Service;

use App\Dto\CalculatePriceDto;
use App\Dto\MakePurchaseDto;
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
        private readonly PaymentsService $paymentsService,
    ) {}

    public function calculatePrice(CalculatePriceDto $calculatePriceDto) {
        $country = $this->countryRepository->findByTaxNumberOrFail($calculatePriceDto->getTaxNumber());
        $product = $this->productRepository->findByIdOrFail($calculatePriceDto->getProduct());
        $discount = null;
        if ($calculatePriceDto->getCouponCode()) {
            $discount = $this->discountRepository->findByCodeOrFail($calculatePriceDto->getCouponCode());
        }

        return $this->getPrice($product, $country, $discount);
    }

    public function makePurchase(MakePurchaseDto $makePurchaseDto) {
        $country = $this->countryRepository->findByTaxNumberOrFail($makePurchaseDto->getTaxNumber());
        $product = $this->productRepository->findByIdOrFail($makePurchaseDto->getProduct());
        $discount = null;
        if ($makePurchaseDto->getCouponCode()) {
            $discount = $this->discountRepository->findByCodeOrFail($makePurchaseDto->getCouponCode());
        }

        $price = $this->getPrice($product, $country, $discount);
        $paymentProcessor = $makePurchaseDto->getPaymentProcessor();
        $this->paymentsService->$paymentProcessor($price);

        return $price;
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