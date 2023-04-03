<?php

namespace SaadSaif\OrderExport\Action;

use Magento\Framework\Api\SearchCriteriaBuilder;
use SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterface;
use SaadSaif\OrderExport\Api\OrderExportDetailsRepositoryInterface;

class ArchiveExportDetails
{
    const EXPIRATION_DAYS = 30;
    private OrderExportDetailsRepositoryInterface $exportDetailsRepository;
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    public function __construct(
      OrderExportDetailsRepositoryInterface $exportDetailsRepository,
      SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->exportDetailsRepository = $exportDetailsRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @throws \Exception
     */
    public function execute(): void
    {
        $exportTime = (new \DateTime())
            ->setTimezone(new \DateTimeZone('UTC'))
            ->sub(new \DateInterval('P' . self::EXPIRATION_DAYS .'D'));

        $this->searchCriteriaBuilder->addFilter(OrderExportDetailsInterface::IS_ARCHIVED, 0)
            ->addFilter(OrderExportDetailsInterface::EXPORTED_AT, $exportTime, 'lt');
        $ordersToArchive = $this->exportDetailsRepository->getList($this->searchCriteriaBuilder->create())->getItems();

        foreach ($ordersToArchive as $order)
        {
            $order->setIsArchived(true);
            $this->exportDetailsRepository->save($order);
        }
    }
}
