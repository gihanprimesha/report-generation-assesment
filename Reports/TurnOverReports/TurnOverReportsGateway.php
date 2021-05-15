<?php

/**
 * Created by VS code.
 * User: Gihan Primesha
 * Date: 09/05/21
 * Time: 4:45 PM
 */

namespace Reports\TurnOverReports;

use Reports\AbstractReport;
use Application\Helpers\Mapper;
use Application\Helpers\Validation;
use Exception;

class TurnOverReportsGateway extends AbstractReport
{
    /** Hard corded bcaouse of the assesment */
    const START_DATE = '2018-05-01';
    const END_DATE = '2018-05-07';
    const VAT_PRESENTAGE = '21';

    private $table_bands = 'brands';
    private $table_gmv = 'gmv';

    private $validationObj;

    private $mapper = [
        Mapper::DATABASE_MAPPER => [
            parent::SEVEN_DAY_TURNOVER_PER_BRAND => [
                'name' => 'brandName',
                'sum'  => 'totalTutnOver'
            ],
            parent::SEVEN_DAY_TURNOVER_PER_DAY => [
                'date' => 'date',
                'sum'  => 'totalTutnOver'
            ]

        ],

        Mapper::REQUEST_MAPPER => [
            'startDate' => 'startDate',
            'endDate' => 'endDate',
            'pageStart' => 'pageStart',
            'pageEnd' => 'pageEnd',
            'reportType' => 'reportType',
        ],

        Mapper::VALIDATION_MAP => [
            'startDate' => [
                Validation::VALID_TYPE_REQUIRED
            ],
            'endDate' => [
                Validation::VALID_TYPE_REQUIRED
            ],
            'pageStart' => [
                Validation::VALID_TYPE_REQUIRED
            ],
            'pageEnd' => [
                Validation::VALID_TYPE_REQUIRED
            ],
            'reportType' => [
                Validation::VALID_TYPE_REQUIRED
            ],
        ]
    ];

    public function getReportData(array $request)
    {

        $data = [];

        if (empty($request)) {
            throw new Exception('Invalid data sent to ' . __METHOD__);
        }

        $validatedResults = $this->getValidationObj()->validateRequest($this->mapper, $request);

        if (!empty($validatedResults)) {
            throw new Exception('Validation Failed! ' . $validatedResults[0]);
        }

        if ($request['reportType'] === parent::SEVEN_DAY_TURNOVER_PER_BRAND) {

            $sql = "SELECT " . $this->table_bands . ".name, SUM(" . $this->table_gmv . ".turnover - (" . $this->table_gmv . ".turnover * " . self::VAT_PRESENTAGE . "/100)) 
                as sum FROM " . $this->table_bands . "
                LEFT JOIN " . $this->table_gmv . " ON brands.id = " . $this->table_gmv . ".brand_id WHERE " . $this->table_gmv . ".date 
                BETWEEN '" . self::START_DATE . "' AND '" . self::END_DATE . "' GROUP BY " . $this->table_gmv . ".brand_id";

            $data = $this->getReportsDataFromDb($sql);

            if (empty($data)) {
                throw new Exception('No report data found');
            }

            foreach ($data as $reportData) {
                $structReportData = $this->getObjectStructuredReportData(
                    $this->mapper[Mapper::DATABASE_MAPPER][parent::SEVEN_DAY_TURNOVER_PER_BRAND],
                    $reportData
                );
            }
        } elseif ($request['reportType'] === parent::SEVEN_DAY_TURNOVER_PER_DAY) {

            $sql = "SELECT " . $this->table_gmv . ".date, SUM(" . $this->table_gmv . ".turnover - (" . $this->table_gmv . ".turnover * " . self::VAT_PRESENTAGE . "/100))  as sum from brands LEFT JOIN "
                . $this->table_gmv . " ON brands.id = " . $this->table_gmv . ".brand_id WHERE " . $this->table_gmv . ".date 
            BETWEEN '" . self::START_DATE . "' AND '" . self::END_DATE . "' GROUP BY " . $this->table_gmv . ".date";

            $data = $this->getReportsDataFromDb($sql);

            if (empty($data)) {
                throw new Exception('No report data found');
            }

            foreach ($data as $reportData) {
                $structReportData = $this->getObjectStructuredReportData(
                    $this->mapper[Mapper::DATABASE_MAPPER][parent::SEVEN_DAY_TURNOVER_PER_BRAND],
                    $reportData
                );
            }
        } else {
            throw new \Exception('Report type not found');
        }

        return $data;
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
}
