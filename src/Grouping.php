<?php

namespace swe;

/**
 * Grouping is the core class for the component application
 *
 * @author Dmytriyenko Vyacheslav <dmytriyenko.vyacheslav@gmail.com>
 */
class Grouping
{
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
}
