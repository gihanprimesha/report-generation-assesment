<?php

namespace Reports;

class ReportController {
    function __construct(){
        new ReportsGateway();
        echo 'ReportController';
    }
}