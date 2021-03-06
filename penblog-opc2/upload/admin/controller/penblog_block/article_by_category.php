<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerPenBlogBlockArticleByCategory extends Controller {
	public function index($setting = array()){
		$languages = $this->language->load('penblog_block/article_by_category');
		foreach($languages as $key => $value){
			$data[$key] = $value;
		}

		$block_data = $setting['block_data'];
		
		foreach($block_data as $key => $value){
			$data[$key] = $value;
		}
		
		$data['categories'] = $setting['categories'];

		return $this->load->view('penblog/block/article_by_category.tpl', $data);
	}
}
?>