<?php

/**
 * Created by VS code.
 * User: Gihan Primesha
 * Date: 09/05/21
 * Time: 3:00 PM
 */

namespace Reports;

class ReportController
{
    private $reportService;

    function __construct()
    {
        $this->reportService = new ReportsService();
    }

    public function reportOneAction()
    {
        try {
            $this->reportService->generateReportOne();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function reportTwoAction()
    {
        try {
            $this->reportService->generateReportTwo();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
