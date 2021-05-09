<?php

/**
 * Created by VS code.
 * User: Gihan Primesha
 * Date: 09/05/21
 * Time: 4:45 PM
 */

namespace Reports;

use Application\Connection;
use Application\FileGenerator;

class ReportsGateway
{
    private $dbConnection;

    /** Hard corded bcaouse of the assesment */
    const START_DATE = '2018-05-01';
    const END_DATE = '2018-05-07';
    const VAT_PRESENTAGE = '21';

    private $table_bands = 'brands';
    private $table_gmv = 'gmv';

    function __construct()
    {
        $connection = new Connection();
        $this->dbConnection = $connection->getConnction();
    }

    /** Generate report 7 days turnover per brand*/
    public function generateReportOne()
    {

        $sql = "SELECT " . $this->table_bands . ".name, SUM(" . $this->table_gmv . ".turnover - (" . $this->table_gmv . ".turnover * " . self::VAT_PRESENTAGE . "/100)) 
        as sum FROM " . $this->table_bands . "
        LEFT JOIN " . $this->table_gmv . " ON brands.id = " . $this->table_gmv . ".brand_id WHERE " . $this->table_gmv . ".date 
        BETWEEN '" . self::START_DATE . "' AND '" . self::END_DATE . "' GROUP BY " . $this->table_gmv . ".brand_id";

        $data = $this->getReportsDataFromDb($sql);

        if (empty($data)) {
            throw new \Exception('Report data not found');
        }

        return $data;
    }

    /** Generate report 7 days turnover per day.*/
    public function generateReportTwo()
    {
        $sql = "SELECT " . $this->table_gmv . ".date, SUM(" . $this->table_gmv . ".turnover - (" . $this->table_gmv . ".turnover * " . self::VAT_PRESENTAGE . "/100))  as sum from brands LEFT JOIN "
            . $this->table_gmv . " ON brands.id = " . $this->table_gmv . ".brand_id WHERE " . $this->table_gmv . ".date 
        BETWEEN '" . self::START_DATE . "' AND '" . self::END_DATE . "' GROUP BY " . $this->table_gmv . ".date";

        $data = $this->getReportsDataFromDb($sql);

        if (empty($data)) {
            throw new \Exception('Report data not found');
        }

        return $data;
    }

    /** get date from the data base */
    public function getReportsDataFromDb($query = null)
    {
        if (!isset($query)) {
            throw new \Exception('Invalid data sent to ' . __METHOD__);
        }

        $result = $this->dbConnection->query($query);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }
        }

        return $data;
    }
}
