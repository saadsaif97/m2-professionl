<?php

namespace SaadSaif\OrderExport\ViewModel;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class OrderExportDetails implements ArgumentInterface
{
    private UrlInterface $urlBuilder;
    private RequestInterface $request;

    public function __construct(
        RequestInterface $request,
        UrlInterface     $urlBuilder
    )
    {
        $this->urlBuilder = $urlBuilder;
        $this->request = $request;
    }

    public function getOrderDetailsUrl(): string
    {
        $order_id = $this->request->getParam('order_id');
        return $this->urlBuilder->getUrl('order_export/view/index',
            [
                'order_id' => (int) $order_id
            ]
        );
    }
}
