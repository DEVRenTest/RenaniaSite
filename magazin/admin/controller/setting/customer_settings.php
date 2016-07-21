<?php
class ControllerSettingCustomerSettings extends Controller
{
    private $error = array();

    public function index()
    {
        $customer_specific_page = isset($this->request->get['customer_id']);
        $store_specific_page = isset($this->request->get['store_id']);

        $this->language->load('setting/customer_settings');
        $this->document->setTitle($this->language->get('heading_title'));
        if ($customer_specific_page) {
            $this->document->setTitle($this->language->get('heading_title_customer'));
        }
        if ($store_specific_page) {
            $this->document->setTitle($this->language->get('heading_title_store'));
        }

        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('setting/customer_settings', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['token'] = $this->session->data['token'];
        $this->data['customer_settings_url'] = $this->url->link('setting/customer_settings', 'token=' . $this->session->data['token'], 'SSL');

        $language_vars = array(
            'heading_title',
            'heading_title_customer',
            'heading_title_store',
            'button_insert',
            'button_save',
            'button_edit',
            'button_remove',
            'text_store',
            'text_customer',
            'text_group',
            'text_key',
            'text_value',
            'text_value_type',
            'text_string',
            'text_array',
            'text_edit_page',
        );
        foreach ($language_vars as $language_var) {
            $this->data[$language_var] = $this->language->get($language_var);
        }

        $this->load->model('setting/store');
        $this->data['stores'] = array(
            array('id' => -1, 'name' => $this->language->get('text_all')),
            array('id' => 0, 'name' => $this->config->get('config_name'))
        );
        foreach ($this->model_setting_store->getStores() as $store) {
            $this->data['stores'][] = array('id' => $store['store_id'], 'name' => $store['name']);
        }

        if ($customer_specific_page) {
            $this->load->model('setting/customer_setting');
            $this->data['current_settings'] = $this->model_setting_customer_setting->getSettings(array('customer_id' => $this->request->get['customer_id']));
            $this->data['customer_id'] = $this->request->get['customer_id'];
        }
        if ($store_specific_page) {
            $this->load->model('setting/customer_setting');
            $this->load->model('sale/customer');
            $this->data['current_settings'] = $this->model_setting_customer_setting->getSettings(array('store_id' => $this->request->get['store_id']));
            foreach ($this->data['current_settings'] as $k => $v) {
                $this->data['current_settings'][$k]['customer_name'] = 'N/A';
                $customer = $this->model_sale_customer->getCustomer($v['customer_id']);
                if ($customer) {
                    $this->data['current_settings'][$k]['customer_name'] = $customer['firstname'] . ' ' . $customer['lastname'] . ' (' . $customer['email'] . ')';
                }
            }
            $this->data['store_id'] = $this->request->get['store_id'];
        }

        $this->template = 'setting/customer_settings.tpl';
        if ($customer_specific_page) {
            $this->template = 'setting/customer_settings_customer.tpl';
        }
        if ($store_specific_page) {
            $this->template = 'setting/customer_settings_store.tpl';
        }
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
    }

    public function processPostData()
    {
        $this->language->load('setting/customer_settings');
        $message = array();
        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
            $this->load->model('setting/customer_setting');
            switch ($this->request->post['form_type']) {
                case 'add_only':
                    $this->model_setting_customer_setting->addSettings($this->request->post['settings']);
                    break;
                case 'customer':
                    $this->model_setting_customer_setting->updateCustomerSettings($this->request->post['customer_id'], $this->request->post['settings']);
                    break;
                case 'store':
                    $this->model_setting_customer_setting->updateStoreSettings($this->request->post['store_id'], $this->request->post['settings']);
                    break;
                default:
                    break;
            }
            $message['success'] = $this->language->get('text_success');
        } else {
            $message['errors'] = $this->error;
        }
        $this->response->setOutput(json_encode($message));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'setting/customer_settings')) {
            $this->error['warning'] = $this->language->get('error_no_permission');
            return false;
        }
        if (isset($this->request->post['settings'])) {
            $this->log->write(print_r($this->request->post, true));
            $invalid_groups = array();
            $invalid_keys = array();
            $invalid_values = array();
            $invalid_arrays = array();
            foreach ($this->request->post['settings'] as $key => $entry) {
                if (strlen(trim($entry['group'])) < 2 || strlen(trim($entry['group'])) > 32) {
                    $invalid_groups[] = $key;
                }
                if (strlen(trim($entry['key'])) < 2 || strlen(trim($entry['key'])) > 64) {
                    $invalid_keys[] = $key;
                }
                if ($entry['is_json'] && !json_decode(htmlspecialchars_decode($entry['value']), true)) {
                    $invalid_arrays[] = $key;
                } elseif (trim($entry['value']) == '') {
                    $invalid_values[] = $key;
                }
            }
            if ($invalid_groups) {
                $this->error['invalid_groups'] = $invalid_groups;
                $this->error['messages'][] = $this->language->get('error_invalid_groups');
            }
            if ($invalid_keys) {
                $this->error['invalid_keys'] = $invalid_keys;
                $this->error['messages'][] = $this->language->get('error_invalid_keys');
            }
            if ($invalid_values) {
                $this->error['invalid_values'] = $invalid_values;
                $this->error['messages'][] = $this->language->get('error_missing_values');
            }
            if ($invalid_arrays) {
                $this->error['invalid_arrays'] = $invalid_arrays;
                $this->error['messages'][] = $this->language->get('error_invalid_arrays');
            }
        }
        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    public function autocompleteGroup()
    {
        $result = array();
        if (isset($this->request->get['group']) && trim($this->request->get['group'])) {
            $this->load->model('setting/customer_setting');
            $result = $this->model_setting_customer_setting->getSettingGroups($this->request->get['group']);
        }
        $this->response->setOutput(json_encode($result));
    }

    public function autocompleteKey()
    {
        $result = array();
        if (isset($this->request->get['key']) && trim($this->request->get['key'])) {
            $group = isset($this->request->get['group']) && trim($this->request->get['group']) ? trim($this->request->get['group']) : '';
            $this->load->model('setting/customer_setting');
            $result = $this->model_setting_customer_setting->getSettingKeys(trim($this->request->get['key']), $group);
        }
        $this->response->setOutput(json_encode($result));
    }
}
