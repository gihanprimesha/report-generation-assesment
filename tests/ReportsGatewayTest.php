<?php

declare(strict_types=1);

use \PHPUnit\Framework\TestCase;
use Reports\TurnOverReports\Models\TurnoverPerBrand;
use Reports\TurnOverReports\Models\TurnoverPerDay;
use Reports\TurnOverReports\Models\TurnoverPerDayPerBrand;

class TurnOverReportsGatewayTest extends TestCase
{

    // public function testHasAttribute()
    // {
    //     $this->assertClassHasAttribute('table_bands', Reports\ReportsGateway::class);
    //     $this->assertClassHasAttribute('table_gmv', Reports\ReportsGateway::class);
    // }

    public function testTurnOverPerBrand()
    {
        $reportsGateway = new Reports\TurnOverReports\TurnOverReportsGateway();
        $request['startDate'] = '2018-05-01';
        $request['endDate'] = '2018-06-07';
        $request['pageNumber'] = '1';
        $request['rowsPerPage'] = '20';
        $request['reportType'] = 'TURNOVER_PER_BRAND';
        $data = $reportsGateway->getReportData($request);

        $this->assertIsArray($data);
        if (count($data) > 0) {
            $this->assertInstanceOf(TurnoverPerBrand::class, $data[0]);
        }
    }

    public function testTurnOverPerDay()
    {
        $reportsGateway = new Reports\TurnOverReports\TurnOverReportsGateway();
        $request['startDate'] = '2018-05-01';
        $request['endDate'] = '2018-06-07';
        $request['pageNumber'] = '1';
        $request['rowsPerPage'] = '20';
        $request['reportType'] = 'TURNOVER_PER_DAY';
        $data = $reportsGateway->getReportData($request);

        $this->assertIsArray($data);
        if (count($data) > 0) {
            $this->assertInstanceOf(TurnoverPerDay::class, $data[0]);
        }
    }

    public function testTurnOverPerDayPerBrand()
    {
        $reportsGateway = new Reports\TurnOverReports\TurnOverReportsGateway();
        $request['startDate'] = '2018-05-01';
        $request['endDate'] = '2018-06-07';
        $request['pageNumber'] = '1';
        $request['rowsPerPage'] = '20';
        $request['reportType'] = 'TURNOVER_PER_DAY_PER_BRAND';
        $data = $reportsGateway->getReportData($request);

        $this->assertIsArray($data);
        if (count($data) > 0) {
            $this->assertInstanceOf(TurnoverPerDayPerBrand::class, $data[0]);
        }
    }
}
