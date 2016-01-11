<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><h1 style="display: none;"><?php echo $heading_title; ?></h1><?php echo $content_top; ?>
    <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>

        <?php if (isset($home_page) && $home_page) { ?>
        <script type="text/javascript">
        $( document ).ready(function() {
            $('footer').addClass('fixed_footer');
            $('.extended-container').hide();
        });
        </script>
        <?php } ?>
            