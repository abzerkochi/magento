<?php

namespace Abzertech\Deleteorder\Controller\Adminhtml\Order;

use Exception;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Controller\Adminhtml\Order;
use Abzertech\Deleteorder\Helper\Data;

class Delete extends Order
{

    public function execute()
    {

        $resultRedirect = $this->resultRedirectFactory->create();
        $helper = $this->_objectManager->get(Data::class);
        $order = $this->_initOrder();
        if ($order) {
            try {
                /** delete order */
                $this->orderRepository->delete($order);
                /** delete order data on grid report data related */
                $helper->deleteRecord($order->getId());
                $this->messageManager->addSuccessMessage(__('The order has been deleted.'));
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('sales/order/view', ['order_id' => $order->getId()]);
            } catch (Exception $e) {
                $message = __('An error occurred while deleting the order. Please try again later.');
                $this->messageManager->addErrorMessage($message);
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                return $resultRedirect->setPath('sales/order/view', ['order_id' => $order->getId()]);
            }
        }
        return $resultRedirect->setPath('sales/*/');
    }
}
