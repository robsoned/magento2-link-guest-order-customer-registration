# Magento 2 Link Guest Order to Customer Registration

This Magento 2 module links guest orders to customer accounts when a customer registers. It builds on the functionality from the [magento2-link-guest-order](https://github.com/aashan10/magento2-link-guest-order) module, which links guest orders to customer accounts at the time of order creation.

## Key Features:

* Links guest orders to the customer account automatically based on the customer's email address when they register.
* Preserves the original functionality of linking guest orders to the customer account when the order is placed.

## How It Works

When a guest places an order, Magento stores it as a guest order without associating it with a customer account. This module ensures that if the guest later registers using the same email address, their previous guest orders are automatically linked to their new customer account. This functionality also works if the customer registers after the order is placed.

## Installation

```composer require robsoned/magento2-link-guest-order-customer-registration```

```php bin/magento setup:upgrade --keep-generated```

```php bin/magento setup:di:compile```
