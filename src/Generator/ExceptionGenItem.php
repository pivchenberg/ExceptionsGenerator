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

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     * @return $this
     */
    public function setNamespace(string $namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getUse(): array
    {
        return $this->use;
    }

    /**
     * @param \string[] $use
     * @return $this
     */
    public function setUse(array $use)
    {
        $this->use = $use;

        return $this;
    }

    /**
     * @return ExceptionGenItemType
     */
    public function getType(): ExceptionGenItemType
    {
        return $this->type;
    }

    /**
     * @param ExceptionGenItemType $type
     * @return $this
     */
    public function setType(ExceptionGenItemType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @param string $className
     * @return $this
     */
    public function setClassName(string $className)
    {
        $this->className = $className;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getImplements(): array
    {
        return $this->implements;
    }

    /**
     * @param \string[] $implements
     * @return $this
     */
    public function setImplements(array $implements)
    {
        $this->implements = $implements;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getExtends(): array
    {
        return $this->extends;
    }

    /**
     * @param \string[] $extends
     * @return $this
     */
    public function setExtends(array $extends)
    {
        $this->extends = $extends;

        return $this;
    }

    public function isImplements()
    {
        return !empty($this->implements);
    }

    public function isExtends()
    {
        return !empty($this->extends);
    }
}