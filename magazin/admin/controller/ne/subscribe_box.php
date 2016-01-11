<?php
//-----------------------------------------------------
// Newsletter Enhancements for Opencart
// Created by @DmitryNek (Dmitry Shkoliar)
// exmail.Nek@gmail.com
//-----------------------------------------------------

class ControllerNeSubscribeBox extends Controller {
    private $error = array();

    public function index() {
        $this->language->load('ne/subscribe_box');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('ne/subscribe_box');

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('ne/subscribe_box', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['edit'] = $this->url->link('ne/subscribe_box/update', 'token=' . $this->session->data['token'] . '&id=', 'SSL');
        $this->data['insert'] = $this->url->link('ne/subscribe_box/insert', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['delete'] = $this->url->link('ne/subscribe_box/delete', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['copy'] = $this->url->link('ne/subscribe_box/copy', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['save'] = $this->url->link('ne/subscribe_box/save', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['subscribe_boxes'] = array();

        $results = $this->model_ne_subscribe_box->getList();

        foreach ($results as $result) {
            $this->data['subscribe_boxes'][] = array_merge($result, array(
                'selected' => isset($this->request->post['selected']) && is_array($this->request->post['selected']) && in_array($result['subscribe_box_id'], $this->request->post['selected'])
            ));
        }
        unset($result);

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_no_results'] = $this->language->get('text_no_results');
        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_content_top'] = $this->language->get('text_content_top');
        $this->data['text_content_bottom'] = $this->language->get('text_content_bottom');
        $this->data['text_column_left'] = $this->language->get('text_column_left');
        $this->data['text_column_right'] = $this->language->get('text_column_right');

        $this->data['column_name'] = $this->language->get('column_name');
        $this->data['column_last_change'] = $this->language->get('column_last_change');
        $this->data['column_actions'] = $this->language->get('column_actions');
        $this->data['column_status'] = $this->language->get('column_status');

        $this->data['button_delete'] = $this->language->get('button_delete');
        $this->data['button_insert'] = $this->language->get('button_insert');
        $this->data['button_copy'] = $this->language->get('button_copy');
        $this->data['button_edit'] = $this->language->get('button_edit');

        $this->data['entry_layout'] = $this->language->get('entry_layout');
        $this->data['entry_position'] = $this->language->get('entry_position');
        $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_store'] = $this->language->get('entry_store');
        $this->data['entry_subscribe_box'] = $this->language->get('entry_subscribe_box');

        $this->data['button_remove'] = $this->language->get('button_remove');
        $this->data['button_add_module'] = $this->language->get('button_add_module');
        $this->data['button_save'] = $this->language->get('button_save');

        if (isset($this->request->post['ne_module'])) {
            $this->data['modules'] = $this->request->post['ne_module'];
        } elseif ($this->config->get('ne_modules')) {
            $this->data['modules'] = $this->config->get('ne_modules');
        } else {
            $this->data['modules'] = array();
        }

        $this->data['token'] = $this->session->data['token'];

        $this->load->model('design/layout');

        $this->data['layouts'] = $this->model_design_layout->getLayouts();

        $this->load->model('setting/store');

        $this->data['stores'] = $this->model_setting_store->getStores();

        array_unshift($this->data['stores'], array('store_id' => 0, 'name' => $this->language->get('text_default')));

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = $this->config->get('ne_warning');
        }

        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }

        if (isset($this->session->data['warning'])) {
            $this->data['error_warning'] = $this->session->data['warning'];
            unset($this->session->data['warning']);
        }

        $this->template = 'ne/subscribe_box_list.tpl';
        $this->children = array(
            'common/header',
            'common/footer',
        );

        $this->response->setOutput($this->render());
    }

    public function save() {
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateSave()) {

            $this->load->model('ne/subscribe_box');

            if (empty($this->request->post['ne_module'])) {
                $this->request->post['ne_module'] = array();
            }

            $modules = array();
            foreach ($this->request->post['ne_module'] as $module) {
                if (!isset($modules[$module['store']])) {
                    $modules[$module['store']] = array();
                }
                $modules[$module['store']][] = $module;
            }

            foreach ($modules as $store_id => $module) {
                $this->model_ne_subscribe_box->editSettingValue('ne', 'ne_module', $module, $store_id);
            }

            if (empty($modules)) {
                $this->model_ne_subscribe_box->deleteSettingValue('ne', 'ne_module');
            }

            $this->model_ne_subscribe_box->editSettingValue('ne', 'ne_modules', $this->request->post['ne_module']);

            $this->language->load('ne/subscribe_box');

            $this->session->data['success'] = $this->language->get('text_success_save');
        }

        $this->redirect($this->url->link('ne/subscribe_box', 'token=' . $this->session->data['token'], 'SSL'));
    }

    public function update() {
        $this->language->load('ne/subscribe_box');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('ne/subscribe_box');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_ne_subscribe_box->save(array_merge($this->request->post, array('id' => $this->request->get['id'])));
            $this->session->data['success'] = $this->language->get('text_success_save');

            $this->redirect($this->url->link('ne/subscribe_box', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->form();
    }

    public function insert() {
        $this->language->load('ne/subscribe_box');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('ne/subscribe_box');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_ne_subscribe_box->save($this->request->post);
            $this->session->data['success'] = $this->language->get('text_success_save');

            $this->redirect($this->url->link('ne/subscribe_box', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->form();
    }

    private function form() {
        if (isset($this->request->get['id'])) {
            $subscribe_box_id = $this->request->get['id'];
            $subscribe_box_info = $this->model_ne_subscribe_box->get($subscribe_box_id);
        } else {
            $subscribe_box_info = array();
        }

        $this->document->addScript('view/javascript/colorpicker/js/colorpicker.js');
        $this->document->addStyle('view/javascript/colorpicker/css/colorpicker.css');

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['entry_name'] = $this->language->get('entry_name');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_show_for'] = $this->language->get('entry_show_for');
        $this->data['entry_fields'] = $this->language->get('entry_fields');
        $this->data['entry_heading'] = $this->language->get('entry_heading');
        $this->data['entry_text'] = $this->language->get('entry_text');
        $this->data['entry_type'] = $this->language->get('entry_type');
        $this->data['entry_modal_timeout'] = $this->language->get('entry_modal_timeout');
        $this->data['entry_modal_repeat_time'] = $this->language->get('entry_modal_repeat_time');
        $this->data['entry_modal_bg_color'] = $this->language->get('entry_modal_bg_color');
        $this->data['entry_modal_heading_color'] = $this->language->get('entry_modal_heading_color');
        $this->data['entry_modal_line_color'] = $this->language->get('entry_modal_line_color');
        $this->data['entry_list_type'] = $this->language->get('entry_list_type');

        $this->data['text_settings'] = $this->language->get('text_settings');
        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_all'] = $this->language->get('text_all');
        $this->data['text_guests'] = $this->language->get('text_guests');
        $this->data['text_only_email'] = $this->language->get('text_only_email');
        $this->data['text_email_name'] = $this->language->get('text_email_name');
        $this->data['text_email_full'] = $this->language->get('text_email_full');
        $this->data['text_content_box'] = $this->language->get('text_content_box');
        $this->data['text_modal_popup'] = $this->language->get('text_modal_popup');
        $this->data['text_content_box_to_modal'] = $this->language->get('text_content_box_to_modal');
        $this->data['text_modal_popup_settings'] = $this->language->get('text_modal_popup_settings');
        $this->data['text_modal_popup_style'] = $this->language->get('text_modal_popup_style');
        $this->data['text_checkboxes'] = $this->language->get('text_checkboxes');
        $this->data['text_radio_buttons'] = $this->language->get('text_radio_buttons');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('ne/subscribe_box', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $subscribe_box_info ? $subscribe_box_info['name'] : $this->language->get('text_new_subscribe_box'),
            'href'      => $subscribe_box_info ? $this->url->link('ne/subscribe_box/update', 'token=' . $this->session->data['token'] . '&id=' . (int)$subscribe_box_id, 'SSL') : $this->url->link('ne/subscribe_box/insert', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = $this->config->get('ne_warning');
        }

        if (isset($this->error['name'])) {
            $this->data['error_name'] = $this->error['name'];
        } else {
            $this->data['error_name'] = '';
        }

        if (isset($this->request->post['name'])) {
            $this->data['name'] = $this->request->post['name'];
        } elseif (!empty($subscribe_box_info)) {
            $this->data['name'] = $subscribe_box_info['name'];
        } else {
            $this->data['name'] = '';
        }

        if (isset($this->request->post['status'])) {
            $this->data['status'] = $this->request->post['status'];
        } elseif (!empty($subscribe_box_info)) {
            $this->data['status'] = $subscribe_box_info['status'];
        } else {
            $this->data['status'] = '';
        }

        if (isset($this->request->post['show_for'])) {
            $this->data['show_for'] = $this->request->post['show_for'];
        } elseif (!empty($subscribe_box_info)) {
            $this->data['show_for'] = $subscribe_box_info['show_for'];
        } else {
            $this->data['show_for'] = '';
        }

        if (isset($this->request->post['fields'])) {
            $this->data['fields'] = $this->request->post['fields'];
        } elseif (!empty($subscribe_box_info)) {
            $this->data['fields'] = $subscribe_box_info['fields'];
        } else {
            $this->data['fields'] = '';
        }

        if (isset($this->request->post['type'])) {
            $this->data['type'] = $this->request->post['type'];
        } elseif (!empty($subscribe_box_info)) {
            $this->data['type'] = $subscribe_box_info['type'];
        } else {
            $this->data['type'] = '';
        }

        if (isset($this->request->post['list_type'])) {
            $this->data['list_type'] = $this->request->post['list_type'];
        } elseif (!empty($subscribe_box_info)) {
            $this->data['list_type'] = $subscribe_box_info['list_type'];
        } else {
            $this->data['list_type'] = '';
        }

        if (isset($this->request->post['modal_timeout'])) {
            $this->data['modal_timeout'] = $this->request->post['modal_timeout'];
        } elseif (!empty($subscribe_box_info)) {
            $this->data['modal_timeout'] = $subscribe_box_info['modal_timeout'];
        } else {
            $this->data['modal_timeout'] = '0';
        }

        if (isset($this->request->post['repeat_time'])) {
            $this->data['repeat_time'] = $this->request->post['repeat_time'];
        } elseif (!empty($subscribe_box_info)) {
            $this->data['repeat_time'] = $subscribe_box_info['repeat_time'];
        } else {
            $this->data['repeat_time'] = '1';
        }

        if (isset($this->request->post['modal_bg_color'])) {
            $this->data['modal_bg_color'] = $this->request->post['modal_bg_color'];
        } elseif (!empty($subscribe_box_info)) {
            $this->data['modal_bg_color'] = $subscribe_box_info['modal_bg_color'];
        } else {
            $this->data['modal_bg_color'] = '#ffffff';
        }

        if (isset($this->request->post['modal_line_color'])) {
            $this->data['modal_line_color'] = $this->request->post['modal_line_color'];
        } elseif (!empty($subscribe_box_info)) {
            $this->data['modal_line_color'] = $subscribe_box_info['modal_line_color'];
        } else {
            $this->data['modal_line_color'] = '#e5e5e5';
        }

        if (isset($this->request->post['modal_heading_color'])) {
            $this->data['modal_heading_color'] = $this->request->post['modal_heading_color'];
        } elseif (!empty($subscribe_box_info)) {
            $this->data['modal_heading_color'] = $subscribe_box_info['modal_heading_color'];
        } else {
            $this->data['modal_heading_color'] = '#222222';
        }

        if (isset($this->request->post['heading'])) {
            $this->data['heading'] = $this->request->post['heading'];
        } elseif (!empty($subscribe_box_info)) {
            $this->data['heading'] = $subscribe_box_info['heading'];
        } else {
            $this->data['heading'] = array();
        }

        if (isset($this->request->post['text'])) {
            $this->data['text'] = $this->request->post['text'];
        } elseif (!empty($subscribe_box_info)) {
            $this->data['text'] = $subscribe_box_info['text'];
        } else {
            $this->data['text'] = array();
        }

        $this->load->model('localisation/language');

        $this->data['languages'] = $this->model_localisation_language->getLanguages();

        if (!isset($subscribe_box_id)) {
            $this->data['action'] = $this->url->link('ne/subscribe_box/insert', 'token=' . $this->session->data['token'], 'SSL');
        } else {
            $this->data['action'] = $this->url->link('ne/subscribe_box/update', 'token=' . $this->session->data['token'] . '&id=' . $subscribe_box_id, 'SSL');
        }

        $this->data['cancel'] = $this->url->link('ne/subscribe_box', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['token'] = $this->session->data['token'];

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = $this->config->get('ne_warning');
        }

        $this->template = 'ne/subscribe_box_form.tpl';
        $this->children = array(
            'common/header',
            'common/footer',
        );

        $this->response->setOutput($this->render());
    }

    public function delete() {
        $this->language->load('ne/subscribe_box');
        $this->load->model('ne/subscribe_box');

        if (isset($this->request->post['selected']) && $this->validate()) {
            foreach ($this->request->post['selected'] as $subscribe_box_id) {
                if (!$this->model_ne_subscribe_box->delete($subscribe_box_id)) {
                    $this->error['warning'] = $this->language->get('error_delete');
                }
            }
            if (isset($this->error['warning'])) {
                $this->session->data['warning'] = $this->error['warning'];
            } else {
                $this->session->data['success'] = $this->language->get('text_success');
            }
        }

        $this->redirect($this->url->link('ne/subscribe_box', 'token=' . $this->session->data['token'], 'SSL'));
    }

    public function copy() {
        if (isset($this->request->post['selected']) && $this->validate()) {
            $this->language->load('ne/subscribe_box');
            $this->load->model('ne/subscribe_box');

            foreach ($this->request->post['selected'] as $subscribe_box_id) {
                if (!$this->model_ne_subscribe_box->copy($subscribe_box_id)) {
                    $this->error['warning'] = $this->language->get('error_copy');
                }
            }
            if (isset($this->error['warning'])) {
                $this->session->data['warning'] = $this->error['warning'];
            } else {
                $this->session->data['success'] = $this->language->get('text_success_copy');
            }
        }

        $this->redirect($this->url->link('ne/subscribe_box', 'token=' . $this->session->data['token'], 'SSL'));
    }

    private function validateSave() {
        if (!$this->user->hasPermission('modify', 'ne/subscribe_box')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    private function validateForm() {
        if (!$this->user->hasPermission('modify', 'ne/subscribe_box')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (empty($this->request->post['name'])) {
            $this->error['name'] = $this->language->get('error_name');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'ne/subscribe_box')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}
?>