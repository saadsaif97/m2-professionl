<?php

namespace SaadSaif\OrderExport\Api;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use SaadSaif\OrderExport\Api\Data\OrderExportDetailsSearchResultsInterface;

interface OrderExportDetailsRepositoryInterface
{
    /**
     * @param \SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterface $details
     * @return \SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterface
     * @throws CouldNotSaveException
     */
    public function save(\SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterface $details): \SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterface;

    /**
     * @param int $detailsId
     * @return \SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterface
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getById(int $detailsId): \SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterface;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \SaadSaif\OrderExport\Api\Data\OrderExportDetailsSearchResultsInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria);

    /**
     * @param \SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterface $details
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(\SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterface $details): bool;

    /**
     * @param int $detailsId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $detailsId): bool;
}
