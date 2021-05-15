<?php

/**
 * Created by VS code.
 * User: Gihan Primesha
 * Date: 09/05/21
 * Time: 3:00 PM
 */

namespace Reports\TurnOverReports;

use Application\FileGenerator;

class TurnOverReportsController
{
    private $reportService;

    function __construct()
    {
        $this->reportService = new TurnOverReportsService();
    }

    /**
     * 
     */
    public function sevenDayTurnOverPerBrandAction()
    {
        $pageStart = $pageEnd = null;

        try {

            $request['startDate'] = '2018-05-01';
            $request['endDate'] = '2018-05-07';
            $request['pageStart'] = '1';
            $request['pageEnd'] = '10';

            $dataObj = $this->reportService->sevenDayTurnOverPerBrandReport($request);

            $fileGenerator = new FileGenerator(["Brand Name", "Total Turnover"]);

            $fileGenerator->generateCsvFile($dataObj);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * 
     */
    public function sevenDayTurnOverPerDayAction()
    {
        $pageStart = $pageEnd = null;
        try {

            $request['startDate'] = '2018-05-01';
            $request['endDate'] = '2018-05-07';
            $request['pageStart'] = '1';
            $request['pageEnd'] = '10';

            $dataObj  = $this->reportService->sevenDayTurnOverPerDayReport($request);

            $fileGenerator = new FileGenerator(["Date", "Total Turnover"]);

            $fileGenerator->generateCsvFile($dataObj);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
