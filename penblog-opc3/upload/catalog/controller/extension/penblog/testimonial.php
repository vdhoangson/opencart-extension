<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerExtensionPenBlogTestimonial extends Controller {
	private $error = array();

	public function index() {
		$languages = $this->language->load('extension/penblog/testimonial');
		foreach($languages as $key => $value){
			$data[$key] = $value;
		}

		$this->load->model('extension/penblog/testimonial');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_extension_penblog_testimonial->addTestimonial($this->request->post);
			$this->response->redirect($this->url->link('extension/penblog/testimonial/success'));
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/penblog/testimonial')
		);

		$error_array = array('name', 'telephone', 'email', 'message', 'rating', 'captcha');

		foreach($error_array as $key){
			if (isset($this->error[$key])) {
				$data['error_'.$key] = $this->error[$key];
			} else {
				$data['error_'.$key] = '';
			}
		}

		$data['back'] = $this->url->link('common/home');
    	$data['button_continue'] = $this->language->get('button_continue');
		$data['action'] = $this->url->link('extension/penblog/testimonial');

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} else {
			$data['name'] = $this->customer->getFirstName();
		}
		if (isset($this->request->post['avatar'])) {
			$data['avatar'] = $this->request->post['avatar'];
		} else {
			$data['avatar'] = 'image/catalog/penblog/avatar.png';
		}

		$this->load->model('tool/image');

		$data['no_image'] = 'image/catalog/penblog/avatar.png';

		if (isset($this->request->post['avatar']) && file_exists(DIR_IMAGE . $this->request->post['avatar'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['avatar'], 100, 100);
		} else {
			$data['thumb'] = 'image/catalog/penblog/avatar.png';
		}

		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} else {
			$data['telephone'] = '';
		}
		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = $this->customer->getEmail();
		}
		if (isset($this->request->post['company'])) {
			$data['company'] = $this->request->post['company'];
		} else {
			$data['company'] = '';
		}
		if (isset($this->request->post['competence'])) {
			$data['competence'] = $this->request->post['competence'];
		} else {
			$data['competence'] = '';
		}

		if (isset($this->request->post['message'])) {
			$data['message'] = $this->request->post['message'];
		} else {
			$data['message'] = '';
		}

		if (isset($this->request->post['rating'])) {
			$data['rating'] = $this->request->post['rating'];
		}else {
			$data['rating'] = '';
		}

		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status')) {
				$data['captcha'] = $this->load->controller('captcha/' . $this->config->get('config_captcha'));
			} else {
				$data['captcha'] = '';
			}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$template = 'extension/penblog/testimonial';
		$this->response->setOutput($this->load->view($template, $data));
	}

	public function image() {

		$language_data = $this->language->load('extension/penblog/testimonial');
		$this->load->model('tool/image');
		$json = array();

		if (!empty($this->request->files['file']['name'])) {
			$full_filename = basename(html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8'));
			if ((utf8_strlen($full_filename) < 3) || (utf8_strlen($full_filename) > 128)) {
				$json['error'] = $this->language->get('error_filename');
			}
			$filename=(string)$full_filename;
			/**/ $full_name = explode(".",$filename);
			$filename_prefix =$full_name[0];
			$filename_ext =substr(strrchr($filename, '.'), 1);
			$filename = $filename_prefix.'.'.$filename_ext;
			$allowed = array();/*1*/
			$filetypes = explode(',', 'jpg,png,gif');/*2*/
			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}/*3*/
			if (!in_array(substr(strrchr($filename, '.'), 1), $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
       		}
			if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
			}
			/*
			if ($this->request->files['file']['size']>40000) {
				$json['error'] = $this->language->get('error_upload_file_size');
			}		*/
			$img_info = getimagesize($this->request->files["file"]["tmp_name"]);
			$img_width = $img_info[0];
			$img_height = $img_info[1];
			if ($img_width>480||$img_height>480) {
				$json['error'] = $this->language->get('error_upload_file_dimension');
			}
		} else {
			$json['error'] = $this->language->get('error_upload');
		}

		if (!isset($json['error'])) {
			if (is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
				$ext = substr(md5(mt_rand()),0,8);
				if (!is_dir(DIR_IMAGE.'catalog/clients/')){
					@mkdir(DIR_IMAGE.'catalog/clients/',  0777, true);
				}
				move_uploaded_file($this->request->files['file']['tmp_name'], DIR_IMAGE.'catalog/clients/'.$ext.'.'.$filename);
				$json['filename'] = 'catalog/clients/'.$ext.'.'.$filename;
				$json['thumb']= $this->model_tool_image->resize('catalog/clients/'.$ext.'.'.$filename, 100, 100);
		}

			$json['success'] = $this->language->get('text_success_upload');
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function validate() {
		/*customer*/
    	if ((utf8_strlen($this->request->post['name']) < 1) || (utf8_strlen($this->request->post['name']) > 32)) {
      		$this->error['name'] = $this->language->get('error_name');
    	}
    	if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		$this->error['email'] = $this->language->get('error_email');
    	}
		/*message*/
		if ((utf8_strlen($this->request->post['message']) < 15) || (utf8_strlen($this->request->post['message']) > 1500)) {
      		$this->error['message'] = $this->language->get('error_message');
    	}

		if (!isset($this->request->post['rating'])) {
			$this->error['rating'] = $this->language->get('error_rating');
		}
		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('contact', (array)$this->config->get('config_captcha_page'))) {
			$captcha = $this->load->controller('captcha/' . $this->config->get('config_captcha') . '/validate');

			if ($captcha) {
				$this->error['captcha'] = $captcha;
			}
		}

		return !$this->error;
  	}

	public function success() {
		$this->language->load('extension/penblog/testimonial');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/penblog/testimonial')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_message'] = 'Your testtimonial send success!';

		$data['button_continue'] = $this->language->get('button_continue');

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$template = 'common/success';
		$this->response->setOutput($this->load->view($template, $data));
	}
}
