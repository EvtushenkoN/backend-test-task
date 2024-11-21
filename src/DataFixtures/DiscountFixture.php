<?php

namespace App\DataFixtures;

use App\Entity\Discount;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DiscountFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->discountsArray() as $discountData) {
            $discount = $this->getDiscount($discountData);
            $manager->persist($discount);
        }
        $manager->flush();
    }

    private function discountsArray(): array {
        return [
            [
                "code" => "P10",
                "type" => Discount::TYPE_PERCENT,
                "discount" => 10,
            ],
            [
                "code" => "P100",
                "type" => Discount::TYPE_PERCENT,
                "discount" => 100,
            ],
            [
                "code" => "F10",
                "type" => Discount::TYPE_FLAT,
                "discount" => 10,
            ]
        ];
    }

    private function getDiscount(array $data): Discount {
        $discount = new Discount();
        $discount->setCode($data['code']);
        $discount->setType($data['type']);
        $discount->setDiscount($data['discount']);
        return $discount;
    }
}
