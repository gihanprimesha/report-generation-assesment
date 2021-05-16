<?php

/**
 * Created by VS code.
 * User: Gihan Primesha
 * Date: 15/05/21
 * Time: 10:45 PM
 */

namespace Reports\TurnOverReports\Models;

class TurnoverPerBrand
{

    private $brandName;
    private $totalTurnOver;

    /**
     * Set the value of brandName
     * @params brandName
     * @return  self
     */
    public function setBrandName($brandName)
    {
        $this->brandName = $brandName;
        return $this;
    }

    /**
     * Get the value of brandName
     * @return  brandName
     */
    public function getBrandName()
    {
        return $this->brandName;
    }

    /**
     * Set the value of totalTurnOver
     * @params totalTurnOver
     * @return  self
     */
    public function setTotalTurnOver($totalTurnOver)
    {
        $this->totalTurnOver = $totalTurnOver;
        return $this;
    }

    /**
     * Get the value of totalTurnOver
     * @return  totalTurnOver
     */
    public function getTotalTurnOver()
    {
        return $this->totalTurnOver;
    }

    /**
     * Convert class property values to arrray
     * @return  data
     */
    public function toArray()
    {
        $data['brandName'] = $this->brandName;
        $data['totalTurnOver'] = $this->totalTurnOver;

        return $data;
    }
}
