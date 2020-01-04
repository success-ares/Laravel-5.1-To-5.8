<?php namespace App\Service;

trait DifferentFunctionsService
{
    /**
     * Clean data
     * @param $arrayToClean
     * @return array
     */
    public function cleanData($arrayToClean)
    {
        return array_map( function($item){
            return clean($item, ['HTML.Allowed' => '']);
        }, $arrayToClean);
    }
}