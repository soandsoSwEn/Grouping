<?php

namespace swe;

use swe\StatSeriesInterface;

/**
 * Class that contains basic methods for constructing a grouped statistical series
 *
 * @author Dmytriyenko Vyacheslav <dmytriyenko.vyacheslav@gmail.com>
 */
class StatSeries implements StatSeriesInterface
{
    
    /**
     * @var string Directory for temporary input files 
     */
    private $_temp_directory;

    /**
     * @var string Output file name 
     */
    private $_output_file_name = 'statistical_series.txt';
    
    /**
     * @var string Temporary file name
     */
    private $_temp_file = 'source_data';
    
    /**
     * @var int StatSeries object creation timestamp
     */
    private $_time_start;
    
    /**
     * @var array Source data of a statistical series
     */
    private $_input_data = [];
    
    /**
     * @var int Statistical sample size 
     */
    private $_n = 0;
    
    /**
     * @var float minimum value of a random variable 
     */
    private $_X_min = null;

    /**
     * @var float maximum value of a random variable 
     */
    private $_X_max = null;
    /**
     * @var integer Number of partial intervals of statistical series
     */
    private $_k;
    
    /**
     * @var float Partial interval length
     */
    private $_C;
    
    /**
     * @var array Partial intervals of a grouped statistical series 
     */
    private $_partial_intervals = [];

    /**
     * @var integer Interval frequencies
     */
    private $_m_i;
    
    /**
     * @var float Random value in the middle of a partial interval
     */
    private $_x_;
    
    /**
     * @var float Relative spacing frequencies
     */
    private $_p;
    
    
    public function __construct()
    {
        $this->_time_start = time();
        $this->setTmpDirectory();
    }
    
    public function setTmpDirectory()
    {
        $this->_temp_directory = dirname(__FILE__).'/tmp';
        if (!is_dir($this->_temp_directory)) {
            mkdir($this->_temp_directory);
        }
    }

    /**
     * Sets initial data in the calculation model
     * @param array $data
     * @return void
     */
    public function setInputData(array $data) : void
    {
        $this->_input_data = $data;
        $this->putInTmpFile($data);
    }
    
    /**
     * Sets size of a statistical series
     * @param int $data
     * @return void
     */
    public function setN(int $data) : void
    {
        $this->_n = $data;
    }

    /**
     * Sets minimum value of a random variable
     * @param float $data minimum value of a random variable
     * @return void
     */
    public function setXmin(float $data) : void
    {
        $this->_X_min = $data;
    }
    
    /**
     * Sets maximum value of a random variable
     * @param float $data maximum value of a random variable 
     * @return void
     */
    public function setXmax(float $data) : void
    {
        $this->_X_max = $data;
    }

    /**
     * Sets Number of partial intervals of statistical series
     * @param int $data number of partial intervals
     * @return void
     */
    public function setK(int $data) : void
    {
        $this->_k = $data;
    }
    
    /**
     * Sets partial interval length of statistical series
     * @param float $data partial interval length
     * @return void
     */
    public function setC(float $data) : void
    {
        $this->_C = $data;
    }
    
    /**
     * Sets boundary values ​​for a partial interval
     * @param type int $key Number of partial interval
     * @param type float $left_value Left border of the interval
     * @param type float $right_value Right border of the interval
     * @return void
     */
    public function setPartIntervals(int $key, float $left_value, float $right_value) : void
    {
        $this->_partial_intervals[$key]['left_value'] = $left_value;
        $this->_partial_intervals[$key]['right_value'] = $right_value;
    }

    /**
     * Sets interval frequency value of a statistical series
     * @param int $key Number of partial interval
     * @param int $data interval frequency value
     * @return void
     */
    public function setM_I(int $key, int $data) : void
    {
        $this->_partial_intervals[$key]['m_i'] = $data;
    }
    
    /**
     * Sets value in the middle of a partial interval of a statistical series
     * @param int $key Number of partial interval
     * @param float $data Value in the middle of a partial interval
     * @return void
     */
    public function setX_(int $key, float $data) : void
    {
        $this->_partial_intervals[$key]['mid_interval'] = $data;
    }
    
    /**
     * 
     * @return string output file name 
     */
    public function getOutputFileName() : string
    {
        return $this->_output_file_name;
    }

    /**
     * Sets relative spacing frequencies
     * @param float $data Relative spacing frequencies
     * @return void
     */
    public function setP(float $data) : void
    {
        $this->_p = $data;
    }
    
    /**
     * Returns source data of a statistical series
     * @return array Source data of a statistical series
     */
    public function getSourceData() : array
    {
        return $this->_input_data;
    }
    
    /**
     * 
     * @return int statistical sample size 
     */
    public function getN() : int
    {
        return $this->_n;
    }

    /**
     * Returns the minimum value of a statistical series
     * @return float|null
     */
    public function getXmin() : ?float
    {
        return $this->_X_min;
    }
    
    /**
     * Returns the maximum value of a statistical series
     * @return float|null
     */
    public function getXmax() : ?float
    {
        return $this->_X_max;
    }

    /**
     * 
     * @return int number of partial intervals of statistical series
     */
    public function getK() : int
    {
        return $this->_k;
    }
    
    /**
     * 
     * @return float partial interval length
     */
    public function getC() : float
    {
        return $this->_C;
    }
    
    /**
     * 
     * @return array partial intervals of a grouped statistical series 
     */
    public function getPartIntervals() : array
    {
        return $this->_partial_intervals;
    }

    /**
     * 
     * @return int interval frequencies
     */
    public function getM_I() : int
    {
        return $this->_m_i;
    }
    
    /**
     * 
     * @return float random value in the middle of a partial interval
     */
    public function getX_() : float
    {
        return $this->_x_;
    }
    
    /**
     * 
     * @return float relative spacing frequencies
     */
    public function getP() : float
    {
        return $this->_p;
    }
    
    /**
     * Assimilation of statistical data into a calculation model
     * @param array $data Simple statistical series
     * @return void
     */
    public function assimilateData(array $data) : void
    {
        //xmin
        $this->calculateXmin($data);
        
        //xmax
        $this->calculateXmax($data);
                
        //n
        if($this->getN()) {
            $this->calculateN(count($data));
        } else {
            $this->setN(count($data));
        }
        
        //k
        $this->calculateK();
        
        //C
        $this->calculateC();
        
        
        $this->setInputData($data);
    }
    
    /**
     * Generates a temporary file with input data for one iteration of data input
     * @param array $data Simple statistical series
     * @return void
     */
    public function putInTmpFile(array $data) : void
    {
        $file = $this->_temp_directory . '/' . $this->_time_start . '_' . time() . '_' . md5($this->_temp_file) . '.dat';
        if (file_exists($file)) {
            file_put_contents($file, serialize($data), FILE_APPEND);
        } else {
            file_put_contents($file, serialize($data));
        }
    }

    /**
     * Calculate minimum value of a statistical series
     * @param array $data Simple statistical series
     * @return void
     */
    public function calculateXmin(array $data) : void
    {
        if (!is_null($this->getXmin())) {
            if($min = min($data) < $this->getXmin()) {
                $this->setXmin(floatval(min($data)));
            }
        } else {
            $this->setXmin(floatval(min($data)));
        }
    }
    
    /**
     * Calculate minimum value of a statistical series
     * @param array $data Simple statistical series
     * @return void
     */
    public function calculateXmax(array $data) : void
    {
        if (!is_null($this->getXmax())) {
            if($max = max($data) < $this->getXmax()) {
                $this->setXmax($max);
            }
        } else {
            $this->setXmax(max($data));
        }
    }
    
    /**
     * Counts and returns the updated value of the statistical sample size
     * of a statistical series
     * @param int $data Simple statistical series
     * @return type int statistical sample size
     */
    public function calculateN(int $data) : int
    {
        return $this->setN($this->getN() + intval($data));
    }
    
    /**
     * Calculate and returns value of number of partial intervals 
     * of statistical series
     * @return int number of partial intervals
     */
    public function calculateK() : int
    {
        return $this->_k = round( 5*log10($this->getN()) );
    }
    
    /**
     * Calculate and returns partial interval length
     * @return float partial interval length
     */
    public function calculateC() : float
    {
        return $this->_C = ($this->getXmax() - $this->getXmin()) / $this->getK();
    }
    
    /**
     * Generation of grouped statistical series
     * @param string $type_output Defines output format
     * @param string|null $path_file Path of the output file (it matters if 
     * the output format is selected file)
     * @return array|null
     */
    public function generateSeries(string $type_output, ?string $path_file = null) : ?array
    {
        $this->setPartialIntervals();
        $files = scandir($this->_temp_directory);
        foreach ($files as $file) 
        {
            if (is_file($this->_temp_directory.'/'.$file))
            {
                list($time_start, $time_file) = explode('_', $file);
                if ($this->_time_start == intval($time_start))
                {
                    $file_data = unserialize(file_get_contents($this->_temp_directory.'/'.$file));
                    $this->calculateIntFrequencies($file_data);
                }
            }
        }
        $this->addMidPartialInterval($this->getPartIntervals());
        $this->addRelativeFrequencies($this->getN(), $this->getPartIntervals());
        $this->deleteTmpFiles($this->_temp_directory, $this->_time_start);
        return $this->getView($this->_partial_intervals, $type_output, $path_file);
    }

    /**
     * Calculates and sets the boundaries of partial intervals of a statistical 
     * series
     * @return void
     */
    public function setPartialIntervals() : void
    {
        for ((int)$i = 1; $i <= $this->getK(); $i++) {
            $left_board = $this->getXmin() + (($i-1)*$this->getC());
            $right_board = $this->getXmin() + $i*$this->getC();
            $this->setPartIntervals($i, $left_board, $right_board);
        }
    }
    
    /**
     * Calculation and addition of interval frequencies to the model
     * @param array $data Simple statistical series
     * @return void
     */
    public function calculateIntFrequencies(array $data) : void
    {
        $intervals = $this->getPartIntervals();
        $board_right = count($intervals);
        /** right border of the last interval of the statistical series */
        $board = false;
        for ((int) $i = 1; $i <= $this->getK(); $i++) {
            foreach ($intervals as $k => $interval) {
                if ($i == $k) {
                    if ($board_right == $k) {
                        $board = true;
                    }
                    $this->setM_I($i, $this->calcMiInterval($data, $interval, $board));
                }
            }
        }
    }
    
    
    /**
     * Calculation interval frequency
     * @param array $data_series Simple statistical series
     * @param array $data_interval Partial intervals of a grouped statistical series
     * @param bool $board the right border of the last interval of the statistical series
     * @return int $count Interval frequency for a given interval
     */
    public function calcMiInterval(array $data_series, array $data_interval, bool $board) : int
    {
        (int)$count = 0;
        foreach ($data_series as $value) {
            if ($board) {
                if ($value >= $data_interval['left_value'] && $value < $data_interval['right_value']) {
                    $count++;
                }
            } else {
                if ($value >= $data_interval['left_value'] && $value <= $data_interval['right_value']) {
                    $count++;
                }
            }
        }
        return $count;
    }
    
    /**
     * Calculates and adds to the model middle of a partial interval
     * @param array $intervals_data Partial intervals of a grouped statistical series
     * @return void
     */
    public function addMidPartialInterval(array $intervals_data) : void
    {
        foreach ($intervals_data as $k => $interval) {
            $this->setX_($k, ($interval['left_value']+$interval['right_value'])/2);
        }
    }
    
    /**
     * Calculates and adds to the model relative frequencies
     * @param int $n Statistical sample size 
     * @param array $part_intervals Partial intervals of a grouped statistical series
     * @return void
     */
    public function addRelativeFrequencies(int $n, array $part_intervals) : void
    {
        foreach ($part_intervals as $k => $interval) {
            $this->setP($interval['m_i']/$n);
            $this->_partial_intervals[$k]['relative_frequency'] = $this->getP();
        }
    }

    /**
     * Deletes a temporary source data file
     * @param type $temp_directory Directory for temporary input files 
     * @param type $time_start StatSeries object creation timestamp
     */
    public function deleteTmpFiles($temp_directory, $time_start)
    {
        $files = scandir($temp_directory);
        foreach ($files as $file) {
            if (is_file($this->_temp_directory . '/' . $file)) {
                list($time_start_file) = explode('_', $file);
                if ($time_start == intval($time_start_file)) {
                    unlink($temp_directory . '/' . $file);
                }
            }
        }
    }
    
    /**
     * Forms the output of a statistical grouped series
     * @param array $partial_intervals Partial intervals of a grouped statistical series
     * @param string $type_output Defines output format
     * @param string|null $path_file Path of the output file
     * @return array|null
     * @throws \ErrorException
     */
    public function getView(array $partial_intervals, string $type_output, ?string $path_file = null) : ?array
    {
        if(strcasecmp($type_output, 'array') == 0) {
            return $this->buildArrayOutput($partial_intervals);
        } elseif (strcasecmp($type_output, 'json') == 0) {
            return $this->buildJsonOutput($partial_intervals);
        } elseif (strcasecmp($type_output, 'file') == 0) {
            return $this->buildFileOutput($partial_intervals, $path_file);
        } else {
            throw new \ErrorException('Error return type');
        }
    }
    
    /**
     * Forms the result of constructing a grouped statistical series in array format
     * @param type $partial_intervals Partial intervals of a grouped statistical series
     * @return array grouped statistical series
     */
    public function buildArrayOutput($partial_intervals) : array
    {
        $grouped_series = [];
        foreach ($partial_intervals as $i => $value) {
            $grouped_series[$i]['left_border'] = $value['left_value'];
            $grouped_series[$i]['right_border'] = $value['right_value'];
            $grouped_series[$i]['middle_partial_interval'] = $value['mid_interval'];
            $grouped_series[$i]['interval_frequency'] = $value['m_i'];
            $grouped_series[$i]['relative_frequency'] = $value['relative_frequency'];
        }
        return $grouped_series;
    }
    
    /**
     * Generates the result of building a grouped statistical series in json format
     * @param type $partial_intervals Partial intervals of a grouped statistical series
     * @return array grouped statistical series
     */
    public function buildJsonOutput($partial_intervals) : array
    {
        return json_encode($this->buildArrayOutput($partial_intervals));
    }
    
    /**
     * Forms a file of the results of building a grouped statistical series
     * @param type $partial_intervals Partial intervals of a grouped statistical series
     * @param type $path_file Path of the output file (it matters if
     * the output format is selected file)
     * @return array|null
     * @throws \ErrorException
     */
    public function buildFileOutput($partial_intervals, $path_file) : ?array
    {
        if(is_null($path_file)) {
            throw \ErrorException('Error path output file');
        }
        $view = '';
        foreach ($partial_intervals as $i => $value) {
            $view .= $i . "    " . $value['left_value'] . ";" . "    " . $value['right_value'] . "    "
                    . $value['m_i'] . "    " . $value['relative_frequency'] . "    " . $value['mid_interval'] . "\r\n";
        }
        if(file_put_contents($path_file . $this->getOutputFileName(), $view)) {
            return [true];
        } else {
            return false;
        }
        
    }
}
