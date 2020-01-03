<?php

namespace swe\tests;

use PHPUnit\Framework\TestCase;
use swe\StatSeries;


class StatSeriesTest extends TestCase
{
    private $stat_series;
    
    protected function setUp(): void 
    {
        $this->stat_series = new StatSeries();
    }
    
    public function testSetN()
    {
        $value = 10;
        $this->stat_series->setN($value);
        $actual = $this->stat_series->getN();
        $expected = 10;
        $this->assertSame($expected, $actual);
    }
    
    public function testSetInputData()
    {
        $value = [1,3,5,7,9,11,15,20];
        $this->stat_series->setInputData($value);
        $actual = $this->stat_series->getSourceData();
        $expected = [1,3,5,7,9,11,15,20];
        $this->assertSame($expected, $actual);
    }
    
    public function testSetXmin()
    {
        $value = floatval(17.28);
        $this->stat_series->setXmin($value);
        $actual = $this->stat_series->getXmin();
        $expected = floatval(17.28);
        $this->assertSame($expected, $actual);
    }
    
    public function testSetXmax()
    {
        $value = floatval(19.25);
        $this->stat_series->setXmax($value);
        $actual = $this->stat_series->getXmax();
        $expected = floatval(19.25);
        $this->assertSame($expected, $actual);
    }
    
    public function testSetK()
    {
        $value = intval(9);
        $this->stat_series->setK($value);
        $actual = $this->stat_series->getK();
        $expected = intval(9);
        $this->assertSame($expected, $actual);
    }
    
    public function testSetC()
    {
        $value = floatval(28.5);
        $this->stat_series->setC($value);
        $actual = $this->stat_series->getC();
        $expected = floatval(28.5);
        $this->assertSame($expected, $actual);
    }
    
    public function testSetPartIntervals()
    {
        $key = 1;
        $left_value = -2.3;
        $right_value = 5.8;
        $this->stat_series->setPartIntervals($key, $left_value, $right_value);
        $actual = $this->stat_series->getPartIntervals();
        $actual = $actual[$key]['left_value'];
        $expected = -2.3;
                
        $this->assertSame($expected, $actual);
        
        $actual = $this->stat_series->getPartIntervals();
        $actual = $actual[$key]['right_value'];
        $expected = 5.8;
                
        $this->assertSame($expected, $actual);
    }
    
    public function testsetM_I()
    {
        $key = 5;
        $data = 18;
        $this->stat_series->setM_I($key, $data);
        $result = $this->stat_series->getPartIntervals();
        $actual = $result[$key]['m_i'];
        $expected = 18;
        
        $this->assertSame($expected, $actual);
    }
    
    public function testsetX_()
    {
        $key = 7;
        $data = 28.9;
        $this->stat_series->setX_($key, $data);
        $result = $this->stat_series->getPartIntervals();
        $actual = $result[$key]['mid_interval'];
        $expected = 28.9;
        
        $this->assertSame($expected, $actual);
    }
    
    public function testGetOutputFileName()
    {
        $actual = $this->stat_series->getOutputFileName();
        $expected = 'statistical_series.txt';
        
        $this->assertSame($expected, $actual);
    }
    
    public function testSetP()
    {
        $data = 35.2;
        $this->stat_series->setP($data);
        $actual = $this->stat_series->getP();
        $expected = 35.2;
        
        $this->assertSame($expected, $actual);
    }
    
    public function testGetSourceData()
    {
        $data = [12.1, 58.6, 7, 3.02, 58.7, 8.02, 32, 1, 59, 55];
        $this->stat_series->setInputData($data);
        $actual = $this->stat_series->getSourceData();
        $expected = [12.1, 58.6, 7, 3.02, 58.7, 8.02, 32, 1, 59, 55];
        
        $this->assertSame($expected, $actual);
    }
    
    public function testGetN()
    {
        $value = 381;
        $this->stat_series->setN($value);
        $actual = $this->stat_series->getN();
        $expected = 381;
        $this->assertSame($expected, $actual);
    }
    
    public function testGetXmin()
    {
        $value = floatval(-1.03);
        $this->stat_series->setXmin($value);
        $actual = $this->stat_series->getXmin();
        $expected = floatval(-1.03);
        $this->assertSame($expected, $actual);
    }
    
    public function testGetXmax()
    {
        $value = floatval(21.58);
        $this->stat_series->setXmax($value);
        $actual = $this->stat_series->getXmax();
        $expected = floatval(21.58);
        $this->assertSame($expected, $actual);
    }
    
    public function testGetK()
    {
        $value = intval(15);
        $this->stat_series->setK($value);
        $actual = $this->stat_series->getK();
        $expected = intval(15);
        $this->assertSame($expected, $actual);
    }
    
    public function testGetC()
    {
        $value = floatval(31.02);
        $this->stat_series->setC($value);
        $actual = $this->stat_series->getC();
        $expected = floatval(31.02);
        $this->assertSame($expected, $actual);
    }
    
    public function testGetPartIntervals()
    {
        $key = 1;
        $left_value = -2.3;
        $right_value = 5.8;
        $this->stat_series->setPartIntervals(1, $left_value, $right_value);
        $result = $this->stat_series->getPartIntervals();
        $actual = $result[$key]['left_value'];
        $expected = -2.3;
        
        $this->assertSame($expected, $actual);
        
        $actual = $result[$key]['right_value'];
        $expected = 5.8;
        
        $this->assertSame($expected, $actual);
    }
    
    public function testGetM_I()
    {
        $key = 2;
        $data = 25;
        $this->stat_series->setM_I($key, $data);
        $result = $this->stat_series->getPartIntervals();
        $actual = $result[$key]['m_i'];
        $expected = 25;
        
        $this->assertSame($expected, $actual);
    }
    
    public function testGetX_()
    {
        $key = 4;
        $data = 31.02;
        $this->stat_series->setX_($key, $data);
        $result = $this->stat_series->getPartIntervals();
        $actual = $result[$key]['mid_interval'];
        $expected = 31.02;
        
        $this->assertSame($expected, $actual);
    }
    
    public function testGetP()
    {
        $data = 10.3;
        $this->stat_series->setP($data);
        $actual = $this->stat_series->getP();
        $expected = 10.3;
        
        $this->assertSame($expected, $actual);
    }
    
    public function testAssimilateData()
    {
        $data = [-6.4, -3, -1.2, -4.5, -0.4, -3, -3.2, -8.2, 3, 0.4, -8.1, -1.2,
                2.1, -1.2, -9, 1.2, -0.1, -1.8, -0.6, 1.2, 0, -1.2, 1.2, -9.4,
                -4.6, 0, 0.7, -4, -3.8, -4.4, -0.3, 1.3, -7, -3.7, -3.1];
        $this->stat_series->assimilateData($data);
        
        $x_min = -9.4;
        $x_max = 3.0;
        $n = 35;
        $k = 8;
        $c = 1.55;
        $input_data = $this->stat_series->getSourceData();
        $expected_input_data = [-6.4, -3, -1.2, -4.5, -0.4, -3, -3.2, -8.2, 3, 0.4, -8.1, -1.2,
                2.1, -1.2, -9, 1.2, -0.1, -1.8, -0.6, 1.2, 0, -1.2, 1.2, -9.4,
                -4.6, 0, 0.7, -4, -3.8, -4.4, -0.3, 1.3, -7, -3.7, -3.1];
        $this->assertSame($expected_input_data, $input_data);
        
        $actual_x_min = $this->stat_series->getXmin();
        $this->assertSame($x_min, $actual_x_min);
        
        $actual_x_max = $this->stat_series->getXmax();
        $this->assertSame($x_max, $actual_x_max);
        
        $actual_n = $this->stat_series->getN();
        $this->assertSame($n, $actual_n);
        
        $actual_k = $this->stat_series->getK();
        $this->assertSame($k, $actual_k);
        
        $actual_c = $this->stat_series->getC();
        $this->assertSame($c, $actual_c);
    }
    
    public function testCalculateXmin()
    {
        $data = [-6.4, -3, -1.2, -4.5, -0.4, -3, -3.2, -8.2, 3, 0.4, -8.1, -1.2,
                2.1, -1.2, -9, 1.2, -0.1, -1.8, -0.6, 1.2, 0, -1.2, 1.2, -9.4,
                -4.6, 0, 0.7, -4, -3.8, -4.4, -0.3, 1.3, -7, -3.7, -3.1];
        $this->stat_series->calculateXmin($data);
        $actual = $this->stat_series->getXmin();
        $expected = -9.4;
        $this->assertSame($expected, $actual);
    }
    
    public function testCalculateXmax()
    {
        $data = [-6.4, -3, -1.2, -4.5, -0.4, -3, -3.2, -8.2, 3, 0.4, -8.1, -1.2,
                2.1, -1.2, -9, 1.2, -0.1, -1.8, -0.6, 1.2, 0, -1.2, 1.2, -9.4,
                -4.6, 0, 0.7, -4, -3.8, -4.4, -0.3, 1.3, -7, -3.7, -3.1];
        $this->stat_series->calculateXmax($data);
        $actual = $this->stat_series->getXmax();
        $expected = 3.0;
        $this->assertSame($expected, $actual);
    }
    
    public function testCalculateN()
    {
        $this->stat_series->setN(2);
        $this->stat_series->calculateN(5);
        $actual = $this->stat_series->getN();
        $expected = 7;
        $this->assertSame($expected, $actual);
    }
    
    public function testCalculateK()
    {
        $this->stat_series->setN(35);
        $this->stat_series->calculateK();
        $actual = $this->stat_series->getK();
        $expected = 8;
        $this->assertSame($expected, $actual);
    }
    
    public function testCalculateC()
    {
        $this->stat_series->setK(8);
        $this->stat_series->setXmin(-9.4);
        $this->stat_series->setXmax(3.0);
        $this->stat_series->calculateC($data);
        $actual = $this->stat_series->getC();
        $expected = 1.55;
        $this->assertSame($expected, $actual);
    }
    
    public function testSetPartialIntervals()
    {
        $this->stat_series->setK(8);
        $this->stat_series->setXmin(-9.4);
        $this->stat_series->setXmax(3.0);
        $this->stat_series->setC(1.55);
        $this->stat_series->setPartialIntervals();
        $result = $this->stat_series->getPartIntervals();
        
        $actual = $result[1]['left_value'];
        $expected = -9.4;
        $this->assertSame($expected, $actual);
        
        $actual = $result[1]['right_value'];
        $expected = -7.85;
        $this->assertSame($expected, $actual);
        
        $actual = $result[2]['left_value'];
        $expected = -7.85;
        $this->assertSame($expected, $actual);
        
        $actual = $result[2]['right_value'];
        $expected = -6.3;
        $this->assertSame($expected, $actual);
        
        $actual = $result[3]['left_value'];
        $expected = -6.3;
        $this->assertSame($expected, $actual);
        
        $actual = $result[3]['right_value'];
        $expected = -4.75;
        $this->assertSame($expected, $actual);
        
        $actual = $result[4]['left_value'];
        $expected = -4.75;
        $this->assertSame($expected, $actual);
        
        $actual = $result[4]['right_value'];
        $expected = -3.2;
        $this->assertSame($expected, $actual);
        
        $actual = $result[5]['left_value'];
        $expected = -3.2;
        $this->assertSame($expected, $actual);
        
        $actual = $result[5]['right_value'];
        $expected = -1.65;
        $this->assertSame($expected, $actual);
        
        $actual = $result[6]['left_value'];
        $expected = -1.65;
        $this->assertSame($expected, $actual);
        
        $actual = $result[6]['right_value'];
        $expected = -0.1;
        $this->assertSame($expected, $actual);
        
        $actual = $result[7]['left_value'];
        $expected = -0.1;
        $this->assertSame($expected, $actual);
        
        $actual = $result[7]['right_value'];
        $expected = 1.45;
        $this->assertSame($expected, $actual);
        
        $actual = $result[8]['left_value'];
        $expected = 1.45;
        $this->assertSame($expected, $actual);
        
        $actual = $result[8]['right_value'];
        $expected = 3.0;
        $this->assertSame($expected, $actual);
    }
    
    public function testCalculateIntFrequencies()
    {
        $data = [-6.4, -3, -1.2, -4.5, -0.4, -3, -3.2, -8.2, 3, 0.4, -8.1, -1.2,
                2.1, -1.2, -9, 1.2, -0.1, -1.8, -0.6, 1.2, 0, -1.2, 1.2, -9.4,
                -4.6, 0, 0.7, -4, -3.8, -4.4, -0.3, 1.3, -7, -3.7, -3.1];
        $this->stat_series->setK(8);
        $this->stat_series->setXmin(-9.4);
        $this->stat_series->setXmax(3.0);
        $this->stat_series->setC(1.55);
        $this->stat_series->setPartialIntervals();
        $this->stat_series->calculateIntFrequencies($data);
        $result = $this->stat_series->getPartIntervals();
        
        $actual = $result[1]['m_i'];
        $expected = 4;
        $this->assertSame($expected, $actual);
        
        $actual = $result[2]['m_i'];
        $expected = 2;
        $this->assertSame($expected, $actual);
    }
    
    public function testCalcMiInterval()
    {
        $statistical_series = [-6.4, -3, -1.2, -4.5, -0.4, -3, -3.2, -8.2, 3, 0.4, -8.1, -1.2,
                2.1, -1.2, -9, 1.2, -0.1, -1.8, -0.6, 1.2, 0, -1.2, 1.2, -9.4,
                -4.6, 0, 0.7, -4, -3.8, -4.4, -0.3, 1.3, -7, -3.7, -3.1];
        $interval = ['left_value' => floatval(-9.4), 'right_value' => floatval(-7.85)];
        $this->stat_series->setK(8);
        $board = false;
        $actual = $this->stat_series->calcMiInterval($statistical_series, $interval, $board);
        $expected = 4;
        $this->assertSame($expected, $actual);
    }
    
    public function addMidPartialInterval()
    {
        $this->stat_series->setK(8);
        $this->stat_series->setXmin(-9.4);
        $this->stat_series->setXmax(3.0);
        $this->stat_series->setC(1.55);
        $this->stat_series->setPartialIntervals();
        $intervals = $this->stat_series->getPartIntervals();
        $this->stat_series->addMidPartialInterval($intervals);
        $actual_intervals = $this->stat_series->getPartIntervals();
        
        $actual = $_actual_intervals[1]['mid_interval'];
        $expected = floatval(-8.625);
        $this->assertSame($expected, $actual);
        
        $actual = $_actual_intervals[2]['mid_interval'];
        $expected = floatval(-7.075);
        $this->assertSame($expected, $actual);
    }
    
    public function testAddRelativeFrequencies()
    {
        $statistical_series = [-6.4, -3, -1.2, -4.5, -0.4, -3, -3.2, -8.2, 3, 0.4, -8.1, -1.2,
                2.1, -1.2, -9, 1.2, -0.1, -1.8, -0.6, 1.2, 0, -1.2, 1.2, -9.4,
                -4.6, 0, 0.7, -4, -3.8, -4.4, -0.3, 1.3, -7, -3.7, -3.1];
        $this->stat_series->setN(35);
        $this->stat_series->setK(8);
        $this->stat_series->setXmin(-9.4);
        $this->stat_series->setXmax(3.0);
        $this->stat_series->setC(1.55);
        $this->stat_series->setPartialIntervals();
        $this->stat_series->calculateIntFrequencies($statistical_series);
        $intervals = $this->stat_series->getPartIntervals();
        $this->stat_series->addRelativeFrequencies($this->stat_series->getN(), $intervals);
        $actual_intervals = $this->stat_series->getPartIntervals();
        
        $actual = $actual_intervals[1]['relative_frequency'];
        $expected = floatval(0.11428571428571);
        $this->assertSame($expected, $actual);
        
        $actual = $actual_intervals[2]['relative_frequency'];
        $expected = floatval(0.057142857142857);
        $this->assertSame($expected, $actual);
    }
    
    
    public function testGetView()
    {
        $statistical_series = [-6.4, -3, -1.2, -4.5, -0.4, -3, -3.2, -8.2, 3, 0.4, -8.1, -1.2,
                2.1, -1.2, -9, 1.2, -0.1, -1.8, -0.6, 1.2, 0, -1.2, 1.2, -9.4,
                -4.6, 0, 0.7, -4, -3.8, -4.4, -0.3, 1.3, -7, -3.7, -3.1];
        $this->stat_series->setN(35);
        $this->stat_series->setK(8);
        $this->stat_series->setXmin(-9.4);
        $this->stat_series->setXmax(3.0);
        $this->stat_series->setC(1.55);
        $this->stat_series->setPartialIntervals();
        $this->stat_series->calculateIntFrequencies($statistical_series);
        $this->stat_series->addMidPartialInterval($this->stat_series->getPartIntervals());
        $this->stat_series->addRelativeFrequencies($this->stat_series->getN(), $this->stat_series->getPartIntervals());
        $result = $this->stat_series->getView($this->stat_series->getPartIntervals(), 'array');
        
        $actual = $result[1]['left_border'];
        $expected = floatval(-9.4);
        $this->assertSame($expected, $actual);
        
        $actual = $result[1]['right_border'];
        $expected = floatval(-7.85);
        $this->assertSame($expected, $actual);
        
        $actual = $result[1]['middle_partial_interval'];
        $expected = floatval(-8.625);
        $this->assertSame($expected, $actual);
        
        $actual = $result[1]['interval_frequency'];
        $expected = intval(4);
        $this->assertSame($expected, $actual);
        
        $actual = $result[1]['relative_frequency'];
        $expected = floatval(0.11428571428571);
        $this->assertSame($expected, $actual);
    }
    
    public function testBuildArrayOutput()
    {
        $statistical_series = [-6.4, -3, -1.2, -4.5, -0.4, -3, -3.2, -8.2, 3, 0.4, -8.1, -1.2,
                2.1, -1.2, -9, 1.2, -0.1, -1.8, -0.6, 1.2, 0, -1.2, 1.2, -9.4,
                -4.6, 0, 0.7, -4, -3.8, -4.4, -0.3, 1.3, -7, -3.7, -3.1];
        $this->stat_series->setN(35);
        $this->stat_series->setK(8);
        $this->stat_series->setXmin(-9.4);
        $this->stat_series->setXmax(3.0);
        $this->stat_series->setC(1.55);
        $this->stat_series->setPartialIntervals();
        $this->stat_series->calculateIntFrequencies($statistical_series);
        $this->stat_series->addMidPartialInterval($this->stat_series->getPartIntervals());
        $this->stat_series->addRelativeFrequencies($this->stat_series->getN(), $this->stat_series->getPartIntervals());
        $result = $this->stat_series->buildArrayOutput($this->stat_series->getPartIntervals());
        
        $actual = $result[1]['left_border'];
        $expected = floatval(-9.4);
        $this->assertSame($expected, $actual);
        
        $actual = $result[1]['right_border'];
        $expected = floatval(-7.85);
        $this->assertSame($expected, $actual);
        
        $actual = $result[1]['middle_partial_interval'];
        $expected = floatval(-8.625);
        $this->assertSame($expected, $actual);
        
        $actual = $result[1]['interval_frequency'];
        $expected = intval(4);
        $this->assertSame($expected, $actual);
        
        $actual = $result[1]['relative_frequency'];
        $expected = floatval(0.11428571428571);
        $this->assertSame($expected, $actual);
    }
    
    public function testBuildJsonOutput()
    {
        $statistical_series = [-6.4, -3, -1.2, -4.5, -0.4, -3, -3.2, -8.2, 3, 0.4, -8.1, -1.2,
                2.1, -1.2, -9, 1.2, -0.1, -1.8, -0.6, 1.2, 0, -1.2, 1.2, -9.4,
                -4.6, 0, 0.7, -4, -3.8, -4.4, -0.3, 1.3, -7, -3.7, -3.1];
        $this->stat_series->setN(35);
        $this->stat_series->setK(8);
        $this->stat_series->setXmin(-9.4);
        $this->stat_series->setXmax(3.0);
        $this->stat_series->setC(1.55);
        $this->stat_series->setPartialIntervals();
        $this->stat_series->calculateIntFrequencies($statistical_series);
        $this->stat_series->addMidPartialInterval($this->stat_series->getPartIntervals());
        $this->stat_series->addRelativeFrequencies($this->stat_series->getN(), $this->stat_series->getPartIntervals());
        $result = $this->stat_series->buildJsonOutput($this->stat_series->getPartIntervals());
        $result = json_decode($result, true);
        
        $actual = $result[1]['left_border'];
        $expected = floatval(-9.4);
        $this->assertSame($expected, $actual);
        
        $actual = $result[1]['right_border'];
        $expected = floatval(-7.85);
        $this->assertSame($expected, $actual);
        
        $actual = $result[1]['middle_partial_interval'];
        $expected = floatval(-8.625);
        $this->assertSame($expected, $actual);
        
        $actual = $result[1]['interval_frequency'];
        $expected = intval(4);
        $this->assertSame($expected, $actual);
        
        $actual = $result[1]['relative_frequency'];
        $expected = floatval(0.11428571428571);
        $this->assertSame($expected, $actual);
    }

    protected function tearDown(): void 
    {
        unset($this->stat_series);
    }
}
