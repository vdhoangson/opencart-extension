<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerExtensionPenBlogBlockTestimonial extends Controller {

	public function index($setting=array()){
		static $module = 0;

		foreach($setting as $key => $value){
			$data[$key] = $value;
		}

		$languages = $this->language->load('extension/module/penblog_block');

		foreach($languages as $key => $value){
			$data[$key] = $value;
		}

		$block_data = $setting['block_data'];

		$template = $setting['block'];

		$this->load->model('extension/penblog/testimonial');
		$this->load->model('tool/image');

		$testimonials = array();

		$results = $this->model_extension_penblog_testimonial->getTestimonials($block_data['limit']);

		if($results){
			foreach ($results as $result) {
				if ($result['avatar'] && file_exists(DIR_IMAGE . $result['avatar'])) {
					$avatar =  $this->model_tool_image->resize($result['avatar'],65,65);
				} else {
					$avatar = 'image/catalog/penblog/avatar.png';
				}
				if ($result) {
					$data['testimonials'][] = array(
					'name' => $result['customer_name'],
					'message' => html_entity_decode($result['message'], ENT_QUOTES, 'UTF-8'),
					'competence' => $result['competence'],
					'rating' => $result['rating'],
					'avatar' => $avatar,
					);
				}
			}
		}

		$data['module'] = 'cms_block_'.$template . $module++;

		$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');
		$this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');

		return $this->load->view('extension/penblog/block/'.$template, $data);
	}
}
?>