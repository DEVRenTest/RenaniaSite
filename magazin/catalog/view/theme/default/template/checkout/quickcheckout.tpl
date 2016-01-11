<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <!-- Quick Checkout v4.0 by Dreamvention.com checkout/quickcheckout.tpl -->
  <?php echo $quickcheckout; ?>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>
<script type="text/javascript"><!--

      $('input[id=\'payment_address_company_id\']').bind('change', function() {

            var tax_id = $(this).attr('value');
            
            $.ajax({
            type: 'get',
            url: 'http://openapi.ro/api/companies/'+  tax_id.substring( 2 ) +'.json',
            dataType: 'jsonp',
            success: function(data) {
               $('#payment_address_company').val ( data['name'] );
               $('#payment_address_tax_id').val ( data['registration_id'] );
               $('#payment_address_address_1').val ( data['address'] );
               $('#payment_address_city').val ( data['city'] );
               $('#payment_address_postcode').val ( data['zip'] );
              
               $.ajax({               
                  url: 'index.php?route=account/register/getZoneIdValue&zone_name='+data['state'],
                  type: 'POST',
                  dataType: 'json',
                  beforeSend: function(){},
                  success: function( response ) {

                     if ( response )
                     {                 
                        $("select[id=\'payment_address_zone_id\'] option[value='"+ response['zone_id']  +"']").attr("selected","selected");
                     }
                  },
                  failure: function(){},
                  error: function(){}
               }); 
            }
            });
    
      });
//--></script> 