<?php

namespace SaadSaif\OrderExport\Console\Command;

use SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterfaceFactory;
use SaadSaif\OrderExport\Model\ResourceModel\OrderExportDetails\CollectionFactory as OrderExportCollectionDetailsFactory;
use SaadSaif\OrderExport\Model\ResourceModel\OrderExportDetails as OrderExportDetailsResource;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OrderExportTest extends Command
{
    private OrderExportDetailsInterfaceFactory $orderExportDetailsInterfaceFactory;
    private OrderExportDetailsResource $orderExportDetailsResource;
    private OrderExportCollectionDetailsFactory $orderExportDetailsCollectionFactory;

    public function __construct(
        OrderExportCollectionDetailsFactory $orderExportDetailsCollectionFactory,
        OrderExportDetailsInterfaceFactory    $orderExportDetailsInterfaceFactory,
        OrderExportDetailsResource            $orderExportDetailsResource,
        string                                $name = null
    ) {
        parent::__construct($name);
        $this->orderExportDetailsInterfaceFactory = $orderExportDetailsInterfaceFactory;
        $this->orderExportDetailsResource = $orderExportDetailsResource;
        $this->orderExportDetailsCollectionFactory = $orderExportDetailsCollectionFactory;
    }

    /**
     * Initialization of the command.
     */
    protected function configure()
    {
        $this->setName('order-export:test');
        $this->setDescription('test the order exports');
        parent::configure();
    }

    /**
     * CLI command description.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
//        $exportDetails = $this->orderExportDetailsInterfaceFactory->create();
//        $this->orderExportDetailsResource->load($exportDetails, 1);

        $orderExportCollection = $this->orderExportDetailsCollectionFactory->create();

        foreach ($orderExportCollection as $exportDetails) {
            $output->writeln(print_r($exportDetails->getData(), true));
        }

        return 0;
    }
}
