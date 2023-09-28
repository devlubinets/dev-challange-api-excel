<?php

namespace App\Controller;

use App\DTO\Sheet1;
use App\DTO\Sheet2;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ExcelPublicApiController extends API
{
    #[Route('/api/' . self::API_VERSION . '/{sheetId}/{cellId}', name: 'app_excel_public_api123', requirements: [
        'sheetId' => '\d+',
    ], methods: ['POST'])]
    public function upsert(Request $request, int $sheetId, $cellId): JsonResponse
    {
        $sheet = match ($sheetId) {
            1 => Sheet1::data,
            2 => Sheet2::data,
            default => $this->json([], 422),
        };

        $variable = json_decode($request->getContent(), true)["value"];
        $sheet[$cellId] = $this->calc($variable, $sheet);

        return $this->json([
            "value" => $sheet[$cellId],
            "result" =>  $sheet[$cellId]
        ], 201);
    }

    #[Route('/api/' . self::API_VERSION . '/{sheetId}', name: 'app_excel_public_api2', requirements: [
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

    #[Route('/api/' . self::API_VERSION . '/{sheetId}/{cellId}', name: 'app_excel_public_api', requirements: [
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

    /**
     * @param string $variable
     * @param $sheet
     * @return int
     */
    protected function calc(string $variable, $sheet): int
    {
        $operation = "";
        $cls = "";
        preg_match_all("#(\w+)#", $variable, $cls);
        preg_match_all('#[+\-*/]#', $variable, $operation);

        return match ($operation[0][0]) {
            "+" => $sheet[$cls[0][0]]["value"] + $sheet[$cls[0][1]]["value"],
            "-" => $sheet[$cls[0][0]]["value"] - $sheet[$cls[0][1]]["value"],
            "/" => $sheet[$cls[0][0]]["value"] / $sheet[$cls[0][1]]["value"],
            "*" => $sheet[$cls[0][0]]["value"] * $sheet[$cls[0][1]]["value"],
        };
    }
}
