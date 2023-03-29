<?php

namespace SaadSaif\OrderExport\Plugin;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
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
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $order
     * @return OrderInterface
     * @throws LocalizedException
     */
    public function afterGet(
        OrderRepositoryInterface $subject,
        OrderInterface $order,
        int $id
    ): OrderInterface {
        $this->setExportDetails($order);
        return $order;
    }

    /**
     * @param OrderRepositoryInterface $subject
     * @param OrderSearchResultInterface $searchResult
     * @return OrderSearchResultInterface
     * @throws LocalizedException
     */
    public function afterGetList(
        OrderRepositoryInterface $subject,
        OrderSearchResultInterface $searchResult
    ): OrderSearchResultInterface
    {
        foreach ($searchResult->getItems() as $order) {
            $this->afterGet($subject, $order, $order->getEntityId());
        }
        return $searchResult;
    }

    /**
     * @param OrderInterface $order
     * @return void
     * @throws LocalizedException
     */
    private function setExportDetails(OrderInterface $order): void
    {
        $extension = $order->getExtensionAttributes();
        $exportDetails = $extension->getExportDetails();
        if ($exportDetails) {
            return;
        }

        $this->searchCriteriaBuilder->addFilter('order_id', $order->getEntityId());
        $exportDetailsList = $this->orderExportDetailsRepository->getList($this->searchCriteriaBuilder->create())->getItems();

        if (count($exportDetailsList) > 0) {
            $extension->setExportDetails(reset($exportDetailsList));
        } else {
            $exportDetails = $this->orderExportDetailsInterfaceFactory->create();
            $extension->setExportDetails($exportDetails);
        }
    }
}
