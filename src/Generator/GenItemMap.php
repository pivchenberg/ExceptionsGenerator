<?php
/**
 * Created by PhpStorm.
 * User: pivchenberg
 * DateTime: 01.06.2017 15:21
 */

namespace Generator;


use Pivchenberg\ExceptionsGenerator\Generator\ExceptionGenItemType\ExceptionGenItemClassType;
use Pivchenberg\ExceptionsGenerator\Generator\ExceptionGenItemType\ExceptionGenItemInterfaceType;

class GenItemMap
{
    public static $map = [
        'Throwable' => [
            'type' => ExceptionGenItemInterfaceType::class,
        ],
        'Exception' => [
            'type' => ExceptionGenItemClassType::class,
            'implements' => [
                'Throwable',
            ],
        ],
        'LogicException' => [
            'type' => ExceptionGenItemClassType::class,
            'extends' => [
                'Exception',
            ],
        ],
        'BadFunctionCallException' => [
            'type' => ExceptionGenItemClassType::class,
            'extends' => [
                'LogicException',
            ],
        ],
        'BadMethodCallException' => [
            'type' => ExceptionGenItemClassType::class,
            'extends' => [
                'BadFunctionCallException',
            ],
        ],
        'DomainException' => [
            'type' => ExceptionGenItemClassType::class,
            'extends' => [
                'LogicException',
            ],
        ],
        'InvalidArgumentException' => [
            'type' => ExceptionGenItemClassType::class,
            'extends' => [
                'LogicException',
            ],
        ],
        'LengthException' => [
            'type' => ExceptionGenItemClassType::class,
            'extends' => [
                'LogicException',
            ],
        ],
        'OutOfRangeException' => [
            'type' => ExceptionGenItemClassType::class,
            'extends' => [
                'LogicException',
            ],
        ],
        'RuntimeException' => [
            'type' => ExceptionGenItemClassType::class,
            'extends' => [
                'Exception',
            ],
        ],
        'OutOfBoundsException' => [
            'type' => ExceptionGenItemClassType::class,
            'extends' => [
                'RuntimeException',
            ],
        ],
        'OverflowException' => [
            'type' => ExceptionGenItemClassType::class,
            'extends' => [
                'RuntimeException',
            ],
        ],
        'RangeException' => [
            'type' => ExceptionGenItemClassType::class,
            'extends' => [
                'RuntimeException',
            ],
        ],
        'UnderflowException' => [
            'type' => ExceptionGenItemClassType::class,
            'extends' => [
                'RuntimeException',
            ],
        ],
        'UnexpectedValueException' => [
            'type' => ExceptionGenItemClassType::class,
            'extends' => [
                'RuntimeException',
            ],
        ],
        'Error' => [
            'type' => ExceptionGenItemClassType::class,
            'implements' => [
                'Throwable',
            ],
        ],
        'ArithmeticError' => [
            'type' => ExceptionGenItemClassType::class,
            'extends' => [
                'Error',
            ],
        ],
        'AssertionError' => [
            'type' => ExceptionGenItemClassType::class,
            'extends' => [
                'Error',
            ],
        ],
        'ParseError' => [
            'type' => ExceptionGenItemClassType::class,
            'extends' => [
                'Error',
            ],
        ],
        'TypeError' => [
            'type' => ExceptionGenItemClassType::class,
            'extends' => [
                'Error',
            ],
        ],
    ];
}