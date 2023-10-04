<?php

namespace App\Controller;

use App\Service\ExcelService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ExcelPublicApiV1Controller extends AbstractController
{
    protected ExcelService $excelService;

    public function __construct(ExcelService $excelService)
    {
        $this->excelService = $excelService;
    }

    #[Route('/api/v1/{sheetId}', methods: ['GET'])]
    public function getAllCellsFromSheet($sheetId): JsonResponse
    {
        if ($sheet = $this->getExcelService()->getSheetById($sheetId)) {
            return $this->json([$sheet]);
        }

        return $this->json(["Sheet is missing"], 404);
    }

    #[Route('/api/v1/{sheetId}/{cellId}', methods: ['GET'])]
    public function getCellValueFromSheet($sheetId, $cellId): JsonResponse
    {
        if (empty($value = $this->getExcelService()->getCellValueById($sheetId, $cellId))) {
            return $this->json(["Value is missing"], 404);
        }

        return $this->json([$value]);
    }

    #[Route('/api/v1/{sheetId}/{cellId}', methods: ['POST'])]
    public function upsert(Request $request, ExcelService $excelService,$sheetId, $cellId): JsonResponse
    {
        $variable = json_decode($request->getContent(), true)["value"];

        if (!($value = $excelService->upsertSheetCell($variable, $sheetId))) {
            $this->json(["value" => $variable, "result" => "ERROR"], 422);
        }

        return $this->json([$value], 201);
    }

    #[Route('/{any}', requirements: ['any' => '.*'], methods: ['GET', 'POST', 'PUT', 'DELETE'])]
    public function defaultEndpoint(): JsonResponse
    {
        return $this->json(["Undefined endpoint"], 404);
    }

    public function getExcelService(): ExcelService
    {
        return $this->excelService;
    }

    /**
     * @param ExcelService $excelService
     * @return self
     */
    public function setExcelService(ExcelService $excelService): self
    {
        $this->excelService = $excelService;

        return $this;
    }
}
