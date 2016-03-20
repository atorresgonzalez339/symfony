<?php

/**
 * @copyright (c) 2015, RALF
 * @author  Livan L. Frometa Osorio <llfrometa@gmail.com>
 * @version 1.0.0
 */

namespace DashboardBundle\Grid;

use APY\DataGridBundle\Grid\Mapping\Driver\DriverInterface;
use Symfony\Component\Form\Exception\PropertyAccessDeniedException;
use APY\DataGridBundle\Grid\Rows;
use APY\DataGridBundle\Grid\Row;

class RalfPhotoColumn extends \APY\DataGridBundle\Grid\Column\Column
{
    public function getType()
    {
        return 'photo';
    }
}
