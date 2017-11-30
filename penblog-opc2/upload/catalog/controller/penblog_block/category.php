<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerPenBlogBlockCategory extends Controller {

	public function index($setting=array()){
		foreach($setting as $key => $value){
			$data[$key] = $value;
		}
		$block_data = $setting['block_data'];

		$block_categories = !empty($block_data['block_categories'])?$block_data['block_categories']:array();

		$template = $setting['block'];

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['category_id'] = $parts[0];
		} else {
			$data['category_id'] = 0;
		}

		if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
		} else {
			$data['child_id'] = 0;
		}

		$this->load->model('penblog/category');

		$data['categories'] = array();

		foreach($block_categories as $category_id){
			$categories[] = $this->model_penblog_category->getCategory($category_id);
		}
		
		if(isset($categories)){
			foreach ($categories as $category) {
				$children_data = array();

				$childrens = $this->model_penblog_category->getCategories($category['category_id']);
				if($childrens){
					foreach($childrens as $child) {
						$filter_data = array(
							'filter_category_id' => $child['category_id'],
							'filter_sub_category' => true);

						$children_data[] = array(
							'category_id' => $child['category_id'],
							'name' => $child['name'],
							'href' => $this->url->link('penblog/category', 'penblog_path=' . $category['category_id'] . '_' . $child['category_id'])
						);
					}
				}


				$data['categories'][] = array(
					'category_id' => $category['category_id'],
					'name'        => $category['name'],
					'children'    => $children_data,
					'href'        => $this->url->link('penblog/category', 'penblog_path=' . $category['category_id'])
				);
			}
		}

		if((int)str_replace('.', '', VERSION) < 2200){
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/penblog/'.$template.'.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/penblog/'.$template.'.tpl', $data);
			} else {
				return $this->load->view('default/template/module/penblog/'.$template.'.tpl', $data);
			}
		} else {
			return $this->load->view('module/penblog/'.$template, $data);
		}
	}
}
?>