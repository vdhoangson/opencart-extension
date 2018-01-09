<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerExtensionPenBlogPoll extends Controller {
	public function index($setting = array()){
		static $module = 0;

		$languages = $this->language->load('extension/penblog/poll');
		foreach($languages as $key => $value){
			$data[$key] = $value;
		}

		$this->load->model('extension/penblog/poll');

		$poll_id = $data['poll_id'] = isset($setting['poll_id'])?$setting['poll_id']:0;

		$poll = $this->model_extension_penblog_poll->getPoll($poll_id);

		if(!empty($poll)){
			if(isset($this->request->cookie['poll_answered'.$poll_id])){
				if($this->request->cookie['poll_answered'.$poll_id]==$poll_id){
					$data['answered'] = true;
				}
			}

			$total_votes=$this->model_extension_penblog_poll->getTotalResults($poll_id);
			$percent = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0);
			$totals  = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0);
			$vote    = array();

			$data['poll_data']=$this->model_extension_penblog_poll->getPollData($poll_id);

			$poll_results = $this->model_extension_penblog_poll->getPollResults($poll_id);

			if($poll_results){
				$data['reactions'] = true;

				foreach($poll_results as $result){
					$totals[$result['answer']]++;
				}

				for($i=1;$i <= 10;$i++){
					$percent[$i]=round(100 * ($totals[$i]/$total_votes));
					$vote[$i]=$totals[$i];
				}

				$data['percent'] = $percent;
				$data['vote'] = $vote;
				$data['total_votes'] = $total_votes;

				$data['id'] = 'module'.$poll_id;
			}

			$template = 'extension/penblog/poll';
			return $this->load->view($template, $data);
		} else {
			return false;
		}
	}

	public function answer(){
		$json = array();

		$poll_id=0;

		$this->language->load('extension/penblog/poll');

		$this->load->model('extension/penblog/poll');

		if($this->request->server['REQUEST_METHOD']=='POST'&&isset($this->request->post['poll_answer'])){
			$this->model_extension_penblog_poll->addReaction($this->request->post);
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
		$this->load->model('extension/penblog/poll');

		$language_data = $this->language->load('extension/penblog/poll');
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

		$total_votes=$this->model_extension_penblog_poll->getTotalResults($poll_id);
		$percent = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0);
		$totals  = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0);
		$vote    = array();

		$data['poll_data'] = $this->model_extension_penblog_poll->getPollData($poll_id);

		$poll_results = $this->model_extension_penblog_poll->getPollResults($poll_id);

		if($poll_results){
			$data['reactions'] = true;

			foreach($poll_results as $result){
				$totals[$result['answer'] - 1]++;
			}

			for($i = 1;$i <= 10;$i++){
				$percent[$i] = round(100 * ($totals[$i]/$total_votes));
				$vote[$i]=$totals[$i];
			}

			$data['percent'] = $percent;
			$data['vote'] = $vote;
			$data['total_votes'] = $total_votes;

			$data['id'] = 'module'.$poll_id;
		}

		$template = 'extension/penblog/poll_ajax';
		$this->response->setOutput($this->load->view($template, $data));
	}
}
?>