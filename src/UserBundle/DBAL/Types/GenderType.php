<?php
namespace UserBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

final class GenderType extends AbstractEnumType {
    const MALE   = 'MALE';
    const FEMALE = 'FEMALE';

    protected static $choices = [
        self::MALE    => 'Male',
        self::FEMALE => 'Female'
    ];
}