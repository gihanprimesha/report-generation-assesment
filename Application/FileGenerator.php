<?php

/**
 * Created by VS code.
 * User: Gihan Primesha
 * Date: 09/05/21
 * Time: 6:00 PM
 */

namespace Application;

use PHPUnit\TextUI\XmlConfiguration\File;

class FileGenerator
{

    private $fileDataHeaders;
    const REPORT_FOLDER = 'files';
    public static $instance;

    private function __construct($data)
    {
        $this->fileDataHeaders = $data;
    }

    /** 
     * Download the csv file
     *  If it is large data use proper file genrator plugin
     * @params reportData
     * @return array
     */
    public function generateCsvFile($contentData = null)
    {
        try {
            $time = date('H:i:s d-M-Y');

            $fileName = __DIR__ . "/../" . self::REPORT_FOLDER . "/report-{$time}.csv";

            if (!file_exists(__DIR__ . '/../' . self::REPORT_FOLDER)) {
                mkdir(__DIR__ . '/../' . self::REPORT_FOLDER, 0777, true);
            }

            $file = fopen($fileName, 'w');
            fputcsv($file, $this->fileDataHeaders);

            foreach ($contentData as $data) {

                fputcsv($file, $data->toArray());
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }


        return [
            'fileName' => "report-{$time}.csv",
            'fileLocation' => $this->getFileLocation("report-{$time}.csv"),
        ];
    }

    /**
     * Get file created location
     * @params null
     * @return locationUrl
     */
    private function getFileLocation($fileName)
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'] . '/';

        $fileLocation = $protocol . $domainName . self::REPORT_FOLDER . '/' . $fileName;

        return $fileLocation;
    }

    /**
     * Get file generator instance
     * @params report data
     * @return FileGenerator
     */
    public static function getInstance($data)
    {

        if (!isset(FileGenerator::$instance)) {
            FileGenerator::$instance = new FileGenerator($data);
        }

        return FileGenerator::$instance;
    }
}
