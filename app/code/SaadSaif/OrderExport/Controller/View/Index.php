<?php

namespace SaadSaif\OrderExport\Controller\View;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Controller\AbstractController\OrderViewAuthorizationInterface;
use SaadSaif\OrderExport\Model\Config;

class Index implements ActionInterface, HttpGetActionInterface
{

    private PageFactory $pageFactory;
    private RequestInterface $request;
    private ForwardFactory $resultForwardFactory;
    private OrderViewAuthorizationInterface $orderViewAuthorization;
    private OrderRepositoryInterface $orderRepository;
    private Config $config;

    public function __construct(
        PageFactory $pageFactory,
        RequestInterface $request,
        ForwardFactory $resultForwardFactory,
        OrderViewAuthorizationInterface $orderViewAuthorization,
        OrderRepositoryInterface $orderRepository,
        Config $config
    ) {
        $this->pageFactory = $pageFactory;
        $this->request = $request;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->orderViewAuthorization = $orderViewAuthorization;
        $this->orderRepository = $orderRepository;
        $this->config = $config;
    }

    /**
     * {@inheritDoc}
     */
    public function execute()
    {
        /** @var Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();

        if (!$this->config->isEnabled()) {
            return $resultForward->forward('noroute');
        }

        $orderId = (int) $this->request->getParam('order_id');
        if(!$orderId) {
            return $resultForward->forward('noroute');
        }

        try {
            $order = $this->orderRepository->get($orderId);
        } catch (\Exception $e) {
            return $resultForward->forward('noroute');
        }

        if(!$this->orderViewAuthorization->canView($order)) {
            return $resultForward->forward('noroute');
        }

        return $this->pageFactory->create();
    }
}
