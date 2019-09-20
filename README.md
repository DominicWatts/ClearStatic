# Clear Static #

Console script to clear static content.  Will clear both frontend and backend static content in a single command. Ideal for pushing through knockout html changes.

# Install instructions #

`composer require dominicwatts/clearstatic`

`php bin/magento setup:upgrade`

`php bin/magento setup:di:compile`

# Usage instructions #

`xigen:clearstatic:clear [-c|--clear-static-content]`

`php bin/magento xigen:clearstatic:clear -c`

or

`php bin/magento xigen:clearstatic:clear --clear-static-content`

Then generate static content using standard procedure.