<?php

namespace SaadSaif\OrderExport\Api;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

interface OrderExportDetailsRepositoryInterface
{
    /**
     * @throws CouldNotSaveException
     */
    public function save(\SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterface $details): \SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterface;

    /**
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getById(int $detailsId): \SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterface;

    /**
     * @throws CouldNotDeleteException
     */
    public function delete(\SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterface $details): bool;

    /**
     * @throws CouldNotDeleteException
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $detailsId): bool;
}
