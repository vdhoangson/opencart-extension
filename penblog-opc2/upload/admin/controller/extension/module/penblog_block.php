<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerExtensionModulePenBlogBlock extends Controller {
	private $error = array();

	public function index() {
		$languages = $this->load->language('extension/module/penblog_block');
		foreach($languages as $key => $value){
			$data[$key] = $value;
		}

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('penblog_block', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module/penblog_block', 'token=' . $this->session->data['token'], true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = '';
		}


		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('penblog_dashboard'),
			'href' => $this->url->link('penblog/dashboard', 'token=' . $this->session->data['token'], true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/penblog_block', 'token=' . $this->session->data['token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/penblog_block', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/penblog_block', 'token=' . $this->session->data['token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/penblog_block', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('penblog/dashboard', 'token=' . $this->session->data['token'], true);
		$data['add_new_module'] = $this->url->link('extension/module/penblog_block', 'token=' . $this->session->data['token'], true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}


		$data['module_id'] = isset($this->request->get['module_id'])?$this->request->get['module_id']:0;

		$data['elements'] = array();

		$files = glob(DIR_APPLICATION . 'controller/penblog_block/*.php');

		if ($files) {
			foreach ($files as $file) {
				$block = basename($file, '.php');
				$this->load->language('penblog_block/' . $block);

				$data['elements'][] = array(
					'title'      => $this->language->get('block_title'),
					'key'   => $block,
					'href'  => $this->url->link('extension/module/penblog_block', 'token=' . $this->session->data['token'].'&block='.$block)
				);
			}
		}

		$data_config = array(
			'name' => '',
			'title' => array(1=>''),
			'block' => isset($this->request->get['block'])?$this->request->get['block']:'',
			'block_data' => $this->getBlockData(),
			'status' => 0
		);

        $data['orders'] = array(
            'default' => $this->language->get('text_default'),
            'latest' => $this->language->get('text_latest'),
            'most_view' => $this->language->get('text_most_view'),
        );

        $blocks = array();

		foreach($data_config as $key => $value){
			if (isset($this->request->post[$key])) {
                $blocks[$key] = $data[$key] = $this->request->post[$key];
	        } elseif (!empty($module_info[$key])) {
	            $blocks[$key] = $data[$key] = $module_info[$key];
	        } else {
                $blocks[$key] = $data[$key] = $value;
	        }
		}

		//Category
		$this->load->model('penblog/category');

		$data['categories'] = $this->model_penblog_category->getCategories(0);

		// Article
		$this->load->model('penblog/article');

		$data['articles'] = $this->model_penblog_article->getArticles(0);

		// Installed block
		$data['modules_installed'] = $this->getInstalledModule();

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$data['module_content'] = '';
		if(isset($this->request->get['block'])){
			if(file_exists(DIR_APPLICATION . 'controller/penblog_block/' . $this->request->get['block']. '.php')){
				$data['module_content'] = $this->load->controller('penblog_block/'.$this->request->get['block'], $data);
			}
		} elseif(!empty($module_info['block'])){
			if(file_exists(DIR_APPLICATION . 'controller/penblog_block/' . $module_info['block'] . '.php')){
				$data['module_content'] = $this->load->controller('penblog_block/'.$module_info['block'], $data);
			}
		} 
			

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['shortcut'] = $this->load->controller('penblog/shortcut');

		$this->response->setOutput($this->load->view('extension/module/penblog_block.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/penblog_block')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		foreach ($this->request->post['title'] as $language_id => $value) {

			if ((utf8_strlen($value) < 3)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}
		}


		return !$this->error;
	}

	public function getInstalledModule(){
		$this->load->model('extension/extension');
		
		$this->load->model('extension/module');

		$installed_modules = array();
		// Get installed modules
		$modules = $this->model_extension_module->getModulesByCode('penblog_block');

		if($modules){
			foreach ($modules as $module) {
				$installed_modules[] = array(
					'module_id' => $module['module_id'],
					'name'   => $module['name'],
					'code'   => $module['code'],
					'edit'      => $this->url->link('extension/module/penblog_block', 'token=' . $this->session->data['token'] . '&module_id=' . $module['module_id'], true)
				);
			}
		}

		return $installed_modules;
	}

	private function getBlockData(){
		$block_data =  array(
			'block_articles' => array(),
			'block_categories' => array(),
			'display' => 'grid',
			'limit' => 6,
			'image_width' => 220,
			'image_height' => 220,
			'autoscroll' => 1,
			'pauseonhover' => 1,
			'show_nav' => 1,
			'show_dot' => 1
		);
		return $block_data;
	}

	public function install(){
		$this->load->model('penblog/setup');
		$this->model_penblog_setup->install();
		$this->response->redirect($this->url->link('penblog/dashboard', 'token=' . $this->session->data['token'], true));
	}

	public function uninstall(){
		$this->load->model('penblog/setup');
		$this->model_penblog_setup->uninstall();
	}
}
