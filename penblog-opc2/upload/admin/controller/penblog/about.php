<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerPenBlogAbout extends Controller {
	public function index() {
		$languages = $this->load->language('penblog/about');

		$this->document->setTitle($this->language->get('heading_title'));

		foreach ($languages as $key => $text) {
			$data[$key] = $text;
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('penblog_dashboard'),
			'href' => $this->url->link('penblog/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('penblog/about', 'token=' . $this->session->data['token'], true),
		);

		$this->load->model('penblog/setup');

		$curent_version = $this->config->get('penblog_version');
		$latest_version = $this->model_penblog_setup->getVersion();

		$data['token'] = $this->session->data['token'];

		$data['update'] = false;

		$data['btn_update'] = $this->url->link('penblog/about/update', 'token=' . $this->session->data['token'], true);

		if($curent_version!=$latest_version){
			$data['update'] = true;
		}

		$data['curent_version'] = $curent_version;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['shortcut'] = $this->load->controller('penblog/shortcut');

		$this->response->setOutput($this->load->view('penblog/about.tpl', $data));
	}

	public function update(){
		$this->load->model('penblog/setup');

		$this->model_penblog_setup->update();

		$this->response->redirect($this->url->link('penblog/dashboard', 'token=' . $this->session->data['token'], true));
	}
}
?>