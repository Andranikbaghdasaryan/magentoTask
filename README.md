# Checkout Success
## Installation
1. Place the module in `app/code/[AndMage]/[CheckoutSuccess]`.
2. Run:
 ```bash
 bin/magento setup:upgrade
 bin/magento setup:di:compile
 bin/magento setup:static-content:deploy
 bin/magento cache:clean
 bin/magento cache:flush
 ```
Configure the module via `Stores > Configuration > Sales > Checkout > Additional Info`
