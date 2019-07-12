<?php

namespace Abzertech\Deleteorder\Helper;

use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     *
     * @var \Magento\Sales\Model\ResourceModel\OrderFactory
     */
    private $orderFactory;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\ObjectManagerInterface
     * @param \Magento\Sales\Model\ResourceModel\OrderFactory
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Sales\Model\ResourceModel\OrderFactory $orderFactory
    ) {
        $this->objectManager = $objectManager;
        $this->orderFactory = $orderFactory;
        parent::__construct($context);
    }

    /**
     * @param null $storeId
     *
     * @return bool
     */
    public function isEnabled($storeId = null)
    {
        return $this->scopeConfig->getValue('abzer/deleteorder/active', ScopeInterface::SCOPE_STORE);
    }

    /**
     *
     * @param $orderId
     */
    public function deleteRecord($orderId)
    {
        /** @var Order $resource */
        $resource = $this->orderFactory->create();
        $connection = $resource->getConnection();
        /** delete invoice grid record */
        $connection->delete(
            $resource->getTable('sales_invoice_grid'),
            $connection->quoteInto('order_id = ?', $orderId)
        );
        /** delete shipment grid record */
        $connection->delete(
            $resource->getTable('sales_shipment_grid'),
            $connection->quoteInto('order_id = ?', $orderId)
        );
        /** delete creditmemo grid record */
        $connection->delete(
            $resource->getTable('sales_creditmemo_grid'),
            $connection->quoteInto('order_id = ?', $orderId)
        );
    }
}
