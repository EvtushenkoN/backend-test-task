<?php

namespace App\Dto;
use App\Enum\PaymentProcessorEnum;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as CustomAssert;

class MakePurchaseDto
{
    use ValidateDtoTrait;
    use HydrateTrait;

    #[Assert\NotBlank(message: "Product should`t be empty")]
    #[Assert\Type(type: "int", message: "Product should be integer")]
    private $product;
    #[Assert\NotBlank(message: "Taxnumber should`t be empty")]
    #[Assert\Type(type: "string", message: "Taxnumber should be string")]
    #[CustomAssert\TaxNumberConstraint]
    private $taxNumber;
    #[Assert\Type(type: "string", message: "Couponcode should be string")]
    private $couponCode;
    #[Assert\NotBlank(message: "PaymentProcessor should`t be empty")]
    #[Assert\Choice(choices: PaymentProcessorEnum::LIST, message: "Invalid PaymentProcessor value")]
    private $paymentProcessor;

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
    public function setPaymentProcessor(string $paymentProcessor): void
    {
        $this->paymentProcessor = $paymentProcessor;
    }
    public function getProduct(): int
    {
        return $this->product;
    }
    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }
    public function getCouponCode(): string|null
    {
        return $this->couponCode;
    }
    public function getPaymentProcessor(): string
    {
        return $this->paymentProcessor;
    }
}