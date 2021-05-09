<?php

/**
 * Created by VS code.
 * User: Gihan Primesha
 * Date: 09/05/21
 * Time: 6:00 PM
 */

namespace Application;

class FileGenerator
{

    private $fileDataHeaders;

    public function __construct($data)
    {
        $this->fileDataHeaders = $data;
    }

    /** 
     * Download the csv file
     *  If it is large data use proper file genrator plugin
     */
    public function generateCsvFile($contentData = null)
    {

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . date("Y G:i") . '.csv');

        $output = fopen('php://output', 'w');
        fputcsv($output, $this->fileDataHeaders);

        foreach ($contentData as $data) {

            fputcsv($output, $data);
        }
    }
}
