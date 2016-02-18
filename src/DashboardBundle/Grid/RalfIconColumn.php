<?php

/**
 * @copyright (c) 2015, RALF
 * @author  Livan L. Frometa Osorio <llfrometa@gmail.com>
 * @version 1.0.0
 */

namespace DashboardBundle\Grid;

use \APY\DataGridBundle\Grid\Column\Column;

class RalfIconColumn extends Column
{
    
    public function __initialize(array $params)
    {
        parent::__initialize($params);

        $this->setIconSize($this->getParam('iconSize'));
        $this->setFilterable($this->getParam('filterable', false));
        $this->setSortable($this->getParam('sortable', false));
    }
    
    private $iconSize;
    
    function getIconSize(){
        return $this->iconSize;
    }
    
    function setIconSize($iconSize){
        $this->iconSize = $iconSize;
    }
    
    public function getType()
    {
        return 'icon';
    }
}
