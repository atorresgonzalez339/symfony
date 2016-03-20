<?php
/**
 * @copyright (c) 2015, RALF
 * @author  Livan L. Frometa Osorio <llfrometa@gmail.com>
 * @version 1.0.0
 */

namespace DashboardBundle\Grid;

use APY\DataGridBundle\Grid\Filter;
use APY\DataGridBundle\Grid\Column\TextColumn;

class RalfTextColumn extends \APY\DataGridBundle\Grid\Column\Column
{
    
    public function __initialize(array $params){
        parent::__initialize($params);
        $this->setClass($this->getParam('class'));
    }
    
    public function isQueryValid($query){
        $result = array_filter((array) $query, "is_string");
        return !empty($result);
    }

    public function getFilters($source){
        $parentFilters = parent::getFilters($source);
        $filters = array();
        foreach($parentFilters as $filter) {
            switch ($filter->getOperator()) {
                case self::OPERATOR_ISNULL:
                    $filters[] =  new Filter(self::OPERATOR_ISNULL);
                    $filters[] =  new Filter(self::OPERATOR_EQ, '');
                    $this->setDataJunction(self::DATA_DISJUNCTION);
                    break;
                case self::OPERATOR_ISNOTNULL:
                    $filters[] =  new Filter(self::OPERATOR_ISNOTNULL);
                    $filters[] =  new Filter(self::OPERATOR_NEQ, '');
                    break;
                default:
                    $filters[] = $filter;
            }
        }

        return $filters;
    }
    
    public function renderCell($value, $row, $router){
        $value = parent::renderCell($value, $row, $router);
        return $value ?: 'false';
    }
    
    public function getDisplayedValue($value){
        return is_bool($value) ? ($value ? 1 : 0) : $value;
    }

    public function getType(){
        return 'textext';
    }
    
    protected $class;
    
    public function getClass(){
        return $this->class;
    }
    
    public function setClass($class){
        $this->class = $class;
    }
    
}
