<?php

namespace App\Tests\Controller;

use App\Tests\Controller\Core\ControllerAbstractTest;

class ExcelPublicApiControllerTest extends ControllerAbstractTest
{
    /**
     * @return void
     */
    public function testGetSheet(): void
    {
        $this->client->request("GET", "/api/v1/1");
        $responseContent = $this->client->getResponse()->getContent();

        $this->assertResponseStatusCodeSame(200);
    }

    /**
     * @return void
     */
    public function testGetSheetCellValue(): void
    {
        $this->client->request("GET", "/api/v1/1/var1");
        $responseContent = $this->client->getResponse()->getContent();

        $this->assertResponseStatusCodeSame(200);
    }

    /**
     * @return void
     */
    public function testGetSheetById(): void
    {
        $data = ["value" => "=var1+var2"];
        $this->client->request("POST", "/api/v1/1/var3",
            [],
            [],
            ["CONTENT_TYPE" => "application/json"],
            json_encode($data)
        );
        $responseContent = $this->client->getResponse()->getContent();

        $this->assertResponseStatusCodeSame(201);
    }
}
