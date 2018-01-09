<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerExtensionModulePenBlogBlock extends Controller {

	public function index($setting = array()){
		$data['block'] = '';

		if(file_exists(DIR_APPLICATION . 'controller/extension/penblog/block/' . $setting['block']. '.php')){
			$data['block'] = $this->load->controller('extension/penblog/block/'.$setting['block'], $setting);
		}

		$template = 'extension/module/penblog_block';
		return $this->load->view($template, $data);
	}

	public function tab_item(){

		$this->load->model('extension/penblog/article');
		$this->load->model('extension/penblog/image');

		$block_data = $this->request->get;

		$data['setting'] = $setting = $this->config->get('penblog_setting');

		if(isset($block_data['display'])){
			if($block_data['display']=='grid'){
				$data['cols'] = 'col-md-4 col-sm-4';
			} else {
				$data['cols'] = 'col-md-12 col-sm-12';
			}
			$data['display'] = 'gen-cms-'.$block_data['display'];
		} else {
			$data['display'] = 'gen-cms-grid';
			$data['cols'] = 'col-md-4 col-sm-4';
		}

		$limit = !empty($block_data['limit'])?$block_data['limit']:6;

		$data['image_width'] = !empty($block_data['image_width'])?$block_data['image_width']:250;
        $data['image_height'] = !empty($block_data['image_height'])?$block_data['image_height']:220;

		$this->language->load('extension/penblog/article');
		$data['text_date_added'] = $this->language->get('text_date_added');
		$data['text_date_modified'] = $this->language->get('text_date_modified');
		$data['text_viewed'] = $this->language->get('text_viewed');
		$data['text_author'] = $this->language->get('text_author');
		$data['text_empty'] = $this->language->get('text_empty');
		$data['text_readmore'] = $this->language->get('text_readmore');

		$data['articles'] = array();

		if(isset($this->request->get['category_id'])){

			$results = $this->model_extension_penblog_article->getArticlesByCategory($this->request->get['category_id'], $limit);

			foreach($results as $result){

				if ($result['image']) {
					$img_type = json_decode($result['image'], true);
					if($img_type['type']=='image'){
						$image = $this->model_extension_penblog_image->cropsize($img_type['image'], $block_data['image_width'], $block_data['image_height']);
						$thumb = $this->model_extension_penblog_image->cropsize($img_type['image'], $block_data['image_width'], $block_data['image_height']);
					} elseif($img_type['type']=='youtube'){
						$image = str_replace('https://www.youtube.com/watch?v=', 'http://www.youtube.com/embed/', $img_type['youtube']) ;
						$thumb = str_replace('https://www.youtube.com/watch?v=', 'http://www.youtube.com/embed/', $img_type['youtube']) ;
					}
				} else {
					$img_type = '';
					$image = $this->model_extension_penblog_image->cropsize('catalog/penblog/penblog.png', $block_data['image_width'], $block_data['image_height']);
					$thumb = $this->model_extension_penblog_image->cropsize('catalog/penblog/penblog.png', $block_data['image_width'], $block_data['image_height']);
				}

				if ($setting['comment_status']) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}

				if(($result['login_to_view'] == 1 && $this->customer->isLogged()) || $result['login_to_view'] == 0){
					$link = $this->url->link('extension/penblog/article', 'article_id=' . $result['article_id']);
				} else {
					$link = $this->url->link('account/login');
				}

				if($result['author_id']){
					$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "user` WHERE user_id = '" . (int)$result['author_id'] . "'");

					$author = $query->row['username'];
				}

				$data['categories'] = $this->model_extension_penblog_article->getCategoriesByArticleId($result['article_id']);

				$data['articles'][] = array(
					'article_id' => $result['article_id'],
					'name' => $result['name'],
					'short_description' => $result['short_description'],
					'thumb'   	 => $thumb,
					'image' => $image,
					'img_type' => $img_type['type'],
					'rating'     => $rating,
					'author'	=> $author,
					'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
					'viewed' => $result['viewed'],
					'href'    	 => $link
				);
			}
		}

		$template = 'extension/penblog/block/category_data';
		$this->response->setOutput($this->load->view($template, $data));
	}
}
?>