<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerPenBlogBlockCalendar extends Controller {
	public function index($setting = array()){
		$languages = $this->language->load('penblog_block/calendar');
		foreach($languages as $key => $value){
			$data[$key] = $value;
		}

		$block_data = isset($setting['block_data'])?$setting['block_data']:array();
		
		foreach($block_data as $key => $value){
			$data[$key] = $value;
		}
		
		$data['articles'] = $setting['articles'];

		return $this->load->view('penblog/block/calendar.tpl', $data);
	}
}
?>