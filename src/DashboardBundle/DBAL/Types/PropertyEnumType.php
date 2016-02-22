<?php
namespace DashboardBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

final class PropertyEnumType extends AbstractEnumType {

  const HOUSE   = 'HOUSE';
  const APARTMENT = 'APARTMENT';
  const CONDO   = 'CONDO';
  const TOWNHOME = 'TOWNHOME';
  const MANUFACTURED = 'MANUFACTURED';
  const LOST_LAND = 'LOST_LAND';

  protected static $choices = [
    self::HOUSE    => 'House',
    self::APARTMENT => 'Apartment',
    self::CONDO => 'Condo/co-ops',
    self::TOWNHOME => 'Townhome',
    self::MANUFACTURED => 'Manufactured',
    self::LOST_LAND => 'Lost/Land'
  ];
}