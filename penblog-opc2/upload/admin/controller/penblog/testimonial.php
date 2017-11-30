<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerPenBlogTestimonial extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('penblog/testimonial');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->checkVersion();

		$this->load->model('penblog/testimonial');

		$this->getList();
	}

	public function add() {
		$this->load->language('penblog/testimonial');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('penblog/testimonial');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_penblog_testimonial->addTestimonial($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('penblog/testimonial', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('penblog/testimonial');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('penblog/testimonial');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_penblog_testimonial->editTestimonial($this->request->get['testimonial_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('penblog/testimonial', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('penblog/testimonial');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('penblog/testimonial');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $testimonial_id) {
				$this->model_penblog_testimonial->deleteTestimonial($testimonial_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('penblog/testimonial', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		$language_data = $this->load->language('penblog/testimonial');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}

		if (isset($this->request->get['filter_rating'])) {
			$filter_rating = $this->request->get['filter_rating'];
		} else {
			$filter_rating = null;
		}

		if (isset($this->request->get['filter_read'])) {
			$filter_read = $this->request->get['filter_read'];
		} else {
			$filter_read = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		$this->load->model('penblog/testimonial');

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'r.date_added';
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
			
		if (isset($this->request->get['filter_rating'])) {
			$url .= '&filter_rating=' . urlencode(html_entity_decode($this->request->get['filter_rating'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_read'])) {
			$url .= '&filter_read=' . urlencode(html_entity_decode($this->request->get['filter_read'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('penblog/testimonial', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('penblog/testimonial/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('penblog/testimonial/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['testimonials'] = array();

		$filter_data = array(
			'filter_rating'	  => $filter_rating,
			'filter_read'	  => $filter_read,
			'filter_status'   => $filter_status,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$testimonial_total = $this->model_penblog_testimonial->getTotalTestimonials();

		$results = $this->model_penblog_testimonial->getTestimonials($filter_data);

		$this->load->model('tool/image');

		foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('penblog/testimonial/edit', 'token=' . $this->session->data['token'] . '&testimonial_id=' . $result['testimonial_id'] . $url, true)
			);

			if ($result['avatar'] && file_exists(DIR_IMAGE . $result['avatar'])) {
				$avatar = $this->model_tool_image->resize($result['avatar'], 64, 64);
			} else {
				$avatar = $this->model_tool_image->resize('placeholder.png', 64, 64);
			}	

			$data['testimonials'][] = array(
				'testimonial_id'  => $result['testimonial_id'],
				'competence'     => $result['competence'],
				'customer_name'     => $result['customer_name'],
				'rating'     => $result['rating'],
				'status'     =>($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'avatar'     => $avatar,
				'read'     => ($result['read'] ? $this->language->get('text_read') : $this->language->get('text_unread')),
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'selected'   => isset($this->request->post['selected']) && in_array($result['testimonial_id'], $this->request->post['selected']),
				'action'     => $action
			);
		}

		$data['token'] = $this->session->data['token'];

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

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_rating'])) {
			$url .= '&filter_rating=' . urlencode(html_entity_decode($this->request->get['filter_rating'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_read'])) {
			$url .= '&filter_read=' . urlencode(html_entity_decode($this->request->get['filter_read'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_customer'] = $this->url->link('penblog/testimonial', 'token=' . $this->session->data['token'] . '&sort=r.customer_name' . $url, true);
		$data['sort_service'] = $this->url->link('penblog/testimonial', 'token=' . $this->session->data['token'] . '&sort=r.service_id' . $url, true);
		$data['sort_read'] = $this->url->link('penblog/testimonial', 'token=' . $this->session->data['token'] . '&sort=r.read' . $url, true);
		$data['sort_rating'] = $this->url->link('penblog/testimonial', 'token=' . $this->session->data['token'] . '&sort=r.rating' . $url, true);
		$data['sort_status'] = $this->url->link('penblog/testimonial', 'token=' . $this->session->data['token'] . '&sort=r.status' . $url, true);
		$data['sort_date_added'] = $this->url->link('penblog/testimonial', 'token=' . $this->session->data['token'] . '&sort=r.date_added' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_rating'])) {
			$url .= '&filter_rating=' . urlencode(html_entity_decode($this->request->get['filter_rating'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_read'])) {
			$url .= '&filter_read=' . urlencode(html_entity_decode($this->request->get['filter_read'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $testimonial_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('penblog/testimonial', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($testimonial_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($testimonial_total - $this->config->get('config_limit_admin'))) ? $testimonial_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $testimonial_total, ceil($testimonial_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['filter_rating'] = $filter_rating;
		$data['filter_read'] = $filter_read;
		$data['filter_status'] = $filter_status;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['shortcut'] = $this->load->controller('penblog/shortcut');

		if((int)substr((string)str_replace('.','',VERSION),0,3) > 210){
		   $template = 'penblog/testimonial_list';
	  	}else{
		   $template = 'penblog/testimonial_list.tpl';
	  	}
		$this->response->setOutput($this->load->view($template, $data));

	}

	protected function getForm() {
		$languages = $this->language->load('penblog/testimonial');
		foreach($languages as $key => $value){
			$data[$key] = $value;
		}
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['testimonial_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$errors = array('warning', 'customer_name', 'customer_telephone', 'customer_email', 'message', 'rating');

		foreach($errors as $er_key){
			if (isset($this->error[$er_key])) {
				$data['error_'.$er_key] = $this->error[$er_key];
			} else {
				$data['error_'.$er_key] = '';
			}
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('penblog/testimonial', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['testimonial_id'])) {
			$data['action'] = $this->url->link('penblog/testimonial/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('penblog/testimonial/edit', 'token=' . $this->session->data['token'] . '&testimonial_id=' . $this->request->get['testimonial_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('penblog/testimonial', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['testimonial_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$testimonial_info = $this->model_penblog_testimonial->getTestimonial($this->request->get['testimonial_id']);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['avatar'])) {
			$data['avatar'] = $this->request->post['avatar'];
		} elseif (!empty($testimonial_info)) {
			$data['avatar'] = $testimonial_info['avatar'];
		} else {
			$data['avatar'] = '';
		}
		
		$this->load->model('tool/image');

		if (isset($this->request->post['avatar']) && file_exists(DIR_IMAGE . $this->request->post['avatar'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['avatar'], 100, 100);
		} elseif (!empty($testimonial_info) && $testimonial_info['avatar'] && file_exists(DIR_IMAGE . $testimonial_info['avatar'])) {
			$data['thumb'] = $this->model_tool_image->resize($testimonial_info['avatar'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('placeholder.png', 100, 100);
		}
		
		$data['placeholder'] = $this->model_tool_image->resize('placeholder.png', 100, 100);

		$default_data = array(
			'avatar' => '',
			'customer_name' => 'Son Vo',
			'customer_telephone' => '123456789',
			'customer_email' => 'your_email@pencms.com',
			'customer_company' => 'pencms.com',
			'competence' => 'Developer',
			'message' => 'Hello',
			'rating' => 1,
			'read' => 0
		);
		foreach($default_data as $key => $value){
			if (isset($this->request->post[$key])) {
				$data[$key] = $this->request->post[$key];
			} elseif (!empty($testimonial_info)) {
				$data[$key] = $testimonial_info[$key];
			} else {
				$data[$key] = $value;
			}
		}
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($testimonial_info)) {
			$data['status'] = $testimonial_info['status'];
		} else {
			$data['status'] = true;
		}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['shortcut'] = $this->load->controller('penblog/shortcut');

		if((int)substr((string)str_replace('.','',VERSION),0,3) > 210){
		   $template = 'penblog/testimonial_form';
	  	}else{
		   $template = 'penblog/testimonial_form.tpl';
	  	}
		$this->response->setOutput($this->load->view($template, $data));

	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'penblog/testimonial')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['customer_name']) < 1) || (utf8_strlen($this->request->post['customer_name']) > 64)) {
			$this->error['customer_name'] = $this->language->get('error_customer_name');
		}
		
    	if ((utf8_strlen($this->request->post['customer_email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['customer_email'])) {
      		$this->error['customer_email'] = $this->language->get('error_customer_email');
    	}
		/**/ 	
		
		if ((utf8_strlen($this->request->post['message']) < 15) || (utf8_strlen($this->request->post['message']) > 3000)) {
			$this->error['message'] = $this->language->get('error_message');
		}
		
		if (!isset($this->request->post['rating'])) {
			$this->error['rating'] = $this->language->get('error_rating');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'penblog/testimonial')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}


	public function install() {
		$this->load->language('extension/module');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/extension');

		$this->load->model('extension/module');

		if ($this->validate()) {
			$this->model_extension_extension->install('module', $this->request->get['extension']);

			$this->load->model('user/user_group');

			$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'module/' . $this->request->get['extension']);
			$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'module/' . $this->request->get['extension']);

			// Call install method if it exsits
			$this->load->controller('module/' . $this->request->get['extension'] . '/install');

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}

		$this->getList();
	}

	public function uninstall() {
		$this->load->language('extension/module');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/extension');

		$this->load->model('extension/module');

		if ($this->validate()) {
			$this->model_extension_extension->uninstall('module', $this->request->get['extension']);

			$this->model_extension_module->deleteModulesByCode($this->request->get['extension']);

			// Call uninstall method if it exsits
			$this->load->controller('module/' . $this->request->get['extension'] . '/uninstall');

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}

		$this->getList();
	}

	public function checkVersion(){
		if($this->config->get('penblog_version')){
			return true;
		} else {
			$this->response->redirect($this->url->link('penblog/about', 'token=' . $this->session->data['token'], true));
		}
	}

}