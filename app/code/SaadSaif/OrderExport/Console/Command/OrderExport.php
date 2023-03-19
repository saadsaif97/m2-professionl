<?php

namespace SaadSaif\OrderExport\Console\Command;

use SaadSaif\OrderExport\Action\ExportOrderData;
use SaadSaif\OrderExport\Model\HeaderDataFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class OrderExport extends Command
{
    const ARG_NAME_ORDER_ID = 'order-id';
    const OPT_NAME_SHIP_DATE = 'ship-date';
    const OPT_NAME_MERCHANT_NOTES = 'notes';
    private HeaderDataFactory $headerDataFactory;
    private ExportOrderData $exportOrderData;

    public function __construct(
        HeaderDataFactory $headerDataFactory,
        ExportOrderData $exportOrderData,
        string $name = null
    )
    {
        parent::__construct($name);
        $this->headerDataFactory = $headerDataFactory;
        $this->exportOrderData = $exportOrderData;
    }

    /**
     * Initialization of the command.
     */
    protected function configure()
    {
        $this->setName('order-export:run');
        $this->setDescription('Exports the order to ERP');
        $this->addArgument(
            self::ARG_NAME_ORDER_ID,
            InputArgument::REQUIRED,
            'Name of the module'
        );
        $this->addOption(
            self::OPT_NAME_SHIP_DATE,
            'd',
            InputOption::VALUE_OPTIONAL,
            'Ship date format YYYY-MM-DD'
        );
        $this->addOption(
            self::OPT_NAME_MERCHANT_NOTES,
            null,
            InputOption::VALUE_OPTIONAL,
            'Merchant notes'
        );
        parent::configure();
    }

    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $orderId = (int) $input->getArgument(self::ARG_NAME_ORDER_ID);
        $shipDate = $input->getOption(self::OPT_NAME_SHIP_DATE);
        $notes = $input->getOption(self::OPT_NAME_MERCHANT_NOTES);

        $headerData = $this->headerDataFactory->create();
        if ($shipDate) {
            $headerData->setShipDate(new \DateTime($shipDate));
        }
        if ($notes) {
            $headerData->setMerchantNotes($notes);
        }

        $result = $this->exportOrderData->execute((int) $orderId, $headerData);
        $success = $result['success'] ?? false;

        if ($success) {
            $output->writeln(__('Successfully exported order'));
        } else {
            $msg = $result['error'] ?? null;
            if ($msg == null) {
                $msg = __('Something unexpected happened');
            }
            $output->writeln($msg);
            return 1;
        }

        //$output->writeln(print_r($orderData, true));

        return 0;
    }
}
