<?php
/**
 * Created by PhpStorm.
 * User: pivchenberg
 * DateTime: 01.06.2017 15:07
 */

namespace Pivchenberg\ExceptionsGenerator\Generator;

use Symfony\Component\Filesystem\Filesystem;

class ExceptionGenerator
{
    /**
     * @var ExceptionGenItemBuilder
     */
    private $builder;

    /**
     * @var string
     */
    private $destinationPath;

    public function __construct($namespace, $destinationPath)
    {
        $this->builder = new ExceptionGenItemBuilder($namespace);
        $this->fs = new Filesystem();
        $this->destinationPath = $destinationPath; //TODO: dir exists, document root
    }

    public function generateExceptionClass(ExceptionGenItem $exceptionGenItem)
    {

    }
}