<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerExtensionPenBlogSetting extends Controller {
	private $error = array();

	public function index() {
		$languages = $this->load->language('extension/penblog/setting');

		$this->document->setTitle($this->language->get('heading_title'));

		foreach ($languages as $key => $text) {
			$data[$key] = $text;
		}

		$this->load->model('extension/penblog/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_extension_penblog_setting->editSetting('penblog', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/penblog/setting', 'user_token=' . $this->session->data['user_token'], true));
		}

		$data['button_save'] = $this->language->get('button_save');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_image'] = $this->language->get('tab_image');

		/* Error */
		$error_array = array(
			'warning', 'catalog_image', 'catalog_image_article', 'article_additional', 'article_thumb', 'article_popup','article_related', 'article_product'
		);

		foreach($error_array as $error) {
			if (isset($this->error[$error])) {
				$data['error_'.$error] = $this->error[$error];
			} else {
				$data['error_'.$error] = '';
			}
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true),
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('penblog_dashboard'),
			'href' => $this->url->link('extension/penblog/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/penblog/setting', 'user_token=' . $this->session->data['user_token'], true),
		);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['action'] = $this->url->link('extension/penblog/setting', 'user_token=' . $this->session->data['user_token'], true);

		$data['user_token'] = $this->session->data['user_token'];

		$results_setting = $this->config->get('penblog_setting');

		$setting_default = $this->getFormValue();

		foreach($setting_default as $key => $value){
			if(isset($this->request->post['penblog_setting'][$key])){
				$data[$key] = $this->request->post['penblog_setting'][$key];
			} elseif(isset($results_setting[$key])) {
				$data[$key] = $results_setting[$key];
			} else {
				$data[$key] = $value;
			}
		}

		$data['catalog_limits'] = array(5,10,15,20);
		$data['admin_limits'] = array(5,10,15,20);
		$data['date_formats'] = array(
			'd-m-y' => 'd-m-y (08-03-92)',
			'y-m-d' => 'y-m-d (92-03-08)',
			'd-m-Y' => 'd-m-Y (08-03-1992)',
			'Y-m-d' => 'Y-m-d (1992-03-08)',
			'd/m/y' => 'd/m/Y (08/03/92)',
			'd/m/Y' => 'd/m/Y (08/03/1992)',
			'Y/m/d' => 'Y/m/d (1992/08/03)',
		);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['shortcut'] = $this->load->controller('extension/penblog/shortcut');

		$this->response->setOutput($this->load->view('extension/penblog/setting', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/penblog/setting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		//Catalog image
		if (empty($this->request->post['penblog_setting']['catalog_image_width']) || empty($this->request->post['penblog_setting']['catalog_image_height'])) {
			$this->error['catalog_image'] = $this->language->get('error_image_category');
		}

		if (empty($this->request->post['penblog_setting']['catalog_image_article_width']) || empty($this->request->post['penblog_setting']['catalog_image_article_height'])) {
					$this->error['catalog_image_article'] = $this->language->get('error_catalog_image_article');
		}

		//Aritlce image
		if (empty($this->request->post['penblog_setting']['article_thumb_width']) || empty($this->request->post['penblog_setting']['article_thumb_height'])) {
			$this->error['article_thumb'] = $this->language->get('error_article_thumb');
		}

		if (empty($this->request->post['penblog_setting']['article_popup_width']) || empty($this->request->post['penblog_setting']['article_popup_height'])) {
			$this->error['article_popup'] = $this->language->get('error_article_popup');
		}

		if (empty($this->request->post['penblog_setting']['article_additional_width']) || empty($this->request->post['penblog_setting']['article_additional_height'])) {
			$this->error['article_additional'] = $this->language->get('error_article_additional');
		}

		if (empty($this->request->post['penblog_setting']['article_related_width']) || empty($this->request->post['penblog_setting']['article_related_height'])) {
			$this->error['article_related'] = $this->language->get('error_article_related');
		}

		if (empty($this->request->post['penblog_setting']['article_product_width']) || empty($this->request->post['penblog_setting']['article_product_height'])) {
			$this->error['article_product'] = $this->language->get('error_article_product');
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

	private function getFormValue(){
		return array(
			//Category
			'catalog_limit'                => 10,
			'catalog_show_filter'          => 1,
			'catalog_show_author'          => 1,
			'catalog_show_viewed'          => 1,
			'catalog_show_date_added'      => 1,
			'catalog_show_date_modified'   => 1,
			'catalog_image_width'          => 180,
			'catalog_image_height'         => 180,
			'catalog_image_article_width'  => 350,
			'catalog_image_article_height' => 250,
			//Article
			'article_show_author'          => 1,
			'article_show_viewed'          => 1,
			'article_show_date_added'      => 1,
			'article_show_date_modified'   => 1,
			'article_show_share_btn'       => 1,
			'article_thumb_width'          => 740,
			'article_thumb_height'         => 420,
			'article_popup_width'          => 500,
			'article_popup_height'         => 500,
			'article_additional_width'     => 80,
			'article_additional_height'    => 80,
			'article_related_width' => 250,
			'article_related_height' => 250,
			'article_product_width' => 180,
			'article_product_height' => 180,
			'article_related_display' => 'grid',
			'article_product_display' => 'grid',
			//Video
			'youtube_show_control' => 1,
			'youtube_allow_fullsreen' => 1,
			'youtube_related_video' => 1,
			'youtube_autohide' => 1,
			'youtube_template' => 'dark',
			'youtube_quanlity' => 'vq=hd1080',
			//Global
			'comment_status' => 1,
			'admin_limit' => 10,
			'date_format' => 'd-m-Y'
		);
	}
}
?>