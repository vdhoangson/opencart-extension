<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerExtensionPenBlogBlockTabArticle extends Controller {

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

		$data['setting'] = $this->config->get('penblog_setting');

		$data['image_width'] = !empty($block_data['image_width'])?$block_data['image_width']:250;
        $data['image_height'] = !empty($block_data['image_height'])?$block_data['image_height']:220;

		$this->load->model('extension/penblog/category');
		$this->load->model('extension/penblog/article');
		$this->load->model('extension/penblog/image');

		$articles = array();

		$setting = $this->config->get('penblog_setting');

		foreach($block_data['block_articles'] as $article_id){
			$articles[] = $this->model_extension_penblog_article->getArticle($article_id);
		}
		$data['articles'] = array();
		if($articles){
			$blog_setting = $this->config->get('penblog_setting');
			foreach($articles as $result){
				if ($result['image']) {
					$img_type = json_decode($result['image'], true);
					if($img_type['type']=='image' && !empty($img_type['image'])){
						$image = $this->model_extension_penblog_image->cropsize($img_type['image'], $block_data['image_width'], $block_data['image_height']);
					} elseif($img_type['type']=='youtube'){
						$yt_link = str_replace('https://www.youtube.com/watch?v=', 'http://www.youtube.com/embed/', $img_type['youtube']) ;
						$image = $yt_link.'?&fs='.$blog_setting['youtube_allow_fullsreen'].'&ap='.$blog_setting['youtube_quanlity'].'&theme='.$blog_setting['youtube_template'].'&controls='.$blog_setting['youtube_show_control'].'&autohide='.$blog_setting['youtube_autohide'].'&rel='.$blog_setting['youtube_related_video'];
					} else {
						$img_type = array('type'=>'image','image'=>'catalog/penblog/penblog.png','youtube'=>'');
						$image = $this->model_extension_penblog_image->cropsize('catalog/penblog/penblog.png', $block_data['image_width'], $block_data['image_height']);
					}
				} else {
					$img_type = array('type'=>'','image'=>'','youtube'=>'');
					$image = $this->model_extension_penblog_image->cropsize('catalog/penblog/penblog.png', $block_data['image_width'], $block_data['image_height']);
				}

				if ($blog_setting['comment_status'] && $result['allow_comment']) {
					$rating = (int)$result['rating'];
				} else {
					$rating = 0;
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

				$categories = $this->model_extension_penblog_article->getCategoriesByArticleId($result['article_id']);
				if(!empty($categories)){
	                foreach ($categories as $id => $value)
	                {
	                    $parents = array();
	                    $parents = $this->model_extension_penblog_category->getCategoriesByParentId($id);
	                    $parents[] = (string)$id;
	                    $value['href']  = $this->url->link('extension/penblog/category', 'penblog_path=' . implode('_', $parents));
	                    $cat[$id] = $value;
	                }
	            }
				$data['articles'][] = array(
					'categories'        => isset($cat)?$cat: array(),
					'article_id'        => $result['article_id'],
					'name'              => $result['name'],
					'short_description' => html_entity_decode($result['short_description'], ENT_QUOTES, 'UTF-8'),
					'image'             => $image,
					'img_type'          => $img_type['type'],
					'rating'            => $rating,
					'author'	        => $author,
					'date_added'        => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'date_modified'     => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
					'viewed'            => $result['viewed'],
					'href'    	        => $link
				);
			}
		}

		$data['module'] = 'cms_block_'.$template . $module++;

		return $this->load->view('extension/penblog/block/'.$template, $data);
	}
}
?>