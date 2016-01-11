<?php
//-----------------------------------------------------
// Newsletter Enhancements for Opencart
// Created by @DmitryNek (Dmitry Shkoliar)
// exmail.Nek@gmail.com
//-----------------------------------------------------

class ControllerNeBlacklist extends Controller {
    private $error = array();

    public function index() {
        $this->language->load('ne/blacklist');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('ne/blacklist');

        if (isset($this->request->get['filter_email'])) {
            $filter_email = $this->request->get['filter_email'];
        } else {
            $filter_email = null;
        }

        if (isset($this->request->get['filter_date'])) {
            $filter_date = $this->request->get['filter_date'];
        } else {
            $filter_date = null;
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'datetime';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['filter_email'])) {
            $url .= '&filter_email=' . $this->request->get['filter_email'];
        }

        if (isset($this->request->get['filter_date'])) {
            $url .= '&filter_date=' . $this->request->get['filter_date'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('ne/blacklist', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data = array(
            'filter_email'  => $filter_email,
            'filter_date'   => $filter_date,
            'sort'          => $sort,
            'order'         => $order,
            'start'         => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit'         => $this->config->get('config_admin_limit')
        );

        $blacklist_total = $this->model_ne_blacklist->getTotal($data);

        $this->data['blacklisted'] = array();

        $results = $this->model_ne_blacklist->getList($data);

        foreach ($results as $result) {
            $this->data['blacklisted'][] = array_merge($result, array('selected' => isset($this->request->post['selected']) && is_array($this->request->post['selected']) && in_array($result['blacklist_id'], $this->request->post['selected'])));
        }
        unset($result);

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_no_results'] = $this->language->get('text_no_results');
        $this->data['text_add_info'] = $this->language->get('text_add_info');

        $this->data['column_email'] = $this->language->get('column_email');
        $this->data['column_date'] = $this->language->get('column_date');

        $this->data['button_insert'] = $this->language->get('button_insert');
        $this->data['button_filter'] = $this->language->get('button_filter');
        $this->data['button_delete'] = $this->language->get('button_delete');

        $this->data['token'] = $this->session->data['token'];

        $this->data['action'] = $this->url->link('ne/blacklist/add', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['delete'] = $this->url->link('ne/blacklist/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

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

        $url = '';

        if (isset($this->request->get['filter_email'])) {
            $url .= '&filter_email=' . $this->request->get['filter_email'];
        }

        if (isset($this->request->get['filter_date'])) {
            $url .= '&filter_date=' . $this->request->get['filter_date'];
        }

        if ($order == 'ASC') {
            $url .= '&order=' .  'DESC';
        } else {
            $url .= '&order=' .  'ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->data['sort_email'] = $this->url->link('ne/blacklist', 'token=' . $this->session->data['token'] . '&sort=email' . $url, 'SSL');
        $this->data['sort_date'] = $this->url->link('ne/blacklist', 'token=' . $this->session->data['token'] . '&sort=datetime' . $url, 'SSL');

        $url = '';

        if (isset($this->request->get['filter_email'])) {
            $url .= '&filter_email=' . $this->request->get['filter_email'];
        }

        if (isset($this->request->get['filter_date'])) {
            $url .= '&filter_date=' . $this->request->get['filter_date'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $blacklist_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('ne/blacklist', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->data['filter_email'] = $filter_email;
        $this->data['filter_date'] = $filter_date;

        $this->data['sort'] = $sort;
        $this->data['order'] = $order;

        $this->template = 'ne/blacklist.tpl';
        $this->children = array(
            'common/header',
            'common/footer',
        );

        $this->response->setOutput($this->render());
    }

    public function add() {
        $this->language->load('ne/blacklist');
        $this->load->model('ne/blacklist');

        $url = '';

        if (isset($this->request->get['filter_email'])) {
            $url .= '&filter_email=' . $this->request->get['filter_email'];
        }

        if (isset($this->request->get['filter_date'])) {
            $url .= '&filter_date=' . $this->request->get['filter_date'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        if (isset($this->request->post['emails'])) {
            $count = $this->model_ne_blacklist->add($this->request->post);
            $this->session->data['success'] = sprintf($this->language->get('text_success'), $count);
        }

        $this->redirect($this->url->link('ne/blacklist', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    }

    public function delete() {
        $this->language->load('ne/blacklist');
        $this->load->model('ne/blacklist');

        $url = '';

        if (isset($this->request->get['filter_email'])) {
            $url .= '&filter_email=' . $this->request->get['filter_email'];
        }

        if (isset($this->request->get['filter_date'])) {
            $url .= '&filter_date=' . $this->request->get['filter_date'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        if (isset($this->request->post['selected']) && $this->validate()) {
            foreach ($this->request->post['selected'] as $blacklist_id) {
                $this->model_ne_blacklist->delete($blacklist_id);
            }

            $this->session->data['success'] = $this->language->get('text_success_delete');
        }

        $this->redirect($this->url->link('ne/blacklist', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'ne/blacklist')) {
            $this->error['warning'] = $this->language->get('error_permission_delete');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}

?>