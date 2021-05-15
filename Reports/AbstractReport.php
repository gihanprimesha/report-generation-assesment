<?php

/**
 * Created by VS code.
 * User: Gihan Primesha
 * Date: 15/05/21
 * Time: 1:00 PM
 */

namespace Reports;

use Application\Connection;

abstract class AbstractReport
{


    const TURNOVER_PER_BRAND = 'TURNOVER_PER_BRAND';
    const TURNOVER_PER_DAY = 'TURNOVER_PER_DAY';

    private $dbConnection;

    abstract public function getReportData(array $request);

    /** get date from the data base */
    public function getReportsDataFromDb($query = null)
    {
        if (!isset($query)) {
            throw new \Exception('Invalid data sent to ' . __METHOD__);
        }

        $result = $this->getDbConnection()->query($query);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function getObjectStructuredReportData($map, $reportData)
    {
        $data = [];
        $mapper = $map;

        foreach ($reportData as $key => $value) {
            if (isset($mapper[$key])) {
                $data[$mapper[$key]] = $value;
            }
        }

        return $data;
    }

    private function getDbConnection()
    {
        if (!isset($this->dbConnection)) {
            $this->setDbConnaction();
        }
        return $this->dbConnection;
    }

    private function setDbConnaction()
    {
        $connection = new Connection();
        $this->dbConnection = $connection->getConnction();
    }
}