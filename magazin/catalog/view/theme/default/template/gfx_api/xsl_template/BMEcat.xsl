<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">


    <xsl:template match="/">

        <BMECAT version="1.2">
        <HEADER>
            <GENERATOR_INFO><xsl:value-of select="channel/header/generator_info"/></GENERATOR_INFO>
            <CATALOG>
                <LANGUAGE><xsl:value-of select="channel/header/catalog/language"/></LANGUAGE>
                <CATALOG_ID><xsl:value-of select="channel/header/catalog/catalog_id"/></CATALOG_ID>
                <CATALOG_VERSION><xsl:value-of select="channel/header/catalog/catalog_version"/></CATALOG_VERSION>
                <CURRENCY><xsl:value-of select="channel/header/catalog/currency"/></CURRENCY>
            </CATALOG>

            <AGREEMENT>
                <AGREEMENT_START_DATE><xsl:value-of select="channel/header/agreement/agreement_start_date"/></AGREEMENT_START_DATE>
                <AGREEMENT_END_DATE><xsl:value-of select="channel/header/agreement/agreement_end_date"/></AGREEMENT_END_DATE>
            </AGREEMENT>

            <BUYER>
                <BUYER_ID type="buyer_specific"><xsl:value-of select="channel/header/buyer/buyer_id"/></BUYER_ID>
                <BUYER_NAME><xsl:value-of select="channel/header/buyer/buyer_name"/></BUYER_NAME>
                <ADDRESS type="buyer">
                    <NAME><xsl:value-of select="channel/header/buyer/address/name"/></NAME>
                    <CONTACT><xsl:value-of select="channel/header/buyer/address/contact"/></CONTACT>
                </ADDRESS>
            </BUYER>
            <SUPPLIER>
                <SUPPLIER_NAME><xsl:value-of select="channel/header/supplier/supplier_name"/></SUPPLIER_NAME>
            </SUPPLIER>
        </HEADER>


        <xsl:for-each select="channel/item">

            <ARTICLE mode="new">
                <SUPPLIER_AID><xsl:value-of select="product_id"/></SUPPLIER_AID>
                <ARTICLE_DETAILS>
                    <DESCRIPTION_SHORT><xsl:value-of select="name"/></DESCRIPTION_SHORT>
                    <DESCRIPTION_LONG><xsl:value-of select="description"/></DESCRIPTION_LONG>
                    <MANUFACTURER_NAME><xsl:value-of select="manufacturer"/></MANUFACTURER_NAME>
                     <DELIVERY_TIME>3</DELIVERY_TIME>
                </ARTICLE_DETAILS>

                <ARTICLE_FEATURES>
                    <REFERENCE_FEATURE_SYSTEM_NAME><xsl:value-of select="reference_feature_system_name"/></REFERENCE_FEATURE_SYSTEM_NAME>
                    <REFERENCE_FEATURE_GROUP_ID><xsl:value-of select="reference_feature_group_id"/></REFERENCE_FEATURE_GROUP_ID>
                </ARTICLE_FEATURES>

                <ARTICLE_ORDER_DETAILS>
                    <ORDER_UNIT><xsl:value-of select="order_unit"/></ORDER_UNIT>
                    <CONTENT_UNIT><xsl:value-of select="content_unit"/></CONTENT_UNIT>
                    <NO_CU_PER_OU><xsl:value-of select="no_cu_per_ou"/></NO_CU_PER_OU>
                    <QUANTITY_INTERVAL><xsl:value-of select="quantity_interval"/></QUANTITY_INTERVAL>
                </ARTICLE_ORDER_DETAILS>

                <ARTICLE_PRICE_DETAILS>
                    <DATETIME type="valid_start_date">
                        <DATE><xsl:value-of select="valid_start_date"/></DATE>
                        <!--<TIME>00:00:00</TIME>-->
                    </DATETIME>
<!--                    <DATETIME type="valid_end_date">
                        <DATE>2007-12-31</DATE>
                        <TIME>00:00:00</TIME>
                    </DATETIME>-->
                    <ARTICLE_PRICE price_type="net_customer">
                        <PRICE_AMOUNT><xsl:value-of select="price"/></PRICE_AMOUNT>
                        <LOWER_BOUND><xsl:value-of select="lower_bound"/></LOWER_BOUND>
                        <PRICE_CURRENCY><xsl:value-of select="price_currency"/></PRICE_CURRENCY>
                        <TAX><xsl:value-of select="tax"/></TAX>
                    </ARTICLE_PRICE>
                </ARTICLE_PRICE_DETAILS>

<!--                $output .= '<price_quantity>'.$product['minimum'].'</price_quantity>';
                $output .= '<quantity_min>'.$product['minimum'].'</quantity_min>';-->

                <CATALOG_GROUP_SYSTEM>
                    <GROUP_SYSTEM_ID><xsl:value-of select="category_id"/></GROUP_SYSTEM_ID>
                    <GROUP_SYSTEM_NAME><xsl:value-of select="category_name"/></GROUP_SYSTEM_NAME>
                    <PARENT_ID><xsl:value-of select="parent_id"/></PARENT_ID>
<!--                    <CATALOG_STRUCTURE type="node">...</CATALOG_STRUCTURE>
                    <CATALOG_STRUCTURE type="leaf">...</CATALOG_STRUCTURE>-->
                    <GROUP_SYSTEM_DESCRIPTION><xsl:value-of select="category_name"/></GROUP_SYSTEM_DESCRIPTION>
                </CATALOG_GROUP_SYSTEM>

                <MIME_INFO>
                    <MIME>
                        <MIME_SOURCE><xsl:value-of select="image"/></MIME_SOURCE>
                        <MIME_PURPOSE>normal</MIME_PURPOSE>
                    </MIME>
                </MIME_INFO>
            </ARTICLE>

        </xsl:for-each>

        </BMECAT>
    </xsl:template>


</xsl:stylesheet>