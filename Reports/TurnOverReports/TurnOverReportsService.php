<?php

/**
 * Created by VS code.
 * User: Gihan Primesha
 * Date: 09/05/21
 * Time: 3:10 PM
 */

namespace Reports\TurnOverReports;

use Reports\AbstractReport;

class TurnOverReportsService
{
    private $reportGateway;

    function __construct()
    {
        $this->reportGateway = new TurnOverReportsGateway;
    }

    public function sevenDayTurnOverPerBrandReport(array $request)
    {
        $request['reportType'] = AbstractReport::TURNOVER_PER_BRAND;

        $data = $this->reportGateway->getReportData($request);

        if (empty($data)) {
            throw new \Exception('Report data not found');
        }

        return $data;
    }

    public function sevenDayTurnOverPerDayReport(array $request)
    {
        $request['reportType'] = AbstractReport::TURNOVER_PER_DAY;

        $data = $this->reportGateway->getReportData($request);

        if (empty($data)) {
            throw new \Exception('Report data not found');
        }

        return $data;
    }
}
