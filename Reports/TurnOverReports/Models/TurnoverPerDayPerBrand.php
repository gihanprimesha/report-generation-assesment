<?php

/**
 * Created by VS code.
 * User: Gihan Primesha
 * Date: 15/05/21
 * Time: 10:45 PM
 */

namespace Reports\TurnOverReports\Models;

class TurnoverPerDayPerBrand
{
    private $day;
    private $brandName;
    private $totalTurnOver;

    /**
     * Set the value of day
     * @params day
     * @return  self
     */
    public function setDay($day)
    {
        $this->day = $day;
        return $this;
    }

    /**
     * Get the value of day
     * @return  day
     */
    public function getDay()
    {
        return $this->day;
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
     * Convert class property values to arrray
     * @return  data
     */
    public function toArray()
    {
        $data['day'] = $this->day;
        $data['brandName'] = $this->brandName;
        $data['totalTurnOver'] = $this->totalTurnOver;

        return $data;
    }
}
