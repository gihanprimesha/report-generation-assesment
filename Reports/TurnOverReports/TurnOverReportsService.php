<?php

/**
 * Created by VS code.
 * User: Gihan Primesha
 * Date: 09/05/21
 * Time: 3:10 PM
 */

namespace Reports\TurnOverReports;

use Reports\AbstractReport;
use Application\Helpers\Logger;

class TurnOverReportsService
{
    private $reportGateway;

    function __construct()
    {
        $this->reportGateway = new TurnOverReportsGateway;
    }

    /**
     * Get Seven day turn over per brand data
     * @return  report $data 
     */
    public function turnOverPerBrandReport(array $request)
    {
        $this->getLoggertInstance()::debug("Entering Method `" . __METHOD__ . "`");
        $request['reportType'] = AbstractReport::TURNOVER_PER_BRAND;

        $data = $this->reportGateway->getReportData($request);
        $this->getLoggertInstance()::debug("Leaving Method `" . __METHOD__ . "`");
        return $data;
    }

    /**
     * Get Seven day turn over per data data
     * @return  report $data 
     */
    public function turnOverPerDayReport(array $request)
    {
        $this->getLoggertInstance()::debug("Entering Method `" . __METHOD__ . "`");
        $request['reportType'] = AbstractReport::TURNOVER_PER_DAY;

        $data = $this->reportGateway->getReportData($request);
        $this->getLoggertInstance()::debug("Leaving Method `" . __METHOD__ . "`");
        return $data;
    }

    /**
     * Get Seven day turn over per data data
     * @return  report $data 
     */
    public function turnOverPerDayPerBrandReport(array $request)
    {
        $this->getLoggertInstance()::debug("Entering Method `" . __METHOD__ . "`");
        $request['reportType'] = AbstractReport::TURNOVER_PER_DAY_PER_BRAND;

        $data = $this->reportGateway->getReportData($request);
        $this->getLoggertInstance()::debug("Leaving Method `" . __METHOD__ . "`");
        return $data;
    }

    /**
     * Get logger instance
     * @return  Logger instance 
     */
    private function getLoggertInstance()
    {
        return Logger::getInstance();
    }
}
