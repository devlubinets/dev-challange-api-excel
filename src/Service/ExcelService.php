<?php

namespace App\Service;

use App\Entity\Sheet1;
use App\Repository\Sheet1Repository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class ExcelService
{
    /** @var EntityManagerInterface $entityManager */
    protected EntityManagerInterface $entityManager;

    /** @var Sheet1Repository $sheetRepository */
    protected Sheet1Repository $sheetRepository;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->sheetRepository = $entityManager->getRepository(Sheet1::class);
    }

    /**
     * @param $sheetId
     * @return array|bool
     */
    public function getSheetById($sheetId): array|bool
    {
        if ($sheetId == "sheet1") {
            $sheet = $this->sheetRepository->findAll();
        } else {
            return false;
        }

        return $this->preparationSheetValues($sheet);
    }

    /**
     * @param string $sheetId
     * @param string $cellId
     * @return array|bool
     */
    public function getCellValueById(string $sheetId, string $cellId): array|bool
    {
        if ($sheetId != "sheet1") {
            return false;
        }

        if (empty($sheetCell = $this->sheetRepository->findBy(["var_name" => $cellId]))) {
            return false;
        }

        return $this->preparationSheetValues($sheetCell)[$cellId];
    }

    /**
     * @param $entities
     * @return array
     */
    public function preparationSheetValues($entities): array
    {
        $resultArray = [];
        foreach ($entities as $entity) {
            $resultArray[$entity->getVarName()] = [
                "value" => $entity->getCell(),
                "result" => $entity->getCell()
            ];
        }

        return $resultArray;
    }

    /**
     * @param string $variable
     * @param $sheet
     * @return array|bool
     */
    protected function calc(string $variable, $sheet): array|bool
    {
        $operation = "";
        $cls = "";
        preg_match_all("#(\w+)#", $variable, $cls);
        preg_match_all('#[+\-*/]#', $variable, $operation);

        try {
            $result = match ($operation[0][0]) {
                "+" => $sheet[$cls[0][0]]["value"] + $sheet[$cls[0][1]]["value"],
                "-" => $sheet[$cls[0][0]]["value"] - $sheet[$cls[0][1]]["value"],
                "/" => $sheet[$cls[0][0]]["value"] / $sheet[$cls[0][1]]["value"],
                "*" => $sheet[$cls[0][0]]["value"] * $sheet[$cls[0][1]]["value"],
            };

            return [
                "value" => $variable,
                "result" => $result
            ];
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param mixed $variable
     * @param $sheetId
     * @return array|bool
     */
    public function upsertSheetCell(mixed $variable, $sheetId): array|bool
    {
        $sheet = $this->getSheetById($sheetId);
        $result = $this->calc($variable, $sheet);

        $entity = new Sheet1();
        $entity->setVarName($variable);
        $entity->setCell($result["result"]);

        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        } catch (Exception $e) {
            $existingEntity = $this->sheetRepository->findOneBy(["var_name" => $variable]);
            $existingEntity->setCell($result["result"]);
            $this->entityManager->flush();
        }

        return $result;
    }
}