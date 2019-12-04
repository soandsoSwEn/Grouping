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
    
    private $_series;
    public $return_type = ['array', 'json', 'file'];
    
    public function __construct()
    {
        $this->_series = new StatSeries();
    }

    public function putSource(array $source) : void
    {
        $this->_series->assimilateData($source);
    }

    public function buildGss(string $output, ?string $path_file = null) : ?array
    {
        if(!in_array($output, $this->return_type)) {
            throw new \ErrorException('Error return type');
        }
        return $this->_series->generateSeries($output, $path_file);
    }
}
