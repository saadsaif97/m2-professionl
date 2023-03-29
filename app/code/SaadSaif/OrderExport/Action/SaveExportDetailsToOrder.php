<?php
declare(strict_types=1);

namespace SaadSaif\OrderExport\Action;

use Magento\Sales\Api\Data\OrderInterface;
use SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterface;
use SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterfaceFactory;
use SaadSaif\OrderExport\Api\OrderExportDetailsRepositoryInterface;
use SaadSaif\OrderExport\Model\HeaderData;
use Magento\Framework\Exception\CouldNotSaveException;

class SaveExportDetailsToOrder
{
    /** @var OrderExportDetailsInterfaceFactory */
    private $exportDetailsFactory;
    /** @var OrderExportDetailsRepositoryInterface */
    private $exportDetailsRepository;

    public function __construct(
        OrderExportDetailsInterfaceFactory $exportDetailsFactory,
        OrderExportDetailsRepositoryInterface $exportDetailsRepository
    ) {
        $this->exportDetailsFactory = $exportDetailsFactory;
        $this->exportDetailsRepository = $exportDetailsRepository;
    }

    /**
     * @throws CouldNotSaveException
     */
    public function execute(OrderInterface $order, HeaderData $headerData, array $results): void
    {

        $extension = $order->getExtensionAttributes();
        $exportDetails = $extension->getExportDetails();

        if(!$exportDetails) {
            /** @var OrderExportDetailsInterface $exportDetails */
            $exportDetails = $this->exportDetailsFactory->create();
            $exportDetails->setOrderId((int) $order->getEntityId());
            $extension->setExportDetails($exportDetails);
        }

        $success = $results['success'] ?? false;
        if ($success) {
            $time = (new \DateTime())->setTimezone(new \DateTimeZone('UTC'));
            $exportDetails->setExportedAt($time);
        }

        if ($merchantNotes = $headerData->getMerchantNotes()) {
            $exportDetails->setMerchantNotes($merchantNotes);
        }
        if ($shipOn = $headerData->getShipDate()) {
            $exportDetails->setShipOn($shipOn);
        }

        $this->exportDetailsRepository->save($exportDetails);
    }
}
