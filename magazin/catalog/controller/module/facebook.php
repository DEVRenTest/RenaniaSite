<?php

class ControllerModuleFacebook extends Controller
{

    protected function index( $setting )
    {
        static $module = 0;

        $this->data['module'] = $module++;

        if( file_exists( DIR_TEMPLATE.$this->config->get( 'config_template' ).'/template/module/facebook.tpl' ) )
        {
            $this->template = $this->config->get( 'config_template' ).'/template/module/facebook.tpl';
        }
        else
        {
            $this->template = 'default/template/module/facebook.tpl';
        }

        $this->render();
    }

}

?>