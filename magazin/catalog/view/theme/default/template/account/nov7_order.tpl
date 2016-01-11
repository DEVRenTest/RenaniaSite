<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
    <?php echo $content_top; ?>
  <?php if ($orders) { ?>
  <?php foreach ($orders as $order) { ?>
  <div class="order-list">
      <div><b>ID Comanda:</b> <?php echo $order['order_id']; ?></div>
      <div><b>Nume:</b> <?php echo $order['firstname']." ".$order['lastname'] ; ?></div>
      <div><b>Email:</b> <?php echo $order['email']; ?></div>
      <div><b>Metoda de livrare:</b> <?php echo $order['shipping_method']; ?></div>
      <div><b>Taxa de livrare :</b>
          <?php echo $order_total[ $order['order_id'] ]['shipping']; ?>
      </div>
      <div><b>TVA (24%):</b>
          <?php echo $order_total[ $order['order_id'] ]['tax']; ?>
      </div>
      <div><b>Totalul comenzii:</b> <?php echo $order['total']; ?></div>
      <div><b>Ip:</b> <?php echo $order['ip']; ?></div>

    <div>
      <?php
      $products = $order_products[ $order['order_id'] ]; ?>
      <div><br /></div>
      <?php foreach ($products as $value) {
      ?>
          <div>
              <b>***** Nume produs:</b> <?php echo $value['name']; ?><br />
              <b>Model:</b> <?php echo $value['model']; ?><br />
              <b>Cantitate:</b> <?php echo $value['quantity']; ?><br />
              <b>Pret:</b> <?php echo $value['price']; ?><br /><br />
           <!--   <b>Total:</b> <?php echo $value['total']; ?><br /><br /> -->
          </div>
      <?php
      } ?>

    </div>

      <hr size="1">

  </div>
  <?php } ?>

  <?php } else { ?>
  <div class="content"><?php echo $text_empty; ?></div>
  <?php } ?>

  </div>
<?php echo $footer; ?>