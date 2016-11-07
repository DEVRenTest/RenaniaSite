<?php
class ControllerCommonCustomerSettings extends Controller
{
    public function index()
    {
        if (!$this->customer->isLogged()) {
            return;
        }
        $this->load->model('setting/customer_setting');
        $customer_settings = array_merge(
            $this->model_setting_customer_setting->getSettings(array('customer_id' => $this->customer->getId(), 'store_id' => -1)),
            $this->model_setting_customer_setting->getSettings(array('customer_id' => $this->customer->getId(), 'store_id' => $this->config->get('config_store_id')))
        );
        foreach ($customer_settings as $customer_setting) {
            $this->config->set($customer_setting['key'], $customer_setting['value']);
        }
    }
}
