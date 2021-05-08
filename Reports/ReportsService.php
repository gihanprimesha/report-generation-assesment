<?php

namespace Reports;

use Application\Connection;

class ReportsService
{
    function __construct()
    {
        $conection = new Connection();
        $conection->getConnction();
        echo $conection->getConnction();
    }
}
