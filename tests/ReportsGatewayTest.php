<?php

declare(strict_types=1);

use \PHPUnit\Framework\TestCase;

class ReportsGatewayTest extends TestCase
{

    public function testHasAttribute()
    {
        $this->assertClassHasAttribute('table_bands', Reports\ReportsGateway::class);
        $this->assertClassHasAttribute('table_gmv', Reports\ReportsGateway::class);
    }

    public function testGenerateReportOne()
    {
        $reportsGateway = new Reports\ReportsGateway();
        $data = $reportsGateway->generateReportOne();

        $this->assertIsArray($data);
        $this->assertArrayHasKey('name', $data[0]);
        $this->assertArrayHasKey('sum', $data[0]);
    }

    public function testGenerateReportTwo()
    {
        $reportsGateway = new Reports\ReportsGateway();
        $data = $reportsGateway->generateReportTwo();

        $this->assertIsArray($data);
        $this->assertArrayHasKey('date', $data[0]);
        $this->assertArrayHasKey('sum', $data[0]);
    }
}
