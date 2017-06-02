<?php
/**
 * Created by PhpStorm.
 * User: pivchenberg
 * DateTime: 01.06.2017 15:07
 */

namespace Pivchenberg\ExceptionsGenerator\Generator;

use Pivchenberg\ExceptionsGenerator\Exception\LogicException;
use Pivchenberg\ExceptionsGenerator\Exception\RuntimeException;
use Symfony\Component\Filesystem\Filesystem;

class ExceptionGenerator
{
    const PHP_EXTENSION = '.php';

    const GENERATE_PATTERN = <<<EOD
<?php

#NAMESPACE##USE#
/**
 * Auto-generated code
 */
#TYPE# #CLASS_NAME##EXTENDS_IMPLEMENTS#
{

}

EOD;


    /**
     * @var ExceptionGenItemBuilder
     */
    private $builder;

    /**
     * @var string
     */
    private $destinationPath;

    /**
     * @var string
     */
    private $documentRoot;

    /**
     * @var bool
     */
    private $isBasicInterfaceExists = false;

    /**
     * ExceptionGenerator constructor.
     * @param $namespace
     * @param $destinationPathFromRoot
     * @param null $basicInterFaceName
     */
    public function __construct($namespace, $destinationPathFromRoot, $basicInterFaceName = null)
    {
        // TODO: maybe remember $namespace and $destinationPathFromRoot?
        $arNamespace = self::pathToArray($namespace);
        $namespace = self::arrayToNamespace($arNamespace);

        if (!empty($basicInterFaceName))
            $this->builder = new ExceptionGenItemBuilder($namespace, $basicInterFaceName);
        else
            $this->builder = new ExceptionGenItemBuilder($namespace);
        $this->fs = new Filesystem();
        $this->documentRoot = self::getDocumentRoot(__DIR__);

        $explodedDocumentRoot = self::pathToArray($this->documentRoot);
        $explodedDestinationPath = self::pathToArray($destinationPathFromRoot);
        $destinationPath = self::arrayToPath(array_merge($explodedDocumentRoot, $explodedDestinationPath));
        $this->destinationPath = $destinationPath;
    }

    /**
     * @param $exceptionClassName
     * @return string
     * @throws \Exception
     */
    public function generateExceptionClass($exceptionClassName)
    {
        //check target dir
        if (!$this->fs->exists($this->destinationPath))
            throw new RuntimeException("target `{$this->destinationPath}` directory does not exists");

        // check basic interface
        if (!$this->isBasicInterfaceExists()) {
            $this->generateBasicInterface();
        }

        $exceptionGenItem = $this->builder->build($exceptionClassName);
        return $this->generate($exceptionGenItem);
    }

    protected function isBasicInterfaceExists()
    {
        if(!$this->isBasicInterfaceExists) {
            $basicInterfacePath = $this->destinationPath . DIRECTORY_SEPARATOR
                . $this->builder->basicInterfaceName . self::PHP_EXTENSION;

            $this->isBasicInterfaceExists = $this->fs->exists($basicInterfacePath);
        }

        return $this->isBasicInterfaceExists;
    }

    protected function generateBasicInterface()
    {
        $basicInterface = $this->builder->buildBasicInterface();
        $this->generate($basicInterface);
    }

    /**
     * @param ExceptionGenItem $exceptionGenItem
     * @return string
     */
    protected function generate(ExceptionGenItem $exceptionGenItem)
    {
        $pattern = self::GENERATE_PATTERN;
        $strNamespace = !empty($exceptionGenItem->getNamespace())
            ? 'namespace ' . $exceptionGenItem->getNamespace() . ';' . PHP_EOL
            : '';
        $pattern = str_replace('#NAMESPACE#', $strNamespace, $pattern);

        $arUse = $exceptionGenItem->getUse();
        $strUse = '';
        if (!empty($arUse)) {
            $strUse .= PHP_EOL;
            foreach ($arUse as $useItem) {
                $strUse .= 'use ' . $useItem . ';' . PHP_EOL;
            }
        }

        $pattern = str_replace('#USE#', $strUse, $pattern);

        $pattern = str_replace('#TYPE#', $exceptionGenItem->getType()->getGenType(), $pattern);

        $pattern = str_replace('#CLASS_NAME#', $exceptionGenItem->getClassName(), $pattern);

        $strExtends = '';
        $arExtends = $exceptionGenItem->getExtends();
        if (!empty($arExtends))
            $strExtends = ' extends ' . implode(', ', $arExtends);

        $strImplements = '';
        $arImplements = $exceptionGenItem->getImplements();
        if(!empty($arImplements))
            $strImplements = ' implements ' . implode(', ', $arImplements);

        $pattern = str_replace('#EXTENDS_IMPLEMENTS#', $strExtends . $strImplements, $pattern);

        $filePath = $this->destinationPath
            . DIRECTORY_SEPARATOR . $exceptionGenItem->getClassName() . self::PHP_EXTENSION;

        if(!file_exists($filePath)) {
            $this->fs->dumpFile($filePath, $pattern);
        } else {
            $newFile = $this->destinationPath
                . DIRECTORY_SEPARATOR . '~' . $exceptionGenItem->getClassName() . self::PHP_EXTENSION;
            $this->fs->copy($filePath, $newFile);
            $this->fs->dumpFile($filePath, $pattern);
        }

        return $filePath;
    }

    /**
     * @param $path
     * @param int $depth
     * @return string
     */
    static public function getDocumentRoot($path, $depth = 10)
    {
        $guessedDocumentRoot = self::guessDocumentRoot($path, $depth);
        if (empty($guessedDocumentRoot)) {
            $exploded = self::pathToArray($path);
            $guessedDocumentRoot = self::arrayToPath(array_splice($exploded, 3));
        }

        return $guessedDocumentRoot;
    }

    /**
     * @param $path
     * @param $depth
     * @return string
     */
    protected static function guessDocumentRoot($path, $depth): string
    {
        $exploded = self::pathToArray($path);

        if ($depth > 0 && !empty($exploded)) {
            array_pop($exploded);
            $path = self::arrayToPath($exploded);
            if (self::isComposerJsonFileExists($path)) {
                return $path;
            } else {
                return self::guessDocumentRoot($path, --$depth);
            }
        } else {
            return "";
        }
    }

    /**
     * @param $path
     * @return bool
     */
    static protected function isComposerJsonFileExists($path)
    {
        return file_exists($path . DIRECTORY_SEPARATOR . 'composer.json');
    }

    /**
     * @param $path
     * @return array|ø
     */
    static protected function pathToArray($path)
    {
        return preg_split('/[\/\\\\]+/', $path, -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * @param array $explodedPath
     * @return string
     */
    static protected function arrayToPath(array $explodedPath)
    {
        return implode(DIRECTORY_SEPARATOR, $explodedPath);
    }

    /**
     * @param array $explodedPath
     * @return string
     */
    static protected function arrayToNamespace(array $explodedPath)
    {
        return implode('\\', $explodedPath);
    }

    public function getMap()
    {
        return $this->builder->getMap();
    }
}