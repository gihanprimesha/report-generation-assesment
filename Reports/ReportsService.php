<?php

/**
 * Created by VS code.
 * User: Gihan Primesha
 * Date: 09/05/21
 * Time: 3:10 PM
 */

namespace Reports;

class ReportsService
{
    private $reportGateway;

    function __construct()
    {
        $this->reportGateway = new ReportsGateway;
    }

    public function generateReportOne()
    {
        $data = $this->reportGateway->generateReportOne();

        if (empty($data)) {
            throw new \Exception('Report data not found');
        }

        return $data;
    }

    public function generateReportTwo()
    {
        $data = $this->reportGateway->generateReportTwo();

        if (empty($data)) {
            throw new \Exception('Report data not found');
        }

        return $data;
    }
}
