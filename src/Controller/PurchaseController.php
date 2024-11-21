<?php

namespace App\Controller;

use App\Dto\CalculatePriceDto;
use App\Service\PurchaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PurchaseController extends AbstractController
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly PurchaseService $purchaseService,
    ) {
    }
    #[Route('/calculate-price', name: 'calculate_price', methods: ['POST'])]
    public function calculatePrice(Request $request): JsonResponse
    {
        try {
            $calculatePriceDto = CalculatePriceDto::hydrate(json_decode($request->getContent(), true));
            $calculatePriceDto->validate($this->validator);

            $price = $this->purchaseService->calculatePrice($calculatePriceDto);
            return $this->json([
                'success' => true,
                'price' => $price,
            ]);
        } catch (\Throwable $exception) {
            return $this->json(
                data: [
                    "success" => false,
                    "error" => $exception->getMessage(),
                ],
                status: Response::HTTP_BAD_REQUEST
            );
        }
    }
}
