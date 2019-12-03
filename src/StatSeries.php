<?php

namespace swe;

/**
 * Description of StatSeries
 *
 * @author Vyacheslav
 */
class StatSeries
{
    
    private $_temp_directory;
    const TEMP_FILE = 'source_data';
    
    private $_time_statr;
    
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
     * @var float Values ​​of a random variable at the boundaries 
     * of partial intervals
     */
    private $_X;
    
    private $_partial_intervals = [];

    /**
     * @var integer Interval frequencies
     */
    private $_m_i;
    
    /**
     * @var float The number of members of the series that fall 
     * into each partial interval
     */
    private $_x_;
    
    /**
     * @var float Relative spacing frequencies
     */
    private $_p;
    
    public function __construct()
    {
        $this->_time_statr = time();
        $this->_temp_directory = dirname(__FILE__).'/tmp';
    }

    public function setInputData(array $data) : void
    {
        $this->_input_data = $data;
        $this->putInTmpFile($data);
    }
    
    public function setN(int $data)
    {
        $this->_n = $data;
    }

    public function setXmin(float $data) : void
    {
        $this->_X_min = $data;
    }
    
    public function setXmax(float $data) : void
    {
        $this->_X_max = $data;
    }

    public function setK(int $data) : void
    {
        $this->_k = $data;
    }
    
    public function setC(float $data) : void
    {
        $this->_C = $data;
    }
    
    public function setX(float $data) : void
    {
        $this->_X = $data;
    }
    
    public function setPartIntervals($key, $left_value, $right_value) : void
    {
        $this->_partial_intervals[$key]['left_value'] = $left_value;
        $this->_partial_intervals[$key]['right_value'] = $right_value;
    }

    public function setM_I(int $key, int $data) : void
    {
        $this->_partial_intervals[$key]['m_i'] = $data;
    }
    
    public function setX_(int $key, float $data) : void
    {
        $this->_partial_intervals[$key]['mid_interval'] = $data;
    }
    
    public function setP(float $data) : void
    {
        $this->_p = $data;
    }
    
    public function getSourceData() : array
    {
        return $this->_input_data;
    }
    
    public function getN() : int
    {
        return $this->_n;
    }

    public function getXmin() : ?float
    {
        return $this->_X_min;
    }
    
    public function getXmax() : ?float
    {
        return $this->_X_max;
    }

    public function getK() : int
    {
        return $this->_k;
    }
    
    public function getC() : float
    {
        return $this->_C;
    }
    
    public function getX() : float
    {
        return $this->_X;
    }
    
    public function getPartIntervals() : array
    {
        return $this->_partial_intervals;
    }

    public function getM_I() : int
    {
        return $this->_m_i;
    }
    
    public function getX_() : float
    {
        return $this->_x_;
    }
    
    public function getP() : float
    {
        return $this->_p;
    }
    
    public function assimilateData(array $data) : void
    {
        //xmin
        if(!is_null($this->getXmin())) {
            if($min = min($data) < $this->getXmin()) {
                $this->setXmin(floatval(min($data)));
            }
        } else {
            $this->setXmin(floatval(min($data)));
        }
        
        //xmax
        if(!is_null($this->getXmax())) {
            if($max = max($data) < $this->getXmax()) {
                $this->setXmax($max);
            }
        } else {
            $this->setXmax(max($data));
        }
        
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
    
    public function putInTmpFile(array $data)
    {
        $file = $this->_temp_directory . '/' . $this->_time_statr . '_' . time() . '_' . md5(self::TEMP_FILE) . '.dat';
        if(file_exists($file)) {
            file_put_contents($file, serialize($data), FILE_APPEND);
        } else {
            file_put_contents($file, serialize($data));
        }
    }

    public function calculateXmin(array $data) : float
    {
        return $this->setXmin($this->getXmin() + min($data));
    }
    
    public function calculateXmax(array $data) : float
    {
        return $this->setXmax($this->getXmax() + max($data));
    }
    
    public function calculateN(int $data)
    {
        return $this->setN($this->getN() + intval($data));
    }
    
    public function calculateK() : int
    {
        return $this->_k = round( 5*log10($this->getN()) );
    }
    
    public function calculateC() : float
    {
        return $this->_C = ($this->getXmax() - $this->getXmin()) / $this->getK();
    }
    
    public function generateSeries(string $type_output)
    {
        $this->setPartialIntervals();
        $files = scandir($this->_temp_directory);
        foreach ($files as $file) 
        {
            if(is_file($this->_temp_directory.'/'.$file))
            {
                list($time_start, $time_file) = explode('_', $file);
                if(strtotime($this->_time_statr) == strtotime($time_start))
                {
                    $file_data = unserialize(file_get_contents($this->_temp_directory.'/'.$file));
                    $this->calculateIntFrequencies($file_data);
                }
            }
        }
        $this->addMidPartialInterval($this->getPartIntervals());
        $this->addRelativeFrequencies($this->getN(), $this->getPartIntervals());
    }

    public function setPartialIntervals()
    {
        for ((int)$i = 1; $i <= $this->getK(); $i++)
        {
            $left_board = $this->getXmin() + (($i-1)*$this->getC());
            $right_board = $this->getXmin() + $i*$this->getC();
            $this->setPartIntervals($i, $left_board, $right_board);
        }
    }
    
    public function calculateIntFrequencies(array $data)
    {
        $intervals = $this->getPartIntervals();
        $board_right = count($intervals);
        $board = false;
        for ((int) $i = 1; $i <= $this->getK(); $i++) 
        {
            foreach ($intervals as $k => $interval)
            {
                if($i == $k)
                {
                    if($board_right == $k)
                    {
                        $board = true;
                    }
                    $this->setM_I($i, $this->calcMiInterval($data, $interval, $board));
                }
            }
        }
    }
    
    
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
    
    public function addMidPartialInterval(array $intervals_data) : void
    {
        foreach ($intervals_data as $k => $interval) {
            $this->setX_($k, ($interval['left_value']+$interval['right_value'])/2);
        }
    }
    
    public function addRelativeFrequencies(int $n, array $part_intervals) : void
    {
        foreach ($part_intervals as $k => $interval) {
            $this->setP($interval['m_i']/$n);
            $this->_partial_intervals[$k]['relative_frequency'] = $this->getP();
        }
    }

    public function deleteTmpFile($file)
    {
        if(file_exists(file)) {
            unlink($file);
        }
    }
}
