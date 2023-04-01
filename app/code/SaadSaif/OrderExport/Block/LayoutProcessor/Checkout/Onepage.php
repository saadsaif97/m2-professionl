<?php

namespace SaadSaif\OrderExport\Block\LayoutProcessor\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;
use Magento\Cms\Block\BlockByIdentifier;
use Magento\Framework\View\LayoutInterface;
use SaadSaif\OrderExport\Model\Config;

class Onepage implements LayoutProcessorInterface
{
    private Config $config;
    private LayoutInterface $layout;

    public function __construct(
        Config          $config,
        LayoutInterface $layout
    )
    {
        $this->config = $config;
        $this->layout = $layout;
    }

    /**
     * @inheritDoc
     */
    public function process($jsLayout)
    {
        if (!$this->config->isEnabled()) {
            return $jsLayout;
        }

        $deliveryMessageCMSBlock = $this->layout->createBlock(BlockByIdentifier::class);
        $deliveryMessageCMSBlock->setData('identifier', 'fulfillment-notice');
        $htmlOutput = $deliveryMessageCMSBlock->toHtml();

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['deliveryMessage']['config']['text'] = $htmlOutput;
        return $jsLayout;
    }
}
