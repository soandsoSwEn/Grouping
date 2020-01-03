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
    /**
     * @var type string
     */
    private $_series;
    
    /**
     * @var type array Established output formats
     */
    public $return_type = ['array', 'json', 'file'];
    
    public function __construct()
    {
        $this->_series = new StatSeries();
    }

    /**
     * Adds raw data to the work
     * @param array $source Simple statistical series
     * @return void
     */
    public function putSource(array $source) : void
    {
        $this->_series->assimilateData($source);
    }

    /**
     * Forms a grouped statistical series
     * @param string $output Defines output format - array, json or file
     * @param string|null $path_file Path of the output file
     * @return array|null
     * @throws \ErrorException
     */
    public function buildGss(string $output, ?string $path_file = null)
    {
        if(!in_array($output, $this->return_type)) {
            throw new \ErrorException('Error return type');
        }
        return $this->_series->generateSeries($output, $path_file);
    }
}
