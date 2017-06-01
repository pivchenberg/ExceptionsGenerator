<?php
/**
 * Created by PhpStorm.
 * User: pivchenberg
 * DateTime: 01.06.2017 13:53
 */

namespace Pivchenberg\ExceptionsGenerator\Console;

use Pivchenberg\ExceptionsGenerator\Console\Command\GenerateExceptionsCommand;
use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication
{
    const NAME = 'Exceptions Generator Console Application';
    const VERSION = '1.0';

    public function __construct()
    {
        parent::__construct(static::NAME, static::VERSION);
        $this->add(new GenerateExceptionsCommand());
    }
}