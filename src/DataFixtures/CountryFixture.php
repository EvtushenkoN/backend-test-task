<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CountryFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->countriesArray() as $countryData) {
            $country = $this->getCountry($countryData);
            $manager->persist($country);
        }
        $manager->flush();
    }

    private function countriesArray(): array {
        return [
            [
                "name" => "Germany",
                "tax" => 19,
                "tax_number_format" => "^DE[0-9]{9}$",
            ],
            [
                "name" => "Italy",
                "tax" => 22,
                "tax_number_format" => "^IT[0-9]{11}$",
            ],
            [
                "name" => "France",
                "tax" => 20,
                "tax_number_format" => "^FR[A-Z]{2}[0-9]{9}$",
            ],
            [
                "name" => "Greece",
                "tax" => 24,
                "tax_number_format" => "^GR[0-9]{9}$",
            ],
        ];
    }

    private function getCountry(array $data): Country {
        $discount = new Country();
        $discount->setName($data['name']);
        $discount->setTax($data['tax']);
        $discount->setTaxNumberFormat($data['tax_number_format']);
        return $discount;
    }
}
