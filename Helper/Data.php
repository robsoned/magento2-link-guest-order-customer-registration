<?php namespace Robsoned\LinkGuestOrderCustomerRegistration\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    public function logError(string $errorMessage, array $context = []){

        $this->_logger->error($errorMessage, $context);
        
    }
}