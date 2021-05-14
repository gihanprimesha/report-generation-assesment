<?php

/**
 * Created by VS code.
 * User: Gihan Primesha
 * Date: 09/05/21
 * Time: 3:00 PM
 */

namespace Reports;

use Application\FileGenerator;

class ReportsController
{
    private $reportService;

    function __construct()
    {
        $this->reportService = new ReportsService();
    }

    /**
     * 
     */
    public function reportOneAction()
    {
        try {
            $data = $this->reportService->generateReportOne();

            $fileGenerator = new FileGenerator(["Brand Name", "Total Turnover"]);

            $fileGenerator->generateCsvFile($data);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * 
     */
    public function reportTwoAction()
    {
        try {
            $data = $this->reportService->generateReportTwo();

            $fileGenerator = new FileGenerator(["Date", "Total Turnover"]);

            $fileGenerator->generateCsvFile($data);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
