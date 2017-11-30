<?php
class ControllerCatalogPenTab extends Controller {
	private $error = array();

	public function index() {
		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/pen_tab');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/pen_tab');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_pen_tab->addTab($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success_insert');

			$this->response->redirect($this->url->link('catalog/pen_tab', 'token=' . $this->session->data['token'], true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/pen_tab');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/pen_tab');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_pen_tab->editTab($this->request->get['tab_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success_update');

			$this->response->redirect($this->url->link('catalog/pen_tab', 'token=' . $this->session->data['token'], true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/pen_tab');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/pen_tab');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $tab_id) {
				$this->model_catalog_pen_tab->deleteTab($tab_id);
			}

			$this->session->data['success'] = $this->language->get('text_success_delete');

			$this->response->redirect($this->url->link('catalog/pen_tab', 'token=' . $this->session->data['token'], true));
		}

		$this->getList();
	}

	private function getList() {
		$this->checkDatabase();

		$languages = $this->language->load('catalog/pen_tab');
		foreach($languages as $key => $value){
			$data[$key] = $value;
		}

   		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], true),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/pen_tab', 'token=' . $this->session->data['token'], true),
      		'separator' => ' :: '
   		);

		$this->document->setTitle($this->language->get('heading_title'));

		$data['add'] = $this->url->link('catalog/pen_tab/add', 'token=' . $this->session->data['token'], true);
		$data['delete'] = $this->url->link('catalog/pen_tab/delete', 'token=' . $this->session->data['token'], true);

		$data['tabs'] = array();

		$this->load->model('catalog/pen_tab');

		$results = $this->model_catalog_pen_tab->getTabs();

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/pen_tab/edit', 'token=' . $this->session->data['token'] . '&tab_id=' . $result['tab_id'], true)
			);

			$data['tabs'][] = array(
				'tab_id'      => $result['tab_id'],
				'title'       => $result['title'],
				'sort_order'  => $result['sort_order'],
                'status'      => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'    => isset($this->request->post['selected']) && in_array($result['tab_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');
		$data['column_left'] = $this->load->controller('common/column_left');

		$template = 'catalog/pen_tab_list';

		$this->response->setOutput($this->load->view($template, $data));
	}

	private function getForm() {
		$languages = $this->language->load('catalog/pen_tab');
		foreach($languages as $key => $value){
			$data[$key] = $value;
		}
		$data['text_form'] = !isset($this->request->get['tab_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

 		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = array();
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], true),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/pen_tab', 'token=' . $this->session->data['token'], true),
      		'separator' => ' :: '
   		);

		if (!isset($this->request->get['tab_id'])) {
			$data['action'] = $this->url->link('catalog/pen_tab/add', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('catalog/pen_tab/edit', 'token=' . $this->session->data['token'] . '&tab_id=' . $this->request->get['tab_id'], true);
		}

		$data['cancel'] = $this->url->link('catalog/pen_tab', 'token=' . $this->session->data['token'], true);

		if (isset($this->request->get['tab_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$tab_info = $this->model_catalog_pen_tab->getTab($this->request->get['tab_id']);
    	}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['tab_description'])) {
			$data['tab_description'] = $this->request->post['tab_description'];
		} elseif (isset($this->request->get['tab_id'])) {
			$data['tab_description'] = $this->model_catalog_pen_tab->getTabDescriptions($this->request->get['tab_id']);
		} else {
			$data['tab_description'] = array();
		}

        if (isset($this->request->post['position'])) {
			$data['position'] = $this->request->post['position'];
		} elseif (!empty($tab_info)) {
			$data['position'] = $tab_info['position'];
		} else {
			$data['position'] = 2;
		}

        if (isset($this->request->post['compare'])) {
			$data['compare'] = $this->request->post['compare'];
		} elseif (!empty($tab_info)) {
			$data['compare'] = $tab_info['compare'];
		} else {
			$data['compare'] = 0;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($tab_info)) {
			$data['sort_order'] = $tab_info['sort_order'];
		} else {
			$data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($tab_info)) {
			$data['status'] = $tab_info['status'];
		} else {
			$data['status'] = 1;
		}

		// Categories
		$this->load->model('catalog/category');

		if (isset($this->request->post['tab_category'])) {
			$categories = $this->request->post['tab_category'];
		} elseif (isset($this->request->get['tab_id'])) {
			$categories = $this->model_catalog_pen_tab->getTabCategories($this->request->get['tab_id']);
		} else {
			$categories = array();
		}

		$data['tab_categories'] = array();

		foreach ($categories as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
				$data['tab_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name'        => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
				);
			}
		}

		// Product
		$this->load->model('catalog/product');

		if (isset($this->request->post['tab_product'])) {
			$products = $this->request->post['tab_product'];
		} elseif (isset($this->request->get['tab_id'])) {
			$products = $this->model_catalog_pen_tab->getTabProducts($this->request->get['tab_id']);
		} else {
			$products = array();
		}

		$data['tab_products'] = array();

		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);

			if ($product_info) {
				$data['tab_products'][] = array(
					'product_id' => $product_info['product_id'],
					'name'        => $product_info['name']
				);
			}
		}

		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');
		$data['column_left'] = $this->load->controller('common/column_left');

		$template = 'catalog/pen_tab_form';

		$this->response->setOutput($this->load->view($template, $data));
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/pen_tab')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['tab_description'] as $language_id => $value) {
			if ((utf8_strlen($value['title']) < 2) || (utf8_strlen($value['title']) > 64)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/pen_tab')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

    private function checkDatabase() {
		$this->load->model('catalog/pen_tab');
		$this->model_catalog_pen_tab->installDb();
    }
}
?>