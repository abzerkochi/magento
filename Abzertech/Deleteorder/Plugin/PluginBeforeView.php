<?php

namespace Abzertech\Deleteorder\Plugin;

use Magento\Framework\AuthorizationInterface;
use Abzertech\Deleteorder\Helper\Data;

class PluginBeforeView
{

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var AuthorizationInterface
     */
    protected $authorization;

    /**
     * AddDeleteButton
     *
     * @param Data $helper
     * @param AuthorizationInterface $authorization
     */
    public function __construct(
        Data $helper,
        AuthorizationInterface $authorization
    ) {
        $this->helper = $helper;
        $this->authorization = $authorization;
    }

    /**
     * Before SetLayout
     * @param \Magento\Sales\Block\Adminhtml\Order\View $subject
     * @return null
     */
    public function beforeSetLayout(\Magento\Sales\Block\Adminhtml\Order\View $subject)
    {
        
        if ($this->helper->isEnabled() && $this->authorization->isAllowed('Magento_Sales::delete')) {
            $message = __('Are you sure you want to delete this order?');
            $subject->addButton(
                'delete-order',
                [
                'label' => __('Delete'),
                'title' => __('Delete'),
                'onclick' => "confirmSetLocation('{$message}', '{$subject->getDeleteUrl()}')",
                'class' => 'reset'
                    ]
            );
        }
        return null;
    }
}
