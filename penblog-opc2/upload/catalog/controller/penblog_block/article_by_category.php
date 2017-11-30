<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerPenBlogBlockArticleByCategory extends Controller {

	public function index($setting=array()){
		foreach($setting as $key => $value){
			$data[$key] = $value;
		}

		$languages = $this->language->load('module/penblog_block');

		foreach($languages as $key => $value){
			$data[$key] = $value;
		}

		$block_data = $setting['block_data'];

		$template = $setting['block'];

		$data['setting'] = $this->config->get('penblog_setting');

		if(!empty($block_data['display'])){
			if($block_data['display']=='grid'){
				$data['cols'] = 'col-md-4 col-sm-4';
			} else {
				$data['cols'] = 'col-md-12 col-sm-12';
			}
			$data['display'] = 'gen-cms-'.$block_data['display'];
		}


		$this->load->model('penblog/category');
		$this->load->model('penblog/article');
		$this->load->model('penblog/image');

		$gen_setting = $this->config->get('penblog_setting');

		$limit = !empty($block_data['limit'])?$block_data['limit']:6;

		$data['categories'] = array();

		foreach($block_data['block_categories'] as $category_id){
			$categories[] = $this->model_penblog_category->getCategory($category_id);
		}

		if(isset($categories)){
			foreach ($categories as $category) {
				$articles_data = array();
				$articles = $this->model_penblog_article->getArticlesByCategory($category['category_id'], $limit);
				if($articles){
					foreach($articles as $result){
						if ($result['image']) {
							$img_type = json_decode($result['image'], true);
							if($img_type['type']=='image'){
								$image = $this->model_penblog_image->cropsize($img_type['image'], $block_data['image_width'], $block_data['image_height']);
							} elseif($img_type['type']=='youtube'){
								$yt_link = str_replace('https://www.youtube.com/watch?v=', 'http://www.youtube.com/embed/', $img_type['youtube']) ;
								$image = $yt_link.'?&fs='.$setting['youtube_allow_fullsreen'].'&ap='.$setting['youtube_quanlity'].'&theme='.$setting['youtube_template'].'&controls='.$setting['youtube_show_control'].'&autohide='.$setting['youtube_autohide'].'&rel='.$setting['youtube_related_video'];
							}
						} else {
							$img_type = array('type'=>'','image'=>'','youtube'=>'');
							$image = $this->model_penblog_image->cropsize('no_image.png', $block_data['image_width'], $block_data['image_height']);
						}

						if ($gen_setting['comment_status']) {
							$rating = (int)$result['rating'];
						} else {
							$rating = 0;
						}

						if(($result['login_to_view'] == 1 && $this->customer->isLogged()) || $result['login_to_view'] == 0){
							$link = $this->url->link('penblog/article', 'article_id=' . $result['article_id']);
						} else {
							$link = $this->url->link('account/login');
						}

						if($result['author_id']){
							$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "user` WHERE user_id = '" . (int)$result['author_id'] . "'");

							$author = $query->row['username'];
						}

						$article_categories = $this->model_penblog_article->getCategoriesByArticleId($result['article_id']);
						if(!empty($article_categories)){
							foreach ($article_categories as $id => $value)
							{
									$parents = array();
									$parents = $this->model_penblog_category->getCategoriesByParentId($id);
									$parents[] = (string)$id;
									$value['href']  = $this->url->link('penblog/category', 'penblog_path=' . implode('_', $parents));
									$cat[$id] = $value;
							}
						}
						$articles_data[] = array(
							'categories' => isset($cat)?$cat:array(),
							'article_id' => $result['article_id'],
							'name' => $result['name'],
							'short_description' => $result['short_description'],
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

				$data['categories'][] = array(
					'category_id' => $category['category_id'],
					'name'        => $category['name'],
					'href'        => $this->url->link('penblog/category', 'path=' . $category['category_id']),
					'articles' => $articles_data
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