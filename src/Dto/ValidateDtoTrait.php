<?php

namespace App\Dto;

use App\Exception\DtoValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

trait ValidateDtoTrait
{
    /**
     * @throws DtoValidationException
     */
    public function validate(ValidatorInterface $validator): void
    {
        $errors = $validator->validate($this);
        if (count($errors) >= 1) {
            throw new DtoValidationException($errors[0]->getMessage());
        }
    }
}