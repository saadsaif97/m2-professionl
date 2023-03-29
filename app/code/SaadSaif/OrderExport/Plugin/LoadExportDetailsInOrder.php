<?php

namespace SaadSaif\OrderExport\Plugin;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterface;
use SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterfaceFactory;
use SaadSaif\OrderExport\Api\OrderExportDetailsRepositoryInterface;

class LoadExportDetailsInOrder
{
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private OrderExportDetailsInterfaceFactory $orderExportDetailsInterfaceFactory;
    private OrderExportDetailsRepositoryInterface $orderExportDetailsRepository;

    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        OrderExportDetailsInterfaceFactory $orderExportDetailsInterfaceFactory,
        OrderExportDetailsRepositoryInterface $orderExportDetailsRepository
    ) {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->orderExportDetailsInterfaceFactory = $orderExportDetailsInterfaceFactory;
        $this->orderExportDetailsRepository = $orderExportDetailsRepository;
    }

    /**
     * @throws LocalizedException
     */
    public function afterGet(
        OrderRepositoryInterface $subject,
        OrderInterface $order,
        int $id
    ): OrderInterface {
        $extension = $order->getExtensionAttributes();
        $exportDetails = $extension->getExportDetails();
        if ($exportDetails) {
            return $order;
        }

        $orderId = $order->getEntityId();
        $this->searchCriteriaBuilder->addFilter('order_id', $orderId);
        $exportDetailsList = $this->orderExportDetailsRepository->getList($this->searchCriteriaBuilder->create())->getItems();

        if (count($exportDetailsList) > 0) {
            $extension->setExportDetails(reset($exportDetailsList));
        } else {
            $exportDetails = $this->orderExportDetailsInterfaceFactory->create();
            $extension->setExportDetails($exportDetails);
        }

        return $order;
    }
}
