<?php

namespace SaadSaif\OrderExport\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use SaadSaif\OrderExport\Action\AddExpeditedExportNote;

class AttachExpediteNote implements ObserverInterface
{
    private AddExpeditedExportNote $addExpeditedExportNote;
    private LoggerInterface $logger;

    public function __construct(
      AddExpeditedExportNote $addExpeditedExportNote,
      LoggerInterface $logger
    ) {
        $this->addExpeditedExportNote = $addExpeditedExportNote;
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        $order = $observer->getData('order');
        if (!$order) {
            return;
        }

        try {
            $this->addExpeditedExportNote->execute($order);
        } catch (LocalizedException $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
