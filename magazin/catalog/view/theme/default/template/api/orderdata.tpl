<!DOCTYPE cXML SYSTEM "http://xml.cxml.org/schemas/cXML/1.2.014/cXML.dtd">
<cXML payloadID="" xml:lang="en-US" timestamp="<?php echo date('c'); ?>" version="1.2.0.14">
  <Header>
    <From>
      <Credential domain="NetworkID"> 
        <Identity/>
      </Credential>
    </From>
    <To>
      <Credential domain="NetworkId"> 
        <Identity></Identity>
      </Credential>
    </To>
    <Sender>
      <Credential domain="NetworkID"> 
        <Identity/>
      </Credential>
      <UserAgent/>
    </Sender>
  </Header>
  <Message>
    <PunchOutOrderMessage>
      <BuyerCookie></BuyerCookie>
      <PunchOutOrderMessageHeader operationAllowed="edit">
        <Total>
          <Money currency="<?php echo $currency_code; ?>"><?php echo $total; ?></Money>
        </Total>
        <Shipping>
          <Money currency="<?php echo $currency_code; ?>"><?php foreach ($totals as $total) { if ($total['code'] == 'shipping') { echo $total['value']; break; }} ?></Money>
          <Description xml:lang="en-US"><?php echo $shipping_method; ?></Description>
        </Shipping>
        <Tax>
          <Money currency="<?php echo $currency_code; ?>"><?php foreach ($totals as $total) { if ($total['code'] == 'tax') { echo $total['value']; break; }} ?></Money>
          <Description xml:lang="en-US"><?php foreach ($totals as $total) { if ($total['code'] == 'tax') { echo $total['title']; break; }} ?></Description>
        </Tax>
      </PunchOutOrderMessageHeader>
      <?php foreach ($products as $product) { ?>
      <ItemIn quantity="<?php echo $product['quantity']; ?>">    
        <ItemID>
          <SupplierPartID><?php echo $product['model']; ?></SupplierPartID>
          <SupplierPartAuxiliaryID></SupplierPartAuxiliaryID>
        </ItemID>
        <ItemDetail>
          <UnitPrice>
            <Money currency="<?php echo $currency_code; ?>"><?php echo $product['price']; ?></Money>
          </UnitPrice>
          <Description xml:lang="en-US"><?php echo $product['name']; ?></Description>
          <UnitOfMeasure>EA</UnitOfMeasure>
          <Classification domain="UNSPSC"></Classification>
          <ManufacturerName/>
          <LeadTime>1</LeadTime>          
        </ItemDetail>
      </ItemIn>
      <?php } ?>
    </PunchOutOrderMessage>
  </Message>
</cXML>
