<?php
/**
* 
*/
class ControllerProductFastOrder extends Controller
{
    public function index()
    {
        if(!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('product/fast_order', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->language->load('product/fast_order');
        $this->document->setTitle($this->language->get('heading_title'));

        $language_vars = array(
            'heading_title',
            'entry_search_product',
            'entry_color',
            'entry_size',
            'text_stock',
            'text_price',
            'text_pieces',
            'text_packages',
            'text_search_placeholder',
            'text_select_color',
            'text_select_size',
            'text_without_vat',
            'button_add',
            'column_product',
            'column_total',
            'column_quantity',
            'button_remove',
            'button_cart'
        );
        foreach ($language_vars as $language_var) {
            $this->data[$language_var] = $this->language->get($language_var);
        }
        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
            'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title' ),
            'href' => $this->url->link('product/fast_order', '', 'SSL' ),
            'separator' => $this->language->get('text_separator')
        );
        $this->data['action'] = $this->url->link('checkout/cart/addmultiple', '', 'SSL');
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/fast_order.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/product/fast_order.tpl';
        }
        else {
            $this->template = 'default/template/product/fast_order.tpl';
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
}

?>
