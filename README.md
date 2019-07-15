# Magento2 Delete Order extension by Abzer

## How to Install?

Method 1: Download the files at https://github.com/abzertech/magento2-delete-order. 
Paste it under <i><magento_project_path>/app/code/</i> and run the following command.

<code>php bin/magento setup:upgrade</code>

Method 2: Install via composer [Recommend]
Run the following commands Magento root folder

<code>composer require abzertech/delete-order</code>

<code>php bin/magento setup:upgrade</code>

## How to Enable?

After installation, you can find an option to enable the extension at <i>Stores > Configuration > ABZER EXTENSIONS >
Delete Order</i>. Enable the extension and clear cache to see the delete button on order view page.

Note: The process is irreversible, so please make sure before you delete the order. The action will remove all
invoices. shipments, credit memos and transactions under the order.
