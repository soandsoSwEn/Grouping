<?php

namespace swe\tests;

use PHPUnit\Framework\TestCase;
use swe\Grouping;


class GroupingTest extends TestCase
{
    private $grouping;
    
    protected function setUp(): void
    {
        $this->grouping = new Grouping();
    }
    
    public function testBuildGss()
    {
        $data = [-6.4, -3, -1.2, -4.5, -0.4, -3, -3.2, -8.2, 3, 0.4, -8.1, -1.2,
                2.1, -1.2, -9, 1.2, -0.1, -1.8, -0.6, 1.2, 0, -1.2, 1.2, -9.4,
                -4.6, 0, 0.7, -4, -3.8, -4.4, -0.3, 1.3, -7, -3.7, -3.1];
        $this->grouping->putSource($data);
        $result = $this->grouping->buildGss('array');
        
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
        
        
        $result = $this->grouping->buildGss('json');
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
        unset($this->grouping);
    }
}
