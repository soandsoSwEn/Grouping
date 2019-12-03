<?php

namespace swe;

use swe\StatSeries;

/**
 * Grouping is the core class for the component application
 *
 * @author Dmytriyenko Vyacheslav <dmytriyenko.vyacheslav@gmail.com>
 */
class Grouping
{
    
    public $return_type = ['array', 'json' ,'output', 'file'];


    private $_series;
    
    public function __construct()
    {
        $this->_series = new StatSeries();
    }

    public function putSource(array $source) : void
    {
        $this->_series->assimilateData($source);
    }

    public function buildGss(string $output) : void
    {
        if(!in_array($output, $this->return_type)) {
            throw new \ErrorException('Error return type');
        }
        $this->_series->generateSeries($output);
    }
}
