<?php

namespace SaadSaif\OrderExport\Api;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterface;

interface OrderExportDetailsRepositoryInterface
{
    /**
     * @throws CouldNotSaveException
     */
    public function save(OrderExportDetailsInterface $details): OrderExportDetailsInterface;

    /**
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getById(int $detailsId): OrderExportDetailsInterface;

    /**
     * @throws CouldNotDeleteException
     */
    public function delete(OrderExportDetailsInterface $details): bool;

    /**
     * @throws CouldNotDeleteException
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $detailsId): bool;
}
