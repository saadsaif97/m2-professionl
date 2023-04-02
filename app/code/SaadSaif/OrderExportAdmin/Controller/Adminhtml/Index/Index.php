<?php
declare(strict_types = 1);

namespace SaadSaif\OrderExportAdmin\Controller\Adminhtml\Index;

use Magento\Backend\App\Action as BackendAction;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index extends BackendAction implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'SaadSaif_OrderExport::OrderExport';

    /**
     * @var PageFactory
     */
    private $pageResultFactory;

    public function __construct(
        Context $context,
        PageFactory $pageResultFactory
    ) {
        parent::__construct($context);
        $this->pageResultFactory = $pageResultFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        /** @var Page $result */
        $result = $this->pageResultFactory->create();
        $result->setActiveMenu('SaadSaif_OrderExportAdmin::order_export')
            ->getConfig()->getTitle()->prepend(__('Order Export'));
        return $result;
    }
}
