<?php
class ControllerSaleCompany extends Controller
{
    protected $error = array();

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->language->load('sale/company');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('sale/company');
    }

    public function index() 
    {
        $this->getList();
    }

    public function insert()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validate()) {
            $company_id = $this->model_sale_company->addCompany($this->request->post);
            $this->session->data['success'] = sprintf(
                $this->language->get('text_company_added'),
                $this->url->link('sale/company/update', 'token=' . $this->session->data['token'] . '&company_id=' . $company_id)
            );
            $this->redirect($this->url->link('sale/company', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        $this->getForm();
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->validate()) {
            $this->model_sale_company->editCompany($this->request->get['company_id'], $this->request->post);
            $this->session->data['success'] = sprintf(
                $this->language->get('text_company_modified'),
                $this->url->link('sale/company/update', 'token=' . $this->session->data['token'] . '&company_id=' . (int)$this->request->get['company_id'])
            );
            $this->redirect($this->url->link('sale/company', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        $this->getForm();
    }

    public function delete()
    {
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach($this->request->post['selected'] as $company_id) {
                $this->model_sale_company->deleteCompany($company_id);
            }
            $this->session->data['success'] = sprintf($this->language->get('text_deleted'), count($this->request->post['selected']));

            $url = '';
            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            $this->redirect($this->url->link('sale/company', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        $this->getList();
    }

    protected function getList()
    {
        $url = '';
        $limit = $this->config->get('config_admin_limit');
        $filter_name = '';
        $order = 'ASC';
        $page = 1;
        if (isset($this->request->get['limit']) && (int)$this->request->get['limit'] > 0) {
            $limit = (int)$this->request->get['limit'];
            $url .= '&limit=' . $limit;
        }
        if (isset($this->request->get['filter_name']) && !empty($this->request->get['filter_name'])) {
            $filter_name = $this->request->get['filter_name'];
            $url .= '&filter_name=' . urlencode(html_entity_decode($filter_name, ENT_QUOTES, 'UTF-8'));
        }
        if (isset($this->request->get['order']) && $this->request->get['order'] != 'ASC') {
            $order = 'DESC';
        }
        if (isset($this->request->get['page']) && (int)$this->request->get['page'] > 0) {
            $page = (int)$this->request->get['page'];
        }

        $pagination = new Pagination;
        $pagination->total = $this->model_sale_company->getCompanyCount(array('filter_name' => $filter_name));
        $pagination->page = $page;
        $pagination->limit = $limit;
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('sale/company', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
        $this->data['pagination'] = $pagination->render();

        $url .= '&page=' . $page;

        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('sale/company', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        $this->data['token'] = $this->session->data['token'];
        $this->data['success'] = '';
        $this->data['error_warning'] = '';
        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        }
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        }

        $this->data['insert'] = $this->url->link('sale/company/insert', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['delete'] = $this->url->link('sale/company/delete', 'token=' . $this->session->data['token'], 'SSL');

        $data = array(
            'filter_name' => $filter_name,
            'start' => ($page - 1) * $limit,
            'limit' => $limit,
            'order' => $order,
        );
        $this->data['companies'] = $this->model_sale_company->getCompanies($data);
        foreach ($this->data['companies'] as $k => $v) {
            $this->data['companies'][$k]['href'] = $this->url->link('sale/company/update', 'token=' . $this->session->data['token'] . '&company_id=' . $v['company_id'], 'SSL');
            $this->data['companies'][$k]['selected'] = isset($this->request->post['selected']) && in_array($v['company_id'], $this->request->post['selected']);
        }

        $language_vars = array('heading_title', 'button_insert', 'button_delete', 'button_edit', 'text_no_results', 'text_name', 'text_ax_code', 'text_cui', 'text_cif', 'text_action');
        foreach ($language_vars as $language_var) {
            $this->data[$language_var] = $this->language->get($language_var);
        }

        $this->template = 'sale/company_list.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
    }

    protected function getForm()
    {
        $this->load->model('sale/customer');
        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('sale/company', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['token'] = $this->session->data['token'];
        $this->data['error_warning'] = '';
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        }
        $this->data['cancel'] = $this->url->link('sale/company', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->get['company_id'])) {
            $this->data['action'] = $this->url->link('sale/company/update', 'token=' . $this->session->data['token'] . '&company_id=' . $this->request->get['company_id'], 'SSL');
        } else {
            $this->data['action'] = $this->url->link('sale/company/insert', 'token=' . $this->session->data['token'], 'SSL');
        }

        $company_info = array();
        if ($_SERVER['REQUEST_METHOD'] != 'POST' && isset($this->request->get['company_id'])) {
            $company_info = $this->model_sale_company->getCompany($this->request->get['company_id']);
        }

        if (isset($this->request->post['name'])) {
            $this->data['name'] = $this->request->post['name'];
        } elseif (!empty($company_info)) {
            $this->data['name'] = $company_info['name'];
        } else {
            $this->data['name'] = '';
        }

        if (isset($this->request->post['ax_code'])) {
            $this->data['ax_code'] = $this->request->post['ax_code'];
        } elseif (!empty($company_info)) {
            $this->data['ax_code'] = $company_info['ax_code'];
        } else {
            $this->data['ax_code'] = '';
        }

        if (isset($this->request->post['cui'])) {
            $this->data['cui'] = $this->request->post['cui'];
        } elseif (!empty($company_info)) {
            $this->data['cui'] = $company_info['CUI'];
        } else {
            $this->data['cui'] = '';
        }

        if (isset($this->request->post['cif'])) {
            $this->data['cif'] = $this->request->post['cif'];
        } elseif (!empty($company_info)) {
            $this->data['cif'] = $company_info['CIF'];
        } else {
            $this->data['cif'] = '';
        }

        if (isset($this->request->post['customers'])) {
            $this->data['customers'] = $this->model_sale_customer->getCustomers(array('filter_ids' => $this->request->post['customers']));
        } elseif (!empty($company_info)) {
            $this->data['customers'] = $this->model_sale_customer->getCustomers(array('filter_ids' => $this->model_sale_company->getCompanyCustomers($this->request->get['company_id'])));
        } else {
            $this->data['customers'] = array();
        }

        $error_vars = array('name', 'cif', 'cui', 'ax_code');
        foreach ($error_vars as $error_var) {
            $this->data['error_' . $error_var] = isset($this->error[$error_var]) ? $this->error[$error_var] : '';
        }

        $language_vars = array(
            'heading_title',
            'button_cancel',
            'button_remove',
            'button_save',
            'tab_general',
            'tab_customers',
            'text_add_customer',
            'text_ax_code',
            'text_cif',
            'text_cui',
            'text_name',
            'text_no_results',
        );
        foreach ($language_vars as $language_var) {
            $this->data[$language_var] = $this->language->get($language_var);
        }

        $this->template = 'sale/company_form.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'sale/company')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        if (!isset($this->request->post['name']) || !$this->request->post['name']) {
            $this->error['name'] = $this->language->get('error_name');
        }
        if (isset($this->request->post['cui'])) {
            $cui_taken = $this->model_sale_company->getCompanyByCUI($this->request->post['cui']);
            if ($cui_taken && (!isset($this->request->get['company_id']) || $this->request->get['company_id'] != $cui_taken['company_id'])) {
                $this->error['cui'] = sprintf(
                    $this->language->get('error_not_unique'),
                    $this->language->get('text_cui'),
                    $this->url->link('sale/company/update', 'token=' . $this->session->data['token'] . '&company_id=' . $cui_taken['company_id'])
                );
            }
        }
        if (isset($this->request->post['cif'])) {
            if (!(int)$this->request->post['cif'] || (int)$this->request->post['cif'] < 1) {
                $this->error['cif'] = $this->language->get('error_cif_not_numeric');
            } else {
                $cif_taken = $this->model_sale_company->getCompanyByCIF($this->request->post['cif']);
                if ($cif_taken && (!isset($this->request->get['company_id']) || $this->request->get['company_id'] != $cif_taken['company_id'])) {
                    $this->error['cif'] = sprintf(
                        $this->language->get('error_not_unique'),
                        $this->language->get('text_cif'),
                        $this->url->link('sale/company/update', 'token=' . $this->session->data['token'] . '&company_id=' . $cif_taken['company_id'])
                    );
                }
            }
        }
        if (isset($this->request->post['ax_code'])) {
            $ax_code_taken = $this->model_sale_company->getCompanyByAxCode($this->request->post['ax_code']);
            if ($ax_code_taken && (!isset($this->request->get['company_id']) || $this->request->get['company_id'] != $ax_code_taken['company_id'])) {
                $this->error['ax_code'] = sprintf(
                    $this->language->get('error_not_unique'),
                    $this->language->get('text_ax_code'),
                    $this->url->link('sale/company/update', 'token=' . $this->session->data['token'] . '&company_id=' . $ax_code_taken['company_id'])
                );
            }
        }

        return !(bool)$this->error;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'sale/company')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !(bool)$this->error;
    }
}
