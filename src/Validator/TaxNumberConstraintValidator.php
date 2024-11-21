<?php

namespace App\Validator;

use App\Repository\CountryRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class TaxNumberConstraintValidator extends ConstraintValidator
{
    public function __construct(
        private readonly CountryRepository $countryRepository,
    ) {}
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof TaxNumberConstraint) {
            throw new UnexpectedTypeException($constraint, TaxNumberConstraint::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $countries = $this->countryRepository->findAll();

        foreach ($countries as $country) {
            if (preg_match('/'.$country->getTaxNumberFormat().'/', $value, $matches)) {
                return;
            }
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ string }}', $value)
            ->addViolation();
    }
}
