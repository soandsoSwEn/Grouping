<?php

namespace swe;

/**
 * StatSeriesInterface is interface that must be implemented by the construction
 * class of the grouped statistical series
 * 
 * @author Dmytriyenko Vyacheslav <dmytriyenko.vyacheslav@gmail.com>
 */
interface StatSeriesInterface
{
    
    /**
     * Initializes the source data
     * @param array $data Simple statistical series
     * @return void
     */
    public function setInputData(array $data) : void;
    
    /**
     * Generates a temporary file with input data for one iteration of data input
     * @param array $data Simple statistical series
     * @return void
     */
    public function putInTmpFile(array $data) : void;
    
    /**
     * Assimilation of statistical data into a calculation model
     * @param array $data Simple statistical series
     * @return void
     */
    public function assimilateData(array $data) : void;
    
    /**
     * Generation of grouped statistical series
     * @param string $type_output
     * @param string|null $path_file
     * @return array|null
     */
    public function generateSeries(string $type_output, ?string $path_file = null) : ?array;
    
    /**
     * Forms the output of a statistical grouped series
     * @param array $partial_intervals Partial intervals of a grouped statistical series
     * @param string $type_output Defines output format - array, json or file
     * @param string|null $path_file Path of the output file (it matters if 
     * the output format is selected file)
     * @return array|null
     */
    public function getView(array $partial_intervals, string $type_output, ?string $path_file = null) : ?array;
}
