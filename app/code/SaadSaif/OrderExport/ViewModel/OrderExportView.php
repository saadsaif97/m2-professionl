<?php

namespace SaadSaif\OrderExport\ViewModel;

use DateTime;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\View\Page\Config;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterface;
use SaadSaif\OrderExport\Api\Data\OrderExportDetailsInterfaceFactory;

class OrderExportView implements ArgumentInterface
{
    private $order = null;

    private RequestInterface $request;
    private OrderRepositoryInterface $orderRepository;
    private TimezoneInterface $timezone;
    private UrlInterface $urlBuilder;
    private Config $pageConfig;
    private OrderExportDetailsInterfaceFactory $orderExportDetailsInterfaceFactory;

    public function __construct(
        RequestInterface         $request,
        OrderRepositoryInterface $orderRepository,
        TimezoneInterface        $timezone,
        UrlInterface $urlBuilder,
        Config $pageConfig,
        OrderExportDetailsInterfaceFactory $orderExportDetailsInterfaceFactory
    )
    {
        $this->request = $request;
        $this->orderRepository = $orderRepository;
        $this->timezone = $timezone;
        $this->urlBuilder = $urlBuilder;
        $this->pageConfig = $pageConfig;

        $order = $this->getOrder();
        if($order) {
            $this->pageConfig->getTitle()->set(__('Order # %1', $order->getRealOrderId()));
        }
        $this->orderExportDetailsInterfaceFactory = $orderExportDetailsInterfaceFactory;
    }

    public function getOrderExportDetails(): ?OrderExportDetailsInterface
    {
        try {
            $orderExportDetails = $this->orderExportDetailsInterfaceFactory->create();
            return $orderExportDetails->setExportedAt(new \DateTime('2023-03-23'))
                ->setShipOn(new \DateTime('2023-03-25'))
                ->setMerchantNotes('Export Early')->setExportedAt(new \DateTime('2023-03-24'));
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getOrder(): ?OrderInterface
    {
        if (!$this->order) {
            $orderId = (int)$this->request->getParam('order_id');
            if (!$orderId) {
                return null;
            }

            try {
                $order = $this->orderRepository->get($orderId);
            } catch (NoSuchEntityException $e) {
                return null;
            }

            $this->order = $order;
        }

        return $this->order;
    }

    public function formatDate(DateTime $dateTime): string
    {
        return $this->timezone->formatDate($dateTime, \IntlDateFormatter::LONG);
    }

    public function getOrderViewUrl(): string
    {
        $order = $this->getOrder();
        return $this->urlBuilder->getUrl('sales/order/view',
            [
                'order_id' => (int) $order->getEntityId()
            ]
        );
    }
}
