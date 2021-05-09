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
        $this->reportGateway->generateReportOne();
    }

    public function generateReportTwo()
    {
        $this->reportGateway->generateReportTwo();
    }
}
