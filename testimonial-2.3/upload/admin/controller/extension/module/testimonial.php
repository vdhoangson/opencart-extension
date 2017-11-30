<?php
class ControllerExtensionModuleTestimonial extends Controller {
	private $error = array();

	public function index() {
		$languages = $this->load->language('extension/module/testimonial');
		foreach($languages as $key => $value){
			$data[$key] = $value;
		}

		$this->document->SetTitle( $this->language->get('heading_title'));

		$this->load->model('setting/setting');

    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('testimonial', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}


 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['token'] = $this->session->data['token'];

  		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/testimonial', 'token=' . $this->session->data['token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/testimonial', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/testimonial', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/testimonial', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$data['edit_testimonials_path'] = $this->url->link('catalog/testimonial', 'token=' . $this->session->data['token'], 'SSL');

		$data_array = array(
			'testimonial_name' => '',
			'testimonial_admin_approved' => 0,
			'testimonial_default_rating' => 1,
			'testimonial_send_to_admin' => 0,
			'testimonial_all_page_limit' => 10,
			'testimonial_limit' => 6,
			'testimonial_random' => 0,
			'testimonial_character_limit' => 60,
			'testimonial_status' => 1
		);

		foreach($data_array as $key => $value){
			if (isset($this->request->post[$key])) {
				$data[$key] = $this->request->post[$key];
			} else {
				$data[$key] = $this->config->get($key);
			}
		}


		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();


		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/testimonial.tpl', $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/testimonial')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}


	public function install() {
		$this->load->model('catalog/testimonial');
		$this->model_catalog_testimonial->createDatabaseTables();
	}

	public function uninstall() {

		$this->load->model('catalog/testimonial');
		$this->model_catalog_testimonial->dropDatabaseTables();
	}
}