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

-- visitor counter table 
CREATE TABLE `oc_visitor_counter` (
 `url` varchar(50) NOT NULL,
 `session_id` varchar(30) NOT NULL,
 `date` int(5) NOT NULL,
 UNIQUE KEY `url_ip` (`url`,`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- package discount for products
ALTER TABLE `oc_product` ADD `package_discount` INT( 4 ) NOT NULL DEFAULT '0' AFTER `container_size`;

-- autologin table
CREATE TABLE `oc_autologin` (
 `autologin_id` int(11) NOT NULL AUTO_INCREMENT,
 `customer_id` int(11) NOT NULL,
 `token` varchar(32) NOT NULL,
 `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`autologin_id`),
 UNIQUE KEY `token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1

-- customer table accomodate companies
ALTER TABLE `oc_customer` ADD `company_name` VARCHAR( 64 ) NULL ,
ADD `CUI` VARCHAR( 64 ) NULL ,
ADD `CIF` VARCHAR( 64 ) NULL ;

-- customer table secret_code
ALTER TABLE `oc_customer` ADD `secret_code` VARCHAR( 32 ) NULL ,
ADD UNIQUE (
`secret_code`
);

