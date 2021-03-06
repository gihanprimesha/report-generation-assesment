<?php

/**
 * Created by VS code.
 * User: Gihan Primesha
 * Date: 07/05/21
 * Time: 6:50 PM
 */

namespace Application;

class ActionFactory
{
    private $routeParams;
    private $routeConfig;

    const REPORT_CONTOLLER = 'reports';

    public function __construct()
    {
        $this->routeParams = $_SERVER['REQUEST_URI'];
    }

    /**
     * Initial function. Get the data from the post request. check the uri and according to map with uri
     * invoke the funtion with request data
     * @params null
     * @return json object 
     */
    public function actionCreator()
    {
        header("Content-Type: application/json");
 
        if (isset($this->getRouteConfig()['routes'][$this->routeParams])) {

            if ($_SERVER['REQUEST_METHOD'] !== $this->getRouteConfig()['routes'][$this->routeParams]['request-method']) {
                throw new \Exception($_SERVER['REQUEST_METHOD'] . ' not allowed');
            }

            $request = json_decode(file_get_contents('php://input'), true);

            $class =  $this->getRouteConfig()['routes'][$this->routeParams]['controller'];
            $contollerObj = new  $class();
            $returnData = $contollerObj->{$this->getRouteConfig()['routes'][$this->routeParams]['action']}($request);
            echo json_encode($returnData);
        } else {
            throw new \Exception('Url not found');
        }
    }

    private function getRouteConfig()
    {
        if (!isset($this->routeConfig)) {
            $this->setRouteConfig();
        }

        return $this->routeConfig;
    }

    private function setRouteConfig()
    {
        if (!(include 'Configs/application.config.php')) {
            throw new \Exception('Application config configurations not found');
        }

        $this->routeConfig = include 'Configs/application.config.php';
    }
}
