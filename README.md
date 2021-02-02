## Main Functionalities
The Donation Module 

## Installation
- if you have a .zip file of the module place it in the app/code
- enable to module and run setup upgrade
\* = in production please use the `--keep-generated` option

### Type 2: Composer

 - Make the module available in a composer repository for example:

 - Install the module composer by running `composer require maneza/module-donation`
 - enable the module by running `php bin/magento module:enable Maneza_Donation`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration

 - enable_module (donation/enable/enable_module)


## Specifications

 - Cronjob
	- maneza_donation_scheduledonation

 - Cache
	- CacheDonation - cachedonation_cache_tag > Maneza\Donation\Model\Cache\CacheDonation

 - Console Command
	- donations

 - Block
	- Donation > donation.phtml


## Attributes

 - Customer - is_active (is_active)


