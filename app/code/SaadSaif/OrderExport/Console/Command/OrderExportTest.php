<?php

namespace SaadSaif\OrderExport\Console\Command;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterfaceFactory;
use SaadSaif\OrderExport\Api\OrderExportDetailsRepositoryInterface;
use SaadSaif\OrderExport\Model\ResourceModel\OrderExportDetails\CollectionFactory as OrderExportCollectionDetailsFactory;
use SaadSaif\OrderExport\Model\ResourceModel\OrderExportDetails as OrderExportDetailsResource;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OrderExportTest extends Command
{

    private OrderExportDetailsRepositoryInterface $orderExportDetailsRepository;

    public function __construct(
        OrderExportDetailsRepositoryInterface $orderExportDetailsRepository,
        string                                $name = null
    ) {
        parent::__construct($name);
        $this->orderExportDetailsRepository = $orderExportDetailsRepository;
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
     * @throws LocalizedException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $orderDetails = $this->orderExportDetailsRepository->getById(1);
        } catch (\Exception $e) {
            throw new LocalizedException(__($e->getMessage()));
        }

        $output->writeln(print_r($orderDetails->getData(), true));

        return 0;
    }
}
