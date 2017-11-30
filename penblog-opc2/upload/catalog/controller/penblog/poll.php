<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerPenBlogPoll extends Controller {
	public function index($setting = array()){
		static $module = 0;

		$languages = $this->language->load('penblog/poll');
		foreach($languages as $key => $value){
			$data[$key] = $value;
		}

		$this->load->model('penblog/poll');

		$poll_id = $data['poll_id'] = isset($setting['poll_id'])?$setting['poll_id']:0;

		$poll = $this->model_penblog_poll->getPoll($poll_id);

		if(!empty($poll)){
			if(isset($this->request->cookie['poll_answered'.$poll_id])){
				if($this->request->cookie['poll_answered'.$poll_id]==$poll_id){ 
					$data['answered'] = true;
				}
			}

			$total_votes=$this->model_penblog_poll->getTotalResults($poll_id);
			$percent = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
			$totals  = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
			$vote    = array();

			$data['poll_data']=$this->model_penblog_poll->getPollData($poll_id);

			$poll_results = $this->model_penblog_poll->getPollResults($poll_id);

			if($poll_results){
				$data['reactions'] = true;

				foreach($poll_results as $result){ 
					$totals[$result['answer'] - 1]++;
				}

				for($i=0;$i < 10;$i++){ 
					$percent[$i]=round(100 * ($totals[$i]/$total_votes));
					$vote[$i]=$totals[$i];
				}

				$data['percent']=$percent;
				$data['vote']=$vote;
				$data['total_votes']=$total_votes;			
				
				$data['id'] = 'module'.$poll_id;
			}

			$template = 'penblog/poll';
			if((int)str_replace('.', '', VERSION) < 2200){
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/'.$template.'.tpl')) {
					return $this->load->view($this->config->get('config_template') . '/template/'.$template.'.tpl', $data);
				} else {
					return $this->load->view('default/template/'.$template.'.tpl', $data);
				}
			} else {
				return $this->load->view($template, $data);
			}
		} else {
			return false;
		}
	}

	public function answer(){ 	
		$json = array();

		$poll_id=0;

		$this->load->language('penblog/poll');

		$this->load->model('penblog/poll');

		if($this->request->server['REQUEST_METHOD']=='POST'&&isset($this->request->post['poll_answer'])){ 
			$this->model_penblog_poll->addReaction($this->request->post);
			//Set a cookie:
			setcookie('poll_answered'.$this->request->post['poll_id'],$this->request->post['poll_id'], time()+60*60*24*7);
			//Can only vote once a week

			if(isset($this->request->post['poll_id'])){ 
				$poll_id=$this->request->post['poll_id'];
				$json['success'] = 'text_success';
			}else{				
				$json['error'] = 'Error';
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		
	}

	public function result(){ 
		$this->load->model('penblog/poll');
			
		$language_data = $this->load->language('penblog/poll');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}				
		$poll_id = $data['poll_id'] = 0;
		
		if(isset($this->request->get['poll_id'])){ 
			$poll_id = $data['poll_id'] = $this->request->get['poll_id'];
		}

		if(isset($this->request->cookie['poll_answered'.$poll_id])){
			if($this->request->cookie['poll_answered'.$poll_id]==$poll_id){ 
				$data['answered'] = true;
			}
		}

		$total_votes=$this->model_penblog_poll->getTotalResults($poll_id);
		$percent = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		$totals  = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		$vote    = array();

		$data['poll_data']=$this->model_penblog_poll->getPollData($poll_id);

		$poll_results = $this->model_penblog_poll->getPollResults($poll_id);

		if($poll_results){
			$data['reactions'] = true;

			foreach($poll_results as $result){ 
				$totals[$result['answer'] - 1]++;
			}

			for($i=0;$i < 10;$i++){ 
				$percent[$i]=round(100 * ($totals[$i]/$total_votes));
				$vote[$i]=$totals[$i];
			}

			$data['percent']=$percent;
			$data['vote']=$vote;
			$data['total_votes']=$total_votes;			
			
			$data['id'] = 'module'.$poll_id;
		}
		
		$template = 'penblog/poll_ajax';
		if((int)str_replace('.', '', VERSION) < 2200){
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/'.$template.'.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/'.$template.'.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/'.$template.'.tpl', $data));
			}
		} else {
			$this->response->setOutput($this->load->view($template, $data));
		}
	}
}
?>