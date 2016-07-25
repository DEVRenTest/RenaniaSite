<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL; ?>
<!DOCTYPE cXML SYSTEM "http://xml.cxml.org/schemas/cXML/1.2.014/cXML.dtd">
<cXML payloadID="<?php echo $order_id . '@renania.ro'; ?>" xml:lang="en-US" timestamp="<?php echo date('c'); ?>" version="1.2.0.14">
  <Header>
    <From>
      <Credential domain="Renania.ro"> 
        <Identity>Renania Trade<Identity/>
      </Credential>
    </From>
    <To>
      <Credential domain="Renania.ro"> 
        <Identity>Renania Trade<Identity/>
      </Credential>
    </To>
    <Sender>
      <Credential domain="Renania.ro"> 
        <Identity>Renania Trade<Identity/>
      </Credential>
      <UserAgent/>
    </Sender>
  </Header>
  <Message>
    <PunchOutOrderMessage>
      <BuyerCookie><?php echo $remote_cookie; ?></BuyerCookie>
      <PunchOutOrderMessageHeader operationAllowed="edit">
        <Total>
          <Money currency="<?php echo $currency_code; ?>"><?php echo round($total, 2); ?></Money>
        </Total>
        <Shipping>
          <Money currency="<?php echo $currency_code; ?>"><?php foreach ($totals as $total) { if ($total['code'] == 'shipping') { echo round($total['value'], 2); break; }} ?></Money>
          <Description xml:lang="en-US"><?php echo $shipping_method; ?></Description>
        </Shipping>
        <Tax>
          <Money currency="<?php echo $currency_code; ?>"><?php foreach ($totals as $total) { if ($total['code'] == 'tax') { echo round($total['value'], 2); break; }} ?></Money>
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
            <Money currency="<?php echo $currency_code; ?>"><?php echo round($product['price'], 2); ?></Money>
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
