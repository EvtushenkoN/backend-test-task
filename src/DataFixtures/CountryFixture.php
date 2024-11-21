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
                "prefix" => "DE",
            ],
            [
                "name" => "Italy",
                "tax" => 22,
                "tax_number_format" => "^IT[0-9]{11}$",
                "prefix" => "IT",
            ],
            [
                "name" => "France",
                "tax" => 20,
                "tax_number_format" => "^FR[A-Z]{2}[0-9]{9}$",
                "prefix" => "FR",
            ],
            [
                "name" => "Greece",
                "tax" => 24,
                "tax_number_format" => "^GR[0-9]{9}$",
                "prefix" => "GR",
            ],
        ];
    }

    private function getCountry(array $data): Country {
        $country = new Country();
        $country->setName($data['name']);
        $country->setTax($data['tax']);
        $country->setPrefix($data['prefix']);
        $country->setTaxNumberFormat($data['tax_number_format']);
        return $country;
    }
}
