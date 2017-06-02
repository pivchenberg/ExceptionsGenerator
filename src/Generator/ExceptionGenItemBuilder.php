<?php
/**
 * Created by PhpStorm.
 * User: pivchenberg
 * DateTime: 01.06.2017 15:21
 */

namespace Pivchenberg\ExceptionsGenerator\Generator;

use Pivchenberg\ExceptionsGenerator\Generator\ExceptionGenItemType\ExceptionGenItemClassType;
use Pivchenberg\ExceptionsGenerator\Generator\ExceptionGenItemType\ExceptionGenItemInterfaceType;

class ExceptionGenItemBuilder
{
    /**
     * @var string
     */
    public $basicInterfaceName;

    /**
     * @var array
     */
    protected $map = [];

    /**
     * @var string
     */
    protected $namespace;

    /**
     * ExceptionGenItemBuilder constructor.
     * @param $namespace
     * @param $basicInterfaceName
     */
    public function __construct($namespace, $basicInterfaceName = 'ExceptionInterface')
    {
        $this->namespace = $namespace;
        $this->basicInterfaceName = $basicInterfaceName;
        $this->buildMap();
    }

    /**
     * @param $exceptionType
     * @return ExceptionGenItem
     * @throws \Exception
     */
    public function build($exceptionType)
    {
        if (!isset($this->map[$exceptionType])) {
            throw new \Exception('There is no such type of exception'); //TODO: wrong exception type
        }

        $exceptionMap = $this->map[$exceptionType];
        $exceptionGetItem = new ExceptionGenItem();
        $exceptionGetItem
            ->setNamespace($this->namespace)
            ->setType(new $exceptionMap['type'])
            ->setClassName($exceptionType);

        if (isset($exceptionMap['implements']) && is_array($exceptionMap['implements']))
            $exceptionGetItem->setImplements($exceptionMap['implements']);

        if (isset($exceptionMap['extends']) && is_array($exceptionMap['extends']))
            $exceptionGetItem->setExtends($exceptionMap['extends']);

        // use block
        $use = [];
        foreach ($exceptionGetItem->getImplements() as $useItem) {
            $use[] = $this->namespace . '\\' . $useItem;
        }
        $exceptionGetItem->setUse($use);

        return $exceptionGetItem;
    }

    protected function buildMap()
    {
        foreach (get_declared_classes() as $class) {
            $reflection = new \ReflectionClass($class);
            if ($reflection->implementsInterface(\Throwable::class)) {
                $this->map[$class] = [
                    'type' => ExceptionGenItemClassType::class,
                    'extends' => [ '\\' . $class],
                    'implements' => [$this->basicInterfaceName],
                ];
            }
        }
    }

    /**
     * @return ExceptionGenItem
     */
    public function buildBasicInterface()
    {
        $exceptionGenItem = new ExceptionGenItem();
        $exceptionGenItem->setClassName($this->basicInterfaceName)
            ->setType(new ExceptionGenItemInterfaceType())
            ->setNamespace($this->namespace);

        return $exceptionGenItem;
    }

    /**
     * @return array
     */
    public function getMap(): array
    {
        return $this->map;
    }
}