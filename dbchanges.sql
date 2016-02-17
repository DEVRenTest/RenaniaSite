-- order limit for customers
ALTER TABLE `oc_customer` ADD `order_limit` INT( 8 ) NOT NULL DEFAULT '-1' AFTER `acr_mail_language_id` ;