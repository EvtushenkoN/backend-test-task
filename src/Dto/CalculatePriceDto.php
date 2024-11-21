<?php

namespace App\Dto;
use Symfony\Component\Validator\Constraints as Assert;

class CalculatePriceDto
{
    use ValidateDtoTrait;
    use HydrateTrait;

    #[Assert\NotBlank(message: "Product should`t be empty")]
    #[Assert\Type(type: "int", message: "Product should be integer")]
    private $product;
    #[Assert\NotBlank(message: "Taxnumber should`t be empty")]
    #[Assert\Type(type: "string", message: "Taxnumber should be string")]
    private $taxNumber;
    #[Assert\NotBlank(message: "Couponcode should`t be empty")]
    #[Assert\Type(type: "string", message: "Couponcode should be string")]
    private $couponCode;

    public function setProduct(int $product): void
    {
        $this->product = $product;
    }

    public function setTaxNumber(string $taxNumber): void
    {
        $this->taxNumber = $taxNumber;
    }
    public function setCouponCode(string $couponCode): void
    {
        $this->couponCode = $couponCode;
    }
    public function getProduct(): int
    {
        return $this->product;
    }
    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }
    public function getCouponCode(): string
    {
        return $this->couponCode;
    }

}