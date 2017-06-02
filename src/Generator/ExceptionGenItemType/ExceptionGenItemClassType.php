<?php
/**
 * Created by PhpStorm.
 * User: pivchenberg
 * DateTime: 01.06.2017 14:58
 */

namespace Pivchenberg\ExceptionsGenerator\Generator\ExceptionGenItemType;


class ExceptionGenItemClassType implements ExceptionGenItemType
{
    public function getGenType(): string
    {
        return 'class';
    }
}