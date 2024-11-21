<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->productsArray() as $productData) {
            $product = $this->getProduct($productData);
            $manager->persist($product);
        }
        $manager->flush();
    }

    private function productsArray(): array {
        return [
            [
                "name" => "Iphone",
                "price" => 100,
            ],
            [
                "name" => "Ipods",
                "price" => 20,
            ],
            [
                "name" => "Package",
                "price" => 10,
            ]
        ];
    }

    private function getProduct(array $data): Product {
        $product = new Product();
        $product->setName($data['name']);
        $product->setPrice($data['price']);
        return $product;
    }
}
