<?php

namespace SaadSaif\OrderExport\Action;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\Data\OrderInterface;
use Psr\Log\LoggerInterface;
use SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterface;
use SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterfaceFactory;
use SaadSaif\OrderExport\Api\OrderExportDetailsRepositoryInterface;
use SaadSaif\OrderExport\Model\Config;

class AddExpeditedExportNote
{
    private Config $config;
    private GetOrderExportItems $getOrderExportItems;
    private OrderExportDetailsRepositoryInterface $orderExportDetailsRepository;
    private OrderExportDetailsInterfaceFactory $orderExportDetailsInterfaceFactory;
    private LoggerInterface $logger;

    public function __construct(
        Config                                $config,
        GetOrderExportItems                   $getOrderExportItems,
        OrderExportDetailsRepositoryInterface $orderExportDetailsRepository,
        OrderExportDetailsInterfaceFactory    $orderExportDetailsInterfaceFactory,
        LoggerInterface                       $logger
    )
    {
        $this->config = $config;
        $this->getOrderExportItems = $getOrderExportItems;
        $this->orderExportDetailsRepository = $orderExportDetailsRepository;
        $this->orderExportDetailsInterfaceFactory = $orderExportDetailsInterfaceFactory;
        $this->logger = $logger;
    }

    /**
     * @throws LocalizedException
     */
    public function execute(OrderInterface $order): void
    {
        if (!$this->config->isEnabled()) {
            return;
        }

        $expeditedSkuList = $this->config->getExpeditedSKUList();
        $expeditedSkuMessage = $this->config->getExpeditedMessage();
        if (empty($expeditedSkuMessage) || empty($expeditedSkuList)) {
            return;
        }

        $expedited = false;
        foreach ($this->getOrderExportItems->execute($order) as $orderItem) {
            $isExpeditedItem = in_array($orderItem->getSku(), $expeditedSkuList);
            if ($isExpeditedItem) {
                $expedited = true;
                break;
            }
        }

        if ($expedited) {
            try {
                $extAttributes = $order->getExtensionAttributes();
                /** @var OrderExportDetailsInterface $exportDetails */
                $exportDetails = $extAttributes->getExportDetails();
                if (!$exportDetails) {
                    $exportDetails = $this->orderExportDetailsInterfaceFactory->create();
                    $extAttributes->setExportDetails($exportDetails);
                }

                $exportDetails->setOrderId((int)$order->getEntityId());
                $exportDetails->setMerchantNotes($expeditedSkuMessage);
                $this->orderExportDetailsRepository->save($exportDetails);
            } catch (CouldNotSaveException $e) {
                $this->logger->error($e->getMessage());
                // TODO Re-try logic or error e-mail?
                throw new LocalizedException(__('Expedited note could note be saved for order %1', $order->getIncrementId()));
            }
        }
    }
}
