<?php
class ControllerAccountCompany extends Controller
{
    public function index()
    {
        $this->load->model('account/customer');
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        } elseif (!$this->customer->representsMultipleCompanies()) {
            $this->redirect($this->url->link('account/account'));
        }

        $this->load->language('account/company');
        $this->document->setTitle($this->language->get('heading_title'));

        if ('POST' == $_SERVER['REQUEST_METHOD'] && $this->validate()) {
            $this->session->data['company_id'] = (int)$this->request->post['company_id'];
            unset($this->session->data['order_id']);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->redirect($this->url->link('account/account', '', 'SSL'));
        }

        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
            'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('account/company', '', 'SSL'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['companies'] = $this->model_account_customer->getCompanies();

        $language_vars = array('heading_title', 'entry_company', 'button_apply');
        foreach ($language_vars as $language_var) {
            $this->data[$language_var] = $this->language->get($language_var);
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/company.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/account/company.tpl';
        } else {
            $this->template = 'default/template/account/company.tpl';
        }
        $this->children = array(
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/content_bottom',
            'common/footer',
            'common/header',
        );
        $this->response->setOutput($this->render());
    }

    protected function validate()
    {
        $this->load->model('account/customer');

        return isset($this->request->post['company_id']) && $this->model_account_customer->representsCompany($this->request->post['company_id']);
    }
}
