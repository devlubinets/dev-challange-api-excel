<?php

namespace App\Service;

class ExcelService
{
    /**
     * @param string $variable
     * @param $sheet
     * @return int
     */
    public function calc(string $variable, $sheet): int
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