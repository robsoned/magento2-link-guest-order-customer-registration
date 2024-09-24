<?php

namespace Robsoned\LinkGuestOrderCustomerRegistration\Observer;

use Magento\Customer\Model\Customer;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactoryInterface as OrderCollectionFactoryInterface;
use Magento\Sales\Model\Order;
use Aashan\LinkGuestOrder\Helper\OrderLinkHelper;
use Robsoned\LinkGuestOrderCustomerRegistration\Helper\Data;

class LinkGuestOrders implements ObserverInterface
{
    private $orderCollectionFactory;    
    private $orderLinkHelper;
    private $helper;

    public function __construct(
        OrderCollectionFactoryInterface $orderCollectionFactory,
        OrderLinkHelper $orderLinkHelper,
        Data $helper
    ) {
        $this->orderCollectionFactory = $orderCollectionFactory;        
        $this->orderLinkHelper = $orderLinkHelper;
        $this->helper = $helper;
    }

    public function execute(Observer $observer)
    {

        try {
            $this->linnkGuestOrdersToCustomer($observer);
        } catch (\Throwable $e) {
            $this->HandleException($e);
        }

    }


    private function linnkGuestOrdersToCustomer(Observer $observer){

        /** @var Customer $customer */
        $customer = $observer->getEvent()->getData('customer');

        $email = $customer->getEmail();    

        $guestOrders = $this->getGuestOrdersByEmail($email);

        foreach ($guestOrders as $order) {
            $this->linkOrderToCustomer($order);
        }
    }

    private function HandleException(\Throwable $e)
    {
        $errorMessage = __('Error while linking guest orders to customer: ') . $e->getMessage();

        $context = [
            'exception' => $e
        ];

        $this->helper->logError($errorMessage, $context);
    }

    private function getGuestOrdersByEmail($email)
    {
        $collection = $this->orderCollectionFactory->create()
            ->addFieldToFilter('customer_email', $email)
            ->addFieldToFilter('customer_id', ['null' => true]);

        return $collection;
    }

    private function linkOrderToCustomer(Order $order)
    {
        $this->orderLinkHelper->linkOrderToCustomer($order);
    }
}