<?php

namespace swe;

/**
 *
 * @author Dmytriyenko Vyacheslav <dmytriyenko.vyacheslav@gmail.com>
 */
interface StatSeriesInterface
{
    
    public function setInputData(array $data) : void;
    
    public function putInTmpFile(array $data) : void;
    
    public function assimilateData(array $data) : void;
    
    public function generateSeries(string $type_output, ?string $path_file = null) : ?array;
    
    public function getView(array $partial_intervals, string $type_output, ?string $path_file = null) : ?array;
}
