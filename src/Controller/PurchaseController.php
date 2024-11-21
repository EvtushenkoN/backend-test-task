<?php

namespace App\Controller;

use App\Dto\CalculatePriceDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PurchaseController extends AbstractController
{
    public function __construct(private readonly ValidatorInterface $validator) {
    }
    #[Route('/calculate-price', name: 'calculate_price', methods: ['POST'])]
    public function calculatePrice(Request $request): JsonResponse
    {
        try {
            $calculatePriceDto = CalculatePriceDto::hydrate(json_decode($request->getContent(), true));
            print_r($calculatePriceDto);
            $calculatePriceDto->validate($this->validator);

            return $this->json([
                'message' => 'Welcome to your new controller!',
                'path' => 'src/Controller/PurchaseController.php',
            ]);
        } catch (\Throwable $exception) {
            return $this->json(
                [
                    "error" => $exception->getMessage(),
                ]
            );
        }
    }
}
