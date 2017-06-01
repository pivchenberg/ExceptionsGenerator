<?php
/**
 * Created by PhpStorm.
 * User: pivchenberg
 * DateTime: 01.06.2017 14:53
 */

namespace Pivchenberg\ExceptionsGenerator\Generator;

use Pivchenberg\ExceptionsGenerator\Generator\ExceptionGenItemType\ExceptionGenItemType;

class ExceptionGenItem
{
    /**
     * @var string;
     */
    protected $namespace;

    /**
     * @var string[]
     */
    protected $use = [];

    /**
     * @var ExceptionGenItemType
     */
    protected $type;

    /**
     * @var string
     */
    protected $className;

    /**
     * @var string[]
     */
    protected $implements = [];

    /**
     * @var string[]
     */
    protected $extends = [];
}