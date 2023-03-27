<?php

namespace SaadSaif\OrderExport\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterface;
use SaadSaif\OrderExport\Api\Data\OrderExportDetailsSearchResultsInterface;
use SaadSaif\OrderExport\Api\Data\OrderExportDetailsSearchResultsInterfaceFactory;
use SaadSaif\OrderExport\Api\OrderExportDetailsRepositoryInterface;
use SaadSaif\OrderExport\Model\ResourceModel\OrderExportDetails as OrderExportDetailsResource;
use SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterfaceFactory;
use SaadSaif\OrderExport\Model\ResourceModel\OrderExportDetails;
use SaadSaif\OrderExport\Model\ResourceModel\OrderExportDetails\Collection;
use SaadSaif\OrderExport\Model\ResourceModel\OrderExportDetails\CollectionFactory;

class OrderExportDetailsRepository implements OrderExportDetailsRepositoryInterface
{

    private OrderExportDetailsInterfaceFactory $exportDetailsFactory;
    private OrderExportDetailsResource $orderExportDetailsResource;
    private CollectionFactory $collectionFactory;
    private CollectionProcessorInterface $collectionProcessor;
    private OrderExportDetailsSearchResultsInterfaceFactory $orderExportDetailsSearchResultsInterfaceFactory;

    public function __construct(
        OrderExportDetailsInterfaceFactory $exportDetailsFactory,
        OrderExportDetailsResource $orderExportDetailsResource,
        CollectionFactory $collectionFactory,
        OrderExportDetailsSearchResultsInterfaceFactory $orderExportDetailsSearchResultsInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->exportDetailsFactory = $exportDetailsFactory;
        $this->orderExportDetailsResource = $orderExportDetailsResource;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->orderExportDetailsSearchResultsInterfaceFactory = $orderExportDetailsSearchResultsInterfaceFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function save(OrderExportDetailsInterface $details): OrderExportDetailsInterface
    {
        try {
            $this->orderExportDetailsResource->save($details);
            return $details;
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getById(int $detailsId): OrderExportDetailsInterface
    {
        $details = $this->exportDetailsFactory->create();
        $this->orderExportDetailsResource->load($details, $detailsId);

        if (!$details->getId()) {
            throw new NoSuchEntityException(__("The order export details could not be found"));
        }

        return $details;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(OrderExportDetailsInterface $details): bool
    {
        try {
            $this->orderExportDetailsResource->delete($details);
            return true;
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function deleteById(int $detailsId): bool
    {
        return $this->delete($this->getById($detailsId));
    }

    /**
     * {@inheritDoc}
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        /** @var  Collection $collection */
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->orderExportDetailsSearchResultsInterfaceFactory->create();
        $searchResults = $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
