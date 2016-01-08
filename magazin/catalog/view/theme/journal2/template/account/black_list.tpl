<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
</div>
<div id="content"><?php echo $content_top; ?>
    <h1 class="heading-title"><?php echo $heading_title; ?></h1>
    <form action="<?php echo $search_action; ?>" method="post" enctype="multipart/form-data">
        <input name="search_client" type="text" placeholder="Cauta Client" style="float: right;" value="<?=$search_client ?>" >
    </form>

    <?php if ( $customer_B2B ) { ?>
    <table class="list">
        <thead>
        <tr>
            <td class="left">
                Clienti
            </td>
            <td class="left">
                Adresa
            </td>
            <td class="left">
                Oras
            </td>
            <td class="left">
                Judet
            </td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($black_list as $client) { ?>
        <tr>
            <td class="left">
                <?php echo $client['accountnum']; ?>
            </td>
            <td class="left">
                <?php echo $client['street']; ?>
            </td>
            <td class="left">
                <?php echo $client['city']; ?>
            </td>
            <td class="left">
                <?php echo $client['county']; ?>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    <div class="pagination"><?php echo $pagination; ?></div>
    <?php } ?>

    <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>