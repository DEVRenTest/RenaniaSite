<?php

class ControllerModuleTest extends Controller
{
    public function index()
    {
        $message = "test szeptember 29";
        $type = "debug";

        $this->api_log->write( $message, $type );
        die('Lementette!');
    }

    // https://magazin.renania.ro/index.php?route=module/test&title=0&description=0&sku=1&sec_code=182690950
    // https://magazin.renania.ro/index.php?route=gfx_api/getproductsbyclient&key=1034567899
}