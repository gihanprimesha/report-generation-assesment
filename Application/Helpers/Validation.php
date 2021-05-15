<?php

namespace Application\Helpers;

use \Application\Helpers\Mapper;

class Validation
{
    const VALID_TYPE_REQUIRED = 'REQUIRED';

    public function validateRequest($map, $dataSet)
    {

        $mesages = [];

        $validationMap = $map[Mapper::VALIDATION_MAP];
        if (empty($map) || empty($dataSet)) {
            throw new \Exception("Invalid data sent to " . __METHOD__);
        }

        if (!isset($map[Mapper::VALIDATION_MAP]) || count($map[Mapper::VALIDATION_MAP]) === 0) {
            throw new \Exception('Missing required configurations for validation');
        }

        foreach ($validationMap as $property => $propValues) {

            foreach ($propValues as $propValue) {
                if ($propValue === self::VALID_TYPE_REQUIRED) {

                    if (!isset($dataSet[$property]) || is_null($dataSet[$property]) || $dataSet[$property] === '') {
                        $mesages[] = 'Required property ' . $property;
                        break;
                    }
                }
            }
        }

        return $mesages;
    }
}
