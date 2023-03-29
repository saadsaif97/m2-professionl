<?php

namespace SaadSaif\OrderExport\Console\Command;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\OrderRepositoryInterface;
use SaadSaif\OrderExport\Api\OrderExportDetailsRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OrderExportTest extends Command
{

    private OrderExportDetailsRepositoryInterface $orderExportDetailsRepository;
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private OrderRepositoryInterface $orderRepository;

    public function __construct(
        OrderExportDetailsRepositoryInterface $orderExportDetailsRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        OrderRepositoryInterface $orderRepository,
        string                                $name = null
    ) {
        parent::__construct($name);
        $this->orderExportDetailsRepository = $orderExportDetailsRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->orderRepository = $orderRepository;
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
            //$this->searchCriteriaBuilder->addFilter('order_id', 3);
            $searchCriteria = $this->searchCriteriaBuilder->create();
            $orderList = $this->orderRepository->getList($searchCriteria);
            foreach ($orderList->getItems() as $order) {
                $exportDetails = $order->getExtensionAttributes()->getExportDetails();
                if($exportDetails) {
                    $output->writeln(print_r($exportDetails->getData(), true));
                }
            }
        } catch (\Exception $e) {
            throw new LocalizedException(__($e->getMessage()));
        }

        return 0;
    }
}
