<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerExtensionPenBlogBlockCalendar extends Controller {

	public function index($setting=array()){
		static $module = 0;

		foreach($setting as $key => $value){
			$data[$key] = $value;
		}

		$languages = $this->language->load('extension/module/penblog_block');

		foreach($languages as $key => $value){
			$data[$key] = $value;
		}

		$block_data = isset($setting['block_data'])?$setting['block_data']:array();

		$template = $setting['block'];

		$data['today'] = $today = date('Y-m-d');

		$data['module'] = 'cms_block_'.$template . $module++;

		$this->document->addScript('catalog/view/javascript/jquery/penblog/datetimepicker/moment.js');
		$this->document->addScript('catalog/view/javascript/jquery/penblog/datetimepicker/datetimepicker.js');
		$this->document->addStyle('catalog/view/javascript/jquery/penblog/datetimepicker/datetimepicker.css');

		return $this->load->view('extension/penblog/block/'.$template, $data);
	}
}
?>