<?php
class ControllerApiAuth extends Controller
{
    private $log;

    public function __construct($registry)
    {
        $this->log = new Log('autologin_log.txt');
        parent::__construct($registry);
    }

    public function index()
    {
        $this->redirect($this->url->link('common/home', '', 'SSL'));
    }

    public function setupLogin()
    {
        $authorized_request = $this->config->get('config_auto_login') && isset($this->request->get['hash']) && $this->request->get['hash'] == $this->config->get('config_auto_login');
        if (!$authorized_request) {
            header('HTTP/1.0 403 Forbidden');
            exit;
        }
        $xml_object = simplexml_load_file('php://input');
        $valid_request = $xml_object !== false && $xml_object->xpath('Request/PunchOutSetupRequest/Contact/Email');
        if (!$valid_request) {
            header('HTTP/1.0 400 Bad Request');
            exit;
        } else {
            $this->load->model('account/customer');
            $customer = $this->model_account_customer->getCustomerByEmail((string)$xml_object->Request->PunchOutSetupRequest->Contact->Email);
            if (!$customer || $this->config->get('config_store_id') != $customer['store_id']) {
                header('HTTP/1.0 204 No Content');
                exit;
            }
            $token = $this->model_account_customer->setupLoginToken($customer['customer_id']);
            $this->data['login_url'] = $this->url->link('api/auth/login', '&id=' . md5($customer['customer_id']) . '&token=' . $token, 'SSL');

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/api/auth_setup_response.php')) {
                $this->template = $this->config->get('config_template') . '/template/api/auth_setup_response.php';
            } else {
                $this->template = 'default/template/api/auth_setup_response.php';
            }
            $this->response->addHeader("Content-type: text/xml;charset=utf-8");
            $this->response->setOutput($this->render());
        }
    }

    public function login()
    {
        $this->customer->logout();
        $authenticated = false;
        $this->load->model('account/customer');
        if (isset($this->request->get['id'])
            && isset($this->request->get['token'])) {
            $customer_id = $this->model_account_customer->validateLoginToken($this->request->get['id'], $this->request->get['token']);
            $customer = $this->model_account_customer->getCustomer($customer_id);
            if ($customer) {
                $authenticated = $this->customer->login($customer['email'], '', true);
            }
        }
        if ($authenticated) {
            $this->redirect($this->url->link('common/home', '', 'SSL'));
        } else {
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
    }
}
?>
