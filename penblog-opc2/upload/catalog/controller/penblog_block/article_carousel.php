<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerPenBlogBlockArticleCarousel extends Controller {

	public function index($setting=array()){
		static $module = 0;

		foreach($setting as $key => $value){
			$data[$key] = $value;
		}

		$block_data = $setting['block_data'];

		$template = $setting['block'];

		$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');
		$this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');

		$this->load->model('penblog/category');
		$this->load->model('penblog/article');
		$this->load->model('penblog/image');

		$articles = array();

		$setting = $this->config->get('penblog_setting');

		foreach($block_data['block_articles'] as $article_id){
			$articles[] = $this->model_penblog_article->getArticle($article_id);
		}

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

				if ($setting['comment_status']) {
					$rating = array();
					$this->load->model('penblog/comment');
					$comments = $this->model_penblog_comment->getCommentsByArticleId($result['article_id']);
					foreach($comments as $comment){
						$rating[] = $comment['rating'];
					}
				} else {
					$rating = false;
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

				$categories = $this->model_penblog_article->getCategoriesByArticleId($result['article_id']);
				if(!empty($categories)){
	                foreach ($categories as $id => $value)
	                {
	                    $parents = array();
	                    $parents = $this->model_penblog_category->getCategoriesByParentId($id);
	                    $parents[] = (string)$id;
	                    $value['href']  = $this->url->link('penblog/category', 'penblog_path=' . implode('_', $parents));
	                    $cat[$id] = $value;
	                }
	            }
				$data['articles'][] = array(
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

		$data['module'] = 'cms_block_'.$template . $module++;

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