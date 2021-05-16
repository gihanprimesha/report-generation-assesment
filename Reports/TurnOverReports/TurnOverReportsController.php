<?php

/**
 * Created by VS code.
 * User: Gihan Primesha
 * Date: 09/05/21
 * Time: 3:00 PM
 */

namespace Reports\TurnOverReports;

use Application\Exceptions\NoDataException;
use Application\Exceptions\ValidationException;
use Application\FileGenerator;
use Application\Helpers\Logger;
use Application\Helpers\Error;

class TurnOverReportsController
{
    private $reportService;

    function __construct()
    {
        $this->reportService = new TurnOverReportsService();
    }

    /**
     * Generate turn over per brand report
     * @params json object
     * @return report data array
     */
    public function turnOverPerBrandAction($request)
    {
        $data = $status = $message = null;
        $this->getLoggertInstance()::debug("Entering Method `" . __METHOD__ . "`");

        if (empty($request)) {
            throw new \Exception("Invalid request data");
        }

        try {

            $this->getLoggertInstance()::debug("Processing Method `" . __METHOD__ . "`");

            $dataObj = $this->reportService->turnOverPerBrandReport($request);

            $this->getLoggertInstance()::debug("Leaving Method `" . __METHOD__ . "`");

            $fileGenerator = FileGenerator::getInstance(["Brand Name", "Total Turnover"]);

            $status = 'success';
            $data = $fileGenerator->generateCsvFile($dataObj);
        } catch (ValidationException $e) {
            $this->getLoggertInstance()::error("Error in Method  `" . __METHOD__ . "` : " . $e->getMessage());
            $status = 'error';
            $message = [
                'type' => Error::VALIDATION_ERROR,
                'description' => $e->getMessage()
            ];
        } catch (NoDataException $e) {
            $status = 'error';
            $this->getLoggertInstance()::error("Error in Method  `" . __METHOD__ . "` : " . $e->getMessage());
            $message = [
                'type' => Error::NO_DATA_FOUND_ERROR,
                'description' => $e->getMessage()
            ];
        } catch (\Exception $e) {
            $status = 'error';
            $this->getLoggertInstance()::error("Error in Method  `" . __METHOD__ . "` : " . $e->getMessage());
            $message = [
                'type' => Error::SYSTEM_ERROR,
                'description' => $e->getMessage()
            ];
        }

        return [
            'status' => $status,
            'data' => $data,
            'message' => $message,
        ];
    }

    /**
     * Generate turn over per day report
     * @params json object
     * @return report data array
     */
    public function turnOverPerDayAction($request)
    {
        $data = $status = $message = null;
        $this->getLoggertInstance()::debug("Entering Method `" . __METHOD__ . "`");
        try {

            $this->getLoggertInstance()::debug("Processing Method `" . __METHOD__ . "`");

            $dataObj  = $this->reportService->turnOverPerDayReport($request);

            $this->getLoggertInstance()::debug("Leaving Method `" . __METHOD__ . "`");

            $fileGenerator = FileGenerator::getInstance(["Date", "Total Turnover"]);

            $status = 'success';
            $data = $fileGenerator->generateCsvFile($dataObj);
        } catch (ValidationException $e) {
            $status = 'error';
            $this->getLoggertInstance()::error("Error in Method  `" . __METHOD__ . "` : " . $e->getMessage());
            $message = [
                'type' => Error::VALIDATION_ERROR,
                'description' => $e->getMessage()
            ];
        } catch (NoDataException $e) {
            $status = 'error';
            $this->getLoggertInstance()::error("Error in Method  `" . __METHOD__ . "` : " . $e->getMessage());
            $message = [
                'type' => Error::NO_DATA_FOUND_ERROR,
                'description' => $e->getMessage()
            ];
        } catch (\Exception $e) {
            $status = 'error';
            $this->getLoggertInstance()::error("Error in Method  `" . __METHOD__ . "` : " . $e->getMessage());
            $message = [
                'type' => Error::SYSTEM_ERROR,
                'description' => $e->getMessage()
            ];
        }

        return [
            'status' => $status,
            'data' => $data,
            'message' => $message,
        ];
    }

    /**
     * Generate turn over per day per brand report
     * @params json object
     * @return report data array
     */
    public function turnOverPerDayPerBrandAction($request)
    {
        $pageStart = $data = $pageEnd = $status = $message = null;
        $this->getLoggertInstance()::debug("Entering Method `" . __METHOD__ . "`");
        try {

            $this->getLoggertInstance()::debug("Processing Method `" . __METHOD__ . "`");

            $dataObj  = $this->reportService->turnOverPerDayPerBrandReport($request);

            $this->getLoggertInstance()::debug("Leaving Method `" . __METHOD__ . "`");

            $fileGenerator = FileGenerator::getInstance(["Date", "Brand Name", "Total Turnover"]);

            $status = 'success';
            $data = $fileGenerator->generateCsvFile($dataObj);
        } catch (ValidationException $e) {
            $status = 'error';
            $this->getLoggertInstance()::error("Error in Method  `" . __METHOD__ . "` : " . $e->getMessage());
            $message = [
                'type' => Error::VALIDATION_ERROR,
                'description' => $e->getMessage()
            ];
        } catch (NoDataException $e) {
            $status = 'error';
            $this->getLoggertInstance()::error("Error in Method  `" . __METHOD__ . "` : " . $e->getMessage());
            $message = [
                'type' => Error::NO_DATA_FOUND_ERROR,
                'description' => $e->getMessage()
            ];
        } catch (\Exception $e) {
            $status = 'error';
            $this->getLoggertInstance()::error("Error in Method  `" . __METHOD__ . "` : " . $e->getMessage());
            $message = [
                'type' => Error::SYSTEM_ERROR,
                'description' => $e->getMessage()
            ];
        }

        return [
            'status' => $status,
            'data' => $data,
            'message' => $message,
        ];
    }

    private function getLoggertInstance()
    {
        return Logger::getInstance();
    }
}
