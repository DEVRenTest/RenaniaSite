-- order limit for customers
ALTER TABLE `oc_customer` ADD `order_limit` INT( 8 ) NOT NULL DEFAULT '-1' AFTER `acr_mail_language_id` ;

--boolean flag for products
ALTER TABLE `oc_product` ADD `flag` TINYINT( 11 ) NOT NULL DEFAULT '0' AFTER `stock_status_limits` ;