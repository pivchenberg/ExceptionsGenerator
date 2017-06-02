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

    /**
     * @var string
     */
    private $documentRoot;

    /**
     * ExceptionGenerator constructor.
     * @param $namespace
     * @param $destinationPathFromRoot
     * @param null $basicInterFaceName
     */
    public function __construct($namespace, $destinationPathFromRoot, $basicInterFaceName = null)
    {
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
     */
    public function generateExceptionClass($exceptionClassName)
    {

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
}