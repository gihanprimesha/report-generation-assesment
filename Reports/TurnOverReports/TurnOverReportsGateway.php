<?php

/**
 * Created by VS code.
 * User: Gihan Primesha
 * Date: 09/05/21
 * Time: 4:45 PM
 */

namespace Reports\TurnOverReports;

use Exception;
use Reports\AbstractReport;
use Application\Helpers\Mapper;
use Application\Helpers\Validation;
use Application\Exceptions\ValidationException;
use Application\Exceptions\NoDataException;
use Reports\TurnOverReports\Models\TurnoverPerBrand;
use Reports\TurnOverReports\Models\TurnoverPerDay;
use Reports\TurnOverReports\Models\TurnoverPerDayPerBrand;

class TurnOverReportsGateway extends AbstractReport
{
    /** Hard corded bcaouse of the assesment */

    const VAT_PRESENTAGE = '21';
    const ROWS_PER_PAGE = 2;

    private $table_bands = 'brands';
    private $table_gmv = 'gmv';

    private $validationObj;

    private $mapper = [
        Mapper::DATABASE_MAPPER => [
            parent::TURNOVER_PER_BRAND => [
                'name' => 'brandName',
                'sum'  => 'totalTurnOver'
            ],
            parent::TURNOVER_PER_DAY => [
                'date' => 'day',
                'sum'  => 'totalTurnOver'
            ],
            parent::TURNOVER_PER_DAY_PER_BRAND => [
                'name' => 'brandName',
                'date' => 'day',
                'sum'  => 'totalTurnOver'
            ]

        ],

        Mapper::VALIDATION_MAP => [
            'startDate' => [
                Validation::VALID_TYPE_REQUIRED
            ],
            'endDate' => [
                Validation::VALID_TYPE_REQUIRED
            ],

            'reportType' => [
                Validation::VALID_TYPE_REQUIRED
            ],

            'pageNumber' => [
                Validation::VALID_TYPE_REQUIRED,
                Validation::VALID_TYPE_NUMERIC,
            ],
        ]
    ];

    public function getReportData(array $request)
    {

        $objectArray = [];

        if (empty($request)) {
            throw new Exception('Invalid data sent to ' . __METHOD__);
        }

        $validatedResults = $this->getValidationObj()->validateRequest($this->mapper, $request);

        if (!empty($validatedResults)) {
            throw new ValidationException('Validation Failed! ' . $validatedResults[0]);
        }

        $pageStart = ((int) $request['pageNumber'] - 1) * self::ROWS_PER_PAGE;

        if ($request['reportType'] === parent::TURNOVER_PER_BRAND) {

            $sql = "SELECT " . $this->table_bands . ".name, SUM(" . $this->table_gmv
                . ".turnover - (" . $this->table_gmv . ".turnover * " . self::VAT_PRESENTAGE . "/100)) 
                as sum FROM " . $this->table_bands . "
                LEFT JOIN " . $this->table_gmv . " ON brands.id = " . $this->table_gmv . ".brand_id WHERE " . $this->table_gmv . ".date 
                BETWEEN '" . $request['startDate'] . "' AND '" . $request['endDate']  . "' GROUP BY " . $this->table_gmv . ".brand_id LIMIT " . self::ROWS_PER_PAGE . " OFFSET " . $pageStart;

            $data = $this->getReportsDataFromDb($sql);

            if (empty($data)) {
                throw new NoDataException('No report data found');
            }

            foreach ($data as $reportData) {
                $structReportData = $this->getObjectStructuredReportData(
                    $this->mapper[Mapper::DATABASE_MAPPER][parent::TURNOVER_PER_BRAND],
                    $reportData
                );

                $objectArray[] = $this->hydrateTurnoverPerBrandData($structReportData);
            }
        } elseif ($request['reportType'] === parent::TURNOVER_PER_DAY) {

            $sql = "SELECT " . $this->table_gmv . ".date, SUM(" . $this->table_gmv . ".turnover - (" . $this->table_gmv . ".turnover * "
                . self::VAT_PRESENTAGE . "/100))  as sum from brands LEFT JOIN "
                . $this->table_gmv . " ON brands.id = " . $this->table_gmv . ".brand_id WHERE " . $this->table_gmv . ".date 
            BETWEEN '" . $request['startDate'] . "' AND '" . $request['endDate'] . "' GROUP BY " . $this->table_gmv . ".date LIMIT " . self::ROWS_PER_PAGE . " OFFSET " . $pageStart;

            $data = $this->getReportsDataFromDb($sql);

            if (empty($data)) {
                throw new NoDataException('No report data found');
            }

            foreach ($data as $reportData) {
                $structReportData = $this->getObjectStructuredReportData(
                    $this->mapper[Mapper::DATABASE_MAPPER][parent::TURNOVER_PER_DAY],
                    $reportData
                );

                $objectArray[] = $this->hydrateTurnoverPerDayData($structReportData);
            }
        } elseif ($request['reportType'] === parent::TURNOVER_PER_DAY_PER_BRAND) {

            $sql = "SELECT " . $this->table_gmv . ".date," . $this->table_bands . ".name,  SUM(" . $this->table_gmv . ".turnover - (" . $this->table_gmv . ".turnover * "
                . self::VAT_PRESENTAGE . "/100))  as sum from brands LEFT JOIN "
                . $this->table_gmv . " ON brands.id = " . $this->table_gmv . ".brand_id WHERE " . $this->table_gmv . ".date 
            BETWEEN '" . $request['startDate'] . "' AND '" . $request['endDate'] . "' GROUP BY " . $this->table_gmv . ".date ," . $this->table_gmv . ".brand_id LIMIT " . self::ROWS_PER_PAGE . " OFFSET " . $pageStart;

            $data = $this->getReportsDataFromDb($sql);



            if (empty($data)) {
                throw new NoDataException('No report data found');
            }

            foreach ($data as $reportData) {
                $structReportData = $this->getObjectStructuredReportData(
                    $this->mapper[Mapper::DATABASE_MAPPER][parent::TURNOVER_PER_DAY_PER_BRAND],
                    $reportData
                );

                $objectArray[] = $this->hydrateTurnoverPerDayPerBrandData($structReportData);
            }
        } else {
            throw new \Exception('Report type not found');
        }

        return $objectArray;
    }

    private function getValidationObj()
    {
        if (!isset($this->validationObj)) {
            $this->setValidationObj();
        }

        return $this->validationObj;
    }

    private function setValidationObj()
    {
        $this->validationObj = new Validation();
    }

    /**
     * Hydrate TurnoverPerBrandData
     * @return  $turnoverPerBrandObj
     */
    private function hydrateTurnoverPerBrandData(array $perBrandData, TurnoverPerBrand $turnoverPerBrandObj = null)
    {
        if ($turnoverPerBrandObj === null) {
            $turnoverPerBrandObj = new TurnoverPerBrand();
        }

        if (isset($perBrandData['brandName'])) {
            $turnoverPerBrandObj->setBrandName($perBrandData['brandName']);
        }

        if (isset($perBrandData['totalTurnOver'])) {
            $turnoverPerBrandObj->setTotalTurnOver($perBrandData['totalTurnOver']);
        }

        return $turnoverPerBrandObj;
    }

    /**
     * Hydrate TurnoverPerDayData
     * @return  $turnoverPerDayObj
     */
    private function hydrateTurnoverPerDayData(array $perDayData, TurnoverPerDay $turnoverPerDayObj = null)
    {
        if ($turnoverPerDayObj === null) {
            $turnoverPerDayObj = new TurnoverPerDay();
        }

        if (isset($perDayData['day'])) {
            $turnoverPerDayObj->setDay($perDayData['day']);
        }

        if (isset($perDayData['totalTurnOver'])) {
            $turnoverPerDayObj->setTotalTurnOver($perDayData['totalTurnOver']);
        }

        return $turnoverPerDayObj;
    }

    /**
     * Hydrate TurnoverPerDayPerBrandData
     * @return  $turnoverPerDayPerBrandObj
     */
    private function hydrateTurnoverPerDayPerBrandData(array $perDayPerBrandData, TurnoverPerDayPerBrand $turnoverPerDayPerBrandObj = null)
    {
        if ($turnoverPerDayPerBrandObj === null) {
            $turnoverPerDayPerBrandObj = new TurnoverPerDayPerBrand();
        }

        if (isset($perDayPerBrandData['day'])) {
            $turnoverPerDayPerBrandObj->setDay($perDayPerBrandData['day']);
        }

        if (isset($perDayPerBrandData['totalTurnOver'])) {
            $turnoverPerDayPerBrandObj->setTotalTurnOver($perDayPerBrandData['totalTurnOver']);
        }

        if (isset($perDayPerBrandData['brandName'])) {
            $turnoverPerDayPerBrandObj->setBrandName($perDayPerBrandData['brandName']);
        }

        return $turnoverPerDayPerBrandObj;
    }
}
