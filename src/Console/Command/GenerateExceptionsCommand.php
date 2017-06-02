<?php
/**
 * Created by PhpStorm.
 * User: pivchenberg
 * DateTime: 01.06.2017 14:00
 */

namespace Pivchenberg\ExceptionsGenerator\Console\Command;

use Pivchenberg\ExceptionsGenerator\Generator\ExceptionGenerator;
use Pivchenberg\ExceptionsGenerator\Generator\ExceptionGenItemBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class GenerateExceptionsCommand extends Command
{
    public function configure()
    {
        $this->setName('exceptions:generate')
            ->setAliases(['e:g'])
            ->setDescription('no description') //TODO: description
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getHelper('question');

        $guessedDocumentRoot = ExceptionGenerator::getDocumentRoot();
        $documentRootQuestion = new Question(
            "Please enter full project root [{$guessedDocumentRoot}]: ",
            $guessedDocumentRoot
        );
        $documentRoot = $questionHelper->ask($input, $output, $documentRootQuestion);

        $namespaceQuestion = new Question(
            'Please enter the namespace of exceptions [AppBundle\\Exception]: ',
            'AppBundle\\Exception'
        );
        $namespace = $questionHelper->ask($input, $output, $namespaceQuestion);

        $destinationPathQuestion = new Question(
            'Please enter path from root directory of the project to destination folder [src/AppBundle/Exception/]: ',
            'src/AppBundle/Exception/'
        );
        $destinationPath = $questionHelper->ask($input, $output, $destinationPathQuestion);

        $basicInterfaceName = ExceptionGenItemBuilder::BASIC_INTERFACE_DEFAULT_NAME;
        $basicInterfaceNameQuestion = new Question(
            "Please enter basic interface name [{$basicInterfaceName}]: ",
            $basicInterfaceName
        );
        $basicInterfaceName = $questionHelper->ask($input, $output, $basicInterfaceNameQuestion);

        $generator = new ExceptionGenerator($namespace, $documentRoot, $destinationPath, $basicInterfaceName);

        if (!$generator->isBasicInterfaceExists()) {
            $generator->generateBasicInterface();
            $output->writeln('Basic interface created.');
        } else {
            $output->writeln('Found already created basic interface.');
        }

        foreach ($generator->getMap() as $class => $map) {
            $question = new ConfirmationQuestion("Generate `{$class}` class? [y]: ", true);
            $generate = $questionHelper->ask($input, $output, $question);

            if($generate) {
                $generator->generateExceptionClass($class);
            }
        }
    }

}