<?php

namespace App\Controller;

use App\DTO\Sheet1;
use App\DTO\Sheet2;
use App\Service\ExcelService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ExcelPublicApiV1Controller extends AbstractController
{
    #[Route('/api/v1/{sheetId}/{cellId}', name: 'app_excel_public_api123', requirements: [
        'sheetId' => '\d+',
    ], methods: ['POST'])]
    public function upsert(Request $request, ExcelService $excelService, int $sheetId, $cellId): JsonResponse
    {
        $sheet = match ($sheetId) {
            1 => Sheet1::data,
            2 => Sheet2::data,
            default => $this->json([], 422),
        };

        $variable = json_decode($request->getContent(), true)["value"];
        $sheet[$cellId] = $excelService->calc($variable, $sheet);

        return $this->json([
            "value" => $sheet[$cellId],
            "result" =>  $sheet[$cellId]
        ], 201);
    }

    #[Route('/api/v1/{sheetId}', name: 'app_excel_public_api2', requirements: [
        'sheetId' => '\d+',
    ], methods: ['GET'])]
    public function index(int $sheetId): JsonResponse
    {
        return match ($sheetId) {
            1 => $this->json(Sheet1::data),
            2 => $this->json(Sheet2::data),
            default => $this->json([], 404),
        };
    }

    #[Route('/api/v1/{sheetId}/{cellId}', name: 'app_excel_public_api', requirements: [
        'sheetId' => '\d+',
    ], methods: ['GET'])]
    public function index2(int $sheetId, $cellId): JsonResponse
    {
        $sheet = match ($sheetId) {
            1 => Sheet1::data,
            2 => Sheet2::data,
            default => $this->json([], 404),
        };

        if (empty($value = $sheet[$cellId])) {
            return $this->json([], 404);
        }

        return $this->json([$value]);
    }
}
