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

-- customer autologin table changes
ALTER TABLE `oc_autologin` ADD `url` VARCHAR( 512 ) NULL ;

-- customer autologin table cookie
ALTER TABLE `oc_autologin` ADD `cookie` VARCHAR( 512 ) NULL DEFAULT NULL ;

-- reports table
CREATE TABLE `oc_report` (
 `report_id` int(11) NOT NULL AUTO_INCREMENT,
 `customer_id` int(32) NOT NULL,
 `name` varchar(64) NOT NULL,
 `date_added` datetime NOT NULL,
 PRIMARY KEY (`report_id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=latin1

-- report entry table
CREATE TABLE `oc_report_entry` (
 `report_entry_id` int(11) NOT NULL AUTO_INCREMENT,
 `report_id` int(32) NOT NULL,
 `customer_name` varchar(32) NOT NULL,
 `work_address` varchar(128) NOT NULL,
 `CUI` int(32) NOT NULL,
 `product_code` varchar(64) NOT NULL,
 `product_name` varchar(64) NOT NULL,
 `buy_price` float(15,4) NOT NULL,
 `net_sale_price` float(15,4) NOT NULL,
 `product_quantity` int(4) NOT NULL,
 `sale_agent_name` varchar(64) NOT NULL,
 `month` varchar(32) NOT NULL,
 PRIMARY KEY (`report_entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=latin1

-- customer to customer group table
CREATE TABLE `oc_customer_to_customer_group` (
 `customer_group_id` int(11) NOT NULL,
 `customer_id` int(11) NOT NULL,
 UNIQUE KEY `customer_group_customer_id` (`customer_group_id`,`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1

-- special products request form table
CREATE TABLE `oc_special_products_request` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `quantity` int(11) NOT NULL,
 `unit` int(11) NOT NULL,
 `initial_quantity` int(11) NOT NULL,
 `initial_unit` int(11) NOT NULL,
 `total_value` float NOT NULL,
 `target_price` float NOT NULL,
 `target_unit` int(11) NOT NULL,
 `sales_arguments` text NOT NULL,
 `manager_approval` tinyint(1) NOT NULL,
 `first_batch` date NOT NULL,
 `second_batch` date NOT NULL,
 `third_batch` date NOT NULL,
 `fourth_batch` date NOT NULL,
 `fifth_batch` date NOT NULL,
 `sixth_batch` date NOT NULL,
 `alternative_products` text NOT NULL,
 `customer_feedback` text NOT NULL,
 `provider_name` varchar(32) NOT NULL,
 `identified_circumstances` text NOT NULL,
 `other_informations` text NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1

-- bulk aquisition revamp
CREATE TABLE `oc_bulk_group` (
 `product_id` int(11) NOT NULL,
 `customer_group_id` int(11) NOT NULL,
 `piece` tinyint(1) NOT NULL,
 `bulk` tinyint(1) NOT NULL,
 UNIQUE KEY `group_product` (`product_id`,`customer_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1

CREATE TABLE `oc_bulk_customer` (
 `product_id` int(11) NOT NULL,
 `customer_id` int(11) NOT NULL,
 `piece` tinyint(1) NOT NULL,
 `bulk` tinyint(1) NOT NULL,
 UNIQUE KEY `customer_product` (`product_id`,`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1

ALTER TABLE `oc_customer_group`
ADD `piece` BOOLEAN NOT NULL DEFAULT TRUE,
ADD `bulk` BOOLEAN NOT NULL DEFAULT TRUE,
DROP `force_buy_bulk`

-- product video
ALTER TABLE `oc_product` ADD `video` varchar( 512 ) NOT NULL AFTER `image` ;

-- special products request form table
ALTER TABLE `oc_special_products_request` ADD `product_category` varchar( 32 ) NOT NULL AFTER `target_unit` ;

ALTER TABLE `oc_special_products_request` ADD `customer_id` int( 11 ) NOT NULL AFTER `id` ;

ALTER TABLE `oc_special_products_request` ADD `product_description` text NOT NULL AFTER `customer_id` ;

ALTER TABLE `oc_special_products_request` ADD `image` varchar( 255 ) NOT NULL AFTER `other_informations` ;

---- company as separate entity

-- create company table
CREATE TABLE `oc_company` (
 `company_id` int(11) NOT NULL AUTO_INCREMENT,
 `ax_code` varchar(64) DEFAULT NULL,
 `name` varchar(64) DEFAULT NULL,
 `CUI` varchar(32) DEFAULT NULL,
 `CIF` int(16) DEFAULT NULL,
 PRIMARY KEY (`company_id`),
 UNIQUE KEY `ax_code` (`ax_code`),
 UNIQUE KEY `CUI` (`CUI`),
 UNIQUE KEY `CIF` (`CIF`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1

-- address table changes
ALTER TABLE `oc_address` ADD `comp_id` INT(11) NULL DEFAULT NULL AFTER `customer_id` ;

-- company to customer junction table
CREATE TABLE `oc_customer_to_company` (
 `customer_id` int(11) NOT NULL,
 `company_id` int(11) NOT NULL,
 UNIQUE KEY `customer_company` (`customer_id`,`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1

ALTER TABLE `oc_order` ADD `company_id` INT( 11 ) NULL DEFAULT NULL AFTER `customer_id` ;

-- populate company table
-- INSERT INTO `oc_company` (`name`) SELECT DISTINCT(`ax_code`) FROM `oc_customer` WHERE `ax_code` <> '';

-- populate junction table with existing links
-- INSERT INTO `oc_customer_to_company` (`customer_id`, `company_id`) (
--  SELECT cus.`customer_id`, com.`company_id`
--   FROM `oc_customer` cus
--   LEFT JOIN `oc_company` com ON cus.`ax_code` = com.`name`
--   WHERE cus.`ax_code` <> ''
-- );

ALTER TABLE `oc_customer` ADD `show_form` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `secret_code` ;

-- special products request form table
ALTER TABLE `oc_special_products_request` 
ADD `customer` VARCHAR( 64 ) NOT NULL AFTER `customer_id`,
ADD `customer_type` VARCHAR( 64 ) NOT NULL AFTER `customer`,
ADD `av_rv` VARCHAR( 64 ) NOT NULL AFTER `customer_type`,
ADD `requested_delivery_term` DATE NOT NULL AFTER `av_rv`,
ADD `aplication_description` TEXT NOT NULL AFTER `image`,
ADD `working_conditions` TEXT NOT NULL AFTER `aplication_description`,
ADD `protection_type` TEXT NOT NULL AFTER `working_conditions`,
ADD `technical_specification` TEXT NOT NULL AFTER `protection_type`,
ADD `respiratory_protection_gases` TEXT NOT NULL AFTER `technical_specification`,
ADD `respiratory_protection_dust` TEXT NOT NULL AFTER `respiratory_protection_gases`,
ADD `heat_transmission` TEXT NOT NULL AFTER `respiratory_protection_dust`,
ADD `temperature` TEXT NOT NULL AFTER `heat_transmission`,
ADD `protection_level` TEXT NOT NULL AFTER `temperature`,
ADD `chemical_substance_name` TEXT NOT NULL AFTER `protection_level`,
ADD `CAS_number` TEXT NOT NULL AFTER `chemical_substance_name`,
ADD `contact_duration` TEXT NOT NULL AFTER `CAS_number`,
ADD `product_type` VARCHAR( 64 ) NOT NULL AFTER `contact_duration`;
ADD `requested_material` VARCHAR( 64 ) NOT NULL AFTER `product_type`;
ADD `grammage` float NOT NULL AFTER `requested_material`;
ADD `color` VARCHAR( 64 ) NOT NULL AFTER `grammage`;
