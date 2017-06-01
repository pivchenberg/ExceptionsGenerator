<?php
/**
 * Created by PhpStorm.
 * User: pivchenberg
 * DateTime: 01.06.2017 15:07
 */

namespace Pivchenberg\ExceptionsGenerator\Generator;

class ExceptionGenerator
{
    /**
     * @var ExceptionGenItemBuilder
     */
    private $builder;

    public function __construct(ExceptionGenItemBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function generateExceptionClass(ExceptionGenItem $exceptionGenItem)
    {

    }
}