<?php

namespace SaadSaif\OrderExport\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterface;
use SaadSaif\OrderExport\Api\OrderExportDetailsRepositoryInterface;
use SaadSaif\OrderExport\Model\ResourceModel\OrderExportDetails as OrderExportDetailsResource;
use SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterfaceFactory;
use SaadSaif\OrderExport\Model\ResourceModel\OrderExportDetails;

class OrderExportDetailsRepository implements OrderExportDetailsRepositoryInterface
{

    private OrderExportDetailsInterfaceFactory $exportDetailsFactory;
    private OrderExportDetailsResource $orderExportDetailsResource;

    public function __construct(
        OrderExportDetailsInterfaceFactory $exportDetailsFactory,
        OrderExportDetailsResource $orderExportDetailsResource
    ) {
        $this->exportDetailsFactory = $exportDetailsFactory;
        $this->orderExportDetailsResource = $orderExportDetailsResource;
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
}
