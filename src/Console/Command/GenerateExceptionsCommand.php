<?php
/**
 * Created by PhpStorm.
 * User: pivchenberg
 * DateTime: 01.06.2017 14:00
 */

namespace Pivchenberg\ExceptionsGenerator\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateExceptionsCommand extends Command
{
    public function configure()
    {
        $this->setName('exceptions:generate')
            ->setAliases(['e:g'])
            ->setDescription('test');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getHelper('question');

//        if(!$questionHelper->ask($input, $output, $question)) {
//            return;
//        }
//        $output->writeln('ye2');
    }

}