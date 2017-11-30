<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerPenBlogShortcut extends Controller {
	public function index(){

		$data['shortcuts'] = $this->getShortcuts();

		$find[0] = '/\/add/';
		$find[1] = '/\/edit/';
		$replace[0] = $replace[1] = '';
		$route = '';
		if (isset($this->request->get['route'])) {
			$route = $this->request->get['route'];
		}
		$data['route'] = preg_replace($find, $replace, $route);

		return $this->load->view('penblog/shortcut.tpl', $data);
	}

	private function getShortcuts(){
		$this->language->load('penblog/shortcut');
		$results = array('dashboard', 'category', 'article', 'comment', 'download', 'setting');
		$shortcuts = array();

		$shortcuts[] = array(
			'text' => $this->language->get('text_dashboard'),
			'href' => $this->url->link('penblog/dashboard', 'token=' . $this->session->data['token'], true),
			'route' => 'penblog/dashboard',
			'icon' => 'fa fa-tachometer',
			'childs' => array()
		);
		$shortcuts[] = array(
			'text' => $this->language->get('text_category'),
			'href' => $this->url->link('penblog/category', 'token=' . $this->session->data['token'], true),
			'route' => 'penblog/category',
			'icon' => 'fa fa-folder-open-o',
			'childs' => array()
		);
		$shortcuts[] = array(
			'text' => $this->language->get('text_article'),
			'href' => $this->url->link('penblog/article', 'token=' . $this->session->data['token'], true),
			'route' => 'penblog/article',
			'icon' => 'fa fa-newspaper-o',
			'childs' => array()
		);
		$shortcuts[] = array(
			'text' => $this->language->get('text_comment'),
			'href' => $this->url->link('penblog/comment', 'token=' . $this->session->data['token'], true),
			'route' => 'penblog/comment',
			'icon' => 'fa fa-comments',
			'childs' => array()
		);
		$shortcuts[] = array(
			'text' => $this->language->get('text_poll'),
			'href' => $this->url->link('penblog/poll', 'token=' . $this->session->data['token'], true),
			'route' => 'penblog/poll',
			'icon' => 'fa fa-bar-chart',
			'childs' => array()
		);
		$shortcuts[] = array(
			'text' => $this->language->get('text_testimonial'),
			'href' => $this->url->link('penblog/testimonial', 'token=' . $this->session->data['token'], true),
			'route' => 'penblog/testimonial',
			'icon' => 'fa fa-comment-o',
			'childs' => array()
		);
		$shortcuts[] = array(
			'text' => $this->language->get('text_download'),
			'href' => $this->url->link('penblog/download', 'token=' . $this->session->data['token'], true),
			'route' => 'penblog/download',
			'icon' => 'fa fa-download',
			'childs' => array()
		);

		$shortcuts[] = array(
			'text' => $this->language->get('text_penblog_block'),
			'href' => $this->url->link('extension/module/penblog_block', 'token=' . $this->session->data['token'], true),
			'route' => 'extension/module/penblog_block',
			'icon' => 'fa fa-th-large',
			'childs' => array()
		);

		$child_setting[] = array(
			'text' => $this->language->get('text_setting'),
			'href' => $this->url->link('penblog/setting', 'token=' . $this->session->data['token'], true),
			'route' => 'penblog/setting',
			'icon' => 'fa fa-cog'
		);

		$child_setting[] = array(
			'text' => $this->language->get('text_about'),
			'href' => $this->url->link('penblog/about', 'token=' . $this->session->data['token'], true),
			'route' => 'penblog/about',
			'icon' => 'fa fa-info-circle'
		);
		
		$shortcuts[] = array(
			'text' => $this->language->get('text_setting'),
			'href' => $this->url->link('penblog/setting', 'token=' . $this->session->data['token'], true),
			'route' => 'penblog/setting',
			'icon' => 'fa fa-cog',
			'childs' => $child_setting
		);

		return $shortcuts;
	}
}
?>