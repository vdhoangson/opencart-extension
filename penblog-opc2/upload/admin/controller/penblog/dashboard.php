<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerPenBlogDashboard extends Controller {
	public function index(){
		if($this->checkInstall()){
			$languages = $this->language->load('penblog/dashboard');
			foreach($languages as $key => $value){
				$data[$key] = $value;
			}

			$this->document->setTitle($this->language->get('heading_title'));

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('penblog/dashboard', 'token=' . $this->session->data['token'], true)
			);
			/* Article */
			$this->load->model('penblog/article');
			$data['total_article'] = $this->model_penblog_article->getTotalArticles();
			$data['public_article'] = $this->model_penblog_article->getTotalPublicArticles();
			$data['unpublic_article'] = $this->model_penblog_article->getTotalUnPublicArticles();

			/* Category */
			$this->load->model('penblog/category');
			$data['total_category'] = $this->model_penblog_category->getTotalCategories();
			$data['public_category'] = $this->model_penblog_category->getTotalPublicCategories();
			$data['unpublic_category'] = $this->model_penblog_category->getTotalUnPublicCategories();
			/* Comment */
			$this->load->model('penblog/comment');
			$data['total_comment'] = $this->model_penblog_comment->getTotalComments();
			$data['public_comment'] = $this->model_penblog_comment->getTotalPublicComments();
			$data['unpublic_comment'] = $this->model_penblog_comment->getTotalUnPublicComments();

			/* Lastest article */
			$this->load->model('penblog/testimonial');
			$data['latest_articles'] = array();
			$latest_articles = $this->model_penblog_article->getLatestArticles();
			foreach($latest_articles as $result){
				$category = $this->model_penblog_category->getCategoryByArticleId($result['article_id']);
				$data['latest_articles'][] = array(
					'article_id' => $result['article_id'],
					'name' => $result['name'],
					'category' => isset($category['name'])?$category['name']:'-- None --',
					'status'     => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
					'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'edit'       => $this->url->link('penblog/article/edit', 'token=' . $this->session->data['token'] . '&article_id=' . $result['article_id'], true),
					'view' => HTTP_CATALOG.'index.php?route=penblog/article&article_id=' . $result['article_id']
				);
			}

			/* Latest Testimonial */
			$data['latest_testimonials'] = array();
			$latest_testimonials = $this->model_penblog_testimonial->getLatestTestimonials();
			foreach($latest_testimonials as $result){
				$data['latest_testimonials'][] = array(
					'testimonial_id' => $result['testimonial_id'],
					'customer_name' => $result['customer_name'],
					'status'     => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
					'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'edit'       => $this->url->link('penblog/testimonial/edit', 'token=' . $this->session->data['token'] . '&testimonial_id=' . $result['testimonial_id'], true),
				);
			}
		
			$template = 'penblog/dashboard.tpl';
		} else {
			$this->document->setTitle('Install Pen Blog');
			$data['href_ext'] = $this->url->link('extension/module/install', 'token=' . $this->session->data['token'].'&extension=penblog_block', true);
			$template = 'penblog/not_install.tpl';
		}

		$data['checkUpdate'] = $this->checkUpdate();
		$data['btn_update'] = $this->url->link('penblog/about/update', 'token=' . $this->session->data['token'], true);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['shortcut'] = $this->load->controller('penblog/shortcut');

		$this->response->setOutput($this->load->view($template, $data));
	}

	private function checkInstall(){
		if ($this->config->get('penblog_installed')) {
			return true;
		} else {
			return false;
		}
	}
	private function checkUpdate(){
		$curent_version = $this->config->get('penblog_version');
		$this->load->model('penblog/setup');
		$latest_version = $this->model_penblog_setup->getVersion();
		if($curent_version!=$latest_version){
			return true;
		} else {
			return false;
		}
	}
}
?>