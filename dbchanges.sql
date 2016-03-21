-- order limit for customers
ALTER TABLE `oc_customer` ADD `order_limit` INT( 8 ) NOT NULL DEFAULT '-1' AFTER `acr_mail_language_id` ;

--boolean flag for products
ALTER TABLE `oc_product` ADD `flag` TINYINT( 11 ) NOT NULL DEFAULT '0' AFTER `stock_status_limits` ;

-- container size for products
ALTER TABLE `oc_product` ADD `container_size` INT( 4 ) NOT NULL DEFAULT '0' AFTER `quantity` ;

-- force buy in bulk setting for customer groups
ALTER TABLE `oc_customer_group` ADD `force_buy_bulk` TINYINT( 4 ) NOT NULL DEFAULT '0' AFTER `tax_id_required` ;

-- product to customer group junction table used as override for force bulk buy setting
CREATE TABLE `oc_force_buy_bulk_override_group` (
 `product_id` int(11) NOT NULL,
 `customer_group_id` int(11) NOT NULL,
 `force_buy_bulk` TINYINT(4) NOT NULL DEFAULT '0',
 PRIMARY KEY (`product_id`,`customer_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- product to customer junction table used as override for force bulk buy setting
CREATE TABLE `oc_force_buy_bulk_override_customer` (
 `product_id` int(11) NOT NULL,
 `customer_id` int(11) NOT NULL,
 `force_buy_bulk` TINYINT(4) NOT NULL DEFAULT '0',
 PRIMARY KEY (`product_id`,`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- product to customer junction table 
CREATE TABLE `oc_product_to_customer` (
 `customer_id` int(11) NOT NULL,
 `product_id` int(11) NOT NULL,
 UNIQUE KEY `product_to_customer` (`customer_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
