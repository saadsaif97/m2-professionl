<?php

namespace SaadSaif\OrderExport\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OrderExport extends Command
{
    /**
     * Initialization of the command.
     */
    protected function configure()
    {
        $this->setName('order-export:run');
        $this->setDescription('Exports the order to ERP');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return 0;
    }
}
