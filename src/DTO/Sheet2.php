<?php

namespace App\DTO;

class Sheet2 {

    public const data = [
        "var1" => ["value"=> 10, "result" => 10],
        "var2" => ["value"=> 100, "result" => 100],
        "var3" => ["value"=> "=var1+var2", "result" => 110]
    ];
}