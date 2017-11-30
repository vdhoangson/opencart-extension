<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerPenBlogArticle extends Controller {
	private $error = array();

	public function index() {
		$language_array = $this->load->language('penblog/article');

		$setting = $this->config->get('penblog_setting');

		foreach($setting as $key => $value) {
			$data[$key] = $value;
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home')
		);

		$this->load->model('penblog/category');

		if (isset($this->request->get['penblog_path'])) {
			$path = '';

			$parts = explode('_', (string)$this->request->get['penblog_path']);

			$category_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}

				$category_info = $this->model_penblog_category->getCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text'      => $category_info['name'],
						'href'      => $this->url->link('penblog/category', 'penblog_path=' . $path),
					);
				}
			}

			// Set the last category breadcrumb
			$category_info = $this->model_penblog_category->getCategory($category_id);

			if ($category_info) {
				$url = '';

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}

				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}

				$data['breadcrumbs'][] = array(
					'text'      => $category_info['name'],
					'href'      => $this->url->link('penblog/category', 'penblog_path=' . $this->request->get['penblog_path'].$url),
				);
			}
		}

		if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {
			$url = '';

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_search'),
				'href'      => $this->url->link('penblog/search', $url),
				'separator' => $this->language->get('text_separator')
			);
		}

		if (isset($this->request->get['article_id'])) {
			$data['article_id'] = $article_id = (int)$this->request->get['article_id'];
		} else {
			$data['article_id'] = $article_id = 0;
		}

		$this->load->model('penblog/article');

		$article_info = $this->model_penblog_article->getArticle($article_id);

		if ($article_info) {
			$url = '';

			if (isset($this->request->get['penblog_path'])) {
				$url .= '&penblog_path=' . $this->request->get['penblog_path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			$data['breadcrumbs'][] = array(
				'text'      => $article_info['name'],
				'href'      => $this->url->link('penblog/article', $url . '&article_id=' . $this->request->get['article_id']),
			);

			foreach($language_array as $key => $text){
				$data[$key] = $text;
			}

			$this->document->setTitle($article_info['name']);
			$this->document->setDescription($article_info['meta_description']);
			$this->document->setKeywords($article_info['meta_keyword']);
			$this->document->addLink($this->url->link('penblog/article', 'article_id=' . $this->request->get['article_id']), 'canonical');
			$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
			$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');

			if(($setting['article_related_display'] == 'grid_carousel') || ($setting['article_product_display'] == 'grid_carousel')){
				$this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');
				$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');
			}

			$data['heading_title'] = $article_info['name'];


			$data['text_login'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', true), $this->url->link('account/register', '', true));


			$this->load->model('penblog/comment');

			$data['tab_description'] = $this->language->get('tab_description');
			$data['tab_comment'] = sprintf($this->language->get('tab_comment'), $article_info['comments']);
			$data['tab_related'] = $this->language->get('tab_related');
			$data['tab_download'] = $this->language->get('tab_download');

			// Captcha
			if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('penblog_article', (array)$this->config->get('config_captcha_page'))) {
				$data['captcha'] = $this->load->controller('captcha/' . $this->config->get('config_captcha'));
			} else {
				$data['captcha'] = '';
			}

			$this->load->model('penblog/image');

			if ($article_info['main_image']) {
				$data['img_type'] = $img_type = json_decode($article_info['main_image'], true);

				if($img_type['type']=='image'){
					if(!empty($img_type['image']) && is_file(DIR_IMAGE . $img_type['image'])){
						$data['thumb_main_image'] = $this->model_penblog_image->cropsize($img_type['image'], $setting['article_thumb_width'], $setting['article_thumb_height']);
						$data['popup_main_image'] = $this->model_penblog_image->cropsize($img_type['image'], $setting['article_popup_width'], $setting['article_popup_height']);
					}else {
						$data['thumb_main_image'] = $this->model_penblog_image->cropsize('catalog/penblog/penblog.png', $setting['article_thumb_width'], $setting['article_thumb_height']);
						$data['popup_main_image'] = $this->model_penblog_image->cropsize('catalog/penblog/penblog.png', $setting['article_popup_width'], $setting['article_popup_height']);
					}
				} elseif ($img_type['type']=='youtube') {
					$yt_link = str_replace('https://www.youtube.com/watch?v=', 'http://www.youtube.com/embed/', $img_type['youtube']);
					// Setting youtube
					$youtube_link = $yt_link.'?&fs='.$setting['youtube_allow_fullsreen'].'&ap='.$setting['youtube_quanlity'].'&theme='.$setting['youtube_template'].'&controls='.$setting['youtube_show_control'].'&autohide='.$setting['youtube_autohide'].'&rel='.$setting['youtube_related_video'];

					$data['thumb_main_image'] = $youtube_link;
					$data['popup_main_image'] = str_replace('https://www.youtube.com/watch?v=', 'http://www.youtube.com/embed/', $img_type['youtube']);
				}
			}



			$data['images'] = array();

			$results = $this->model_penblog_article->getArticleImages($article_id);

			foreach ($results as $result) {
				$data['images'][] = array(
					'popup' => $this->model_penblog_image->cropsize($result['image'], $setting['article_popup_width'], $setting['article_popup_height']),
					'thumb' => $this->model_penblog_image->cropsize($result['image'], $setting['article_additional_width'], $setting['article_additional_height'])
				);
			}

			$data['comments'] = sprintf($this->language->get('text_comments'), (int)$article_info['comments']);

			$data['allow_comment'] = $article_info['allow_comment'];

			$data['rating'] = (int)$article_info['rating'];
			$data['description'] = html_entity_decode($article_info['description'], ENT_QUOTES, 'UTF-8');
			$data['short_description'] = html_entity_decode($article_info['short_description'], ENT_QUOTES, 'UTF-8');
			$data['date_added'] = date($this->language->get('date_format_short'), strtotime($article_info['date_added']));
			$data['date_modified'] = date($this->language->get('date_format_short'), strtotime($article_info['date_modified']));
			$data['viewed'] = $article_info['viewed'];

			if($article_info['author_id']){
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "user` WHERE user_id = '" . (int)$article_info['author_id'] . "'");

				$data['author'] = $query->row['username'];
			}

			//category
			$data['categories'] = $this->model_penblog_article->getCategoriesByArticleId($article_info['article_id']);

			// related
			$data['articles_related'] = array();

			$article_relateds = $this->model_penblog_article->getArticleRelated($this->request->get['article_id']);

			foreach ($article_relateds as $related) {
				if ($related['image']) {
					$img_type = json_decode($related['image'], true);
					if($img_type['type']=='image'){
						if(!empty($img_type['image']) && is_file(DIR_IMAGE . $img_type['image'])){
							$image = $this->model_penblog_image->cropsize($img_type['image'], $setting['article_related_width'], $setting['article_related_height']);
						} else {
							$image = $this->model_penblog_image->cropsize('penblog.png', $setting['article_related_width'], $setting['article_related_height']);
						}

					} elseif($img_type['type']=='youtube'){
						$image = str_replace('https://www.youtube.com/watch?v=', 'http://www.youtube.com/embed/', $img_type['youtube']) ;
					}
				} else {
					$image = $this->model_penblog_image->cropsize('penblog.png', $setting['article_related_width'], $setting['article_related_height']);
					$img_type = array('type'=>'','image'=>'','youtube'=>'');
				}

				if ($setting['comment_status'] == 1 && $related['allow_comment'] == 1) {
					$rating = (int)$related['rating'];
				} else {
					$rating = false;
				}

				if(($related['login_to_view'] == 1 && $this->customer->isLogged()) || $related['login_to_view'] == 0){
					$link = $this->url->link('penblog/article', 'article_id=' . $related['article_id']);
				} else {
					$link = $this->url->link('account/login');
				}

				$data['articles_related'][] = array(
					'article_id' => $related['article_id'],
					'thumb'   	 => $image,
					'img_type'  => $img_type['type'],
					'name'    	 => $related['name'],
					'rating'     => $rating,
					'comments'    => sprintf($this->language->get('text_comments'), (int)$related['comments']),
					'href'    	 => $link
				);
			}

			// Download
			$data['downloads'] = array();

			$downloads = $this->model_penblog_article->getDownloadsByArticleId($article_id);

			foreach ($downloads as $download) {
				if (file_exists(DIR_DOWNLOAD . $download['filename'])) {
					$size = filesize(DIR_DOWNLOAD . $download['filename']);

					$i = 0;

					$suffix = array(
						'B',
						'KB',
						'MB',
						'GB',
						'TB',
						'PB',
						'EB',
						'ZB',
						'YB'
					);

					while (($size / 1024) > 1) {
						$size = $size / 1024;
						$i++;
					}
					if($download['login_to_download']==1){
						$this->session->data['redirect'] = $this->url->link('penblog/article', 'article_id=' . $article_id, true);
						$link_download = $this->url->link('account/login', '', true);
					} else {
						$link_download = $this->url->link('penblog/article/download', 'download_id=' . $download['download_id'], true);
					}

					$data['downloads'][] = array(
						'date_added' => date($this->language->get('date_format_short'), strtotime($download['date_added'])),
						'name'       => $download['name'],
						'size'       => round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i],
						'href'       => $link_download
					);
				}
			}

			// Products
			$this->load->model('catalog/product');

			$data['products'] = array();

			$products = $this->model_penblog_article->getProductsByArticleId($article_id);

			$data_product = array();

			foreach($products as $product_id){
				$data_product[] = $this->model_catalog_product->getProduct($product_id);
			}

			if (!empty($data_product)) {
				foreach ($data_product as $result) {
					if ($result['image']) {
						$image = $this->model_penblog_image->cropsize($result['image'], $setting['article_product_width'], $setting['article_product_height']);
					} else {
						$image = $this->model_penblog_image->cropsize('placeholder.png', $setting['article_product_width'], $setting['article_product_height']);
					}

					if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$price = false;
					}

					if ((float)$result['special']) {
						$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$special = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = $result['rating'];
					} else {
						$rating = false;
					}

					$data['products'][] = array(
						'product_id'  => $result['product_id'],
						'thumb'       => $image,
						'name'        => $result['name'],
						'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
						'price'       => $price,
						'special'     => $special,
						'tax'         => $tax,
						'rating'      => $rating,
						'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
					);
				}
			}

			// Poll
			$this->load->model('penblog/poll');
			$poll_id = $this->model_penblog_poll->getPollByArticleId($article_id);
			if(isset($poll_id)){
				$poll_setting = array(
					'poll_id' => $poll_id
				);

				$poll_data = $this->load->controller('penblog/poll', $poll_setting);
			} else {
				$poll_data = '';
			}

			if($poll_data != false){
				$data['polls'] = $poll_data;
			} else {
				$data['polls'] = '';
			}

			// Tags
			$data['tags'] = array();

			if ($article_info['tag']) {
				$tags = explode(',', $article_info['tag']);

				foreach ($tags as $tag) {
					$data['tags'][] = array(
						'tag'  => trim($tag),
						'href' => $this->url->link('penblog/search', 'tag=' . trim($tag))
					);
				}
			}

			$this->model_penblog_article->updateViewed($this->request->get['article_id']);

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$template = 'penblog/article';
			if((int)str_replace('.', '', VERSION) < 2200){
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/'.$template.'.tpl')) {
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/'.$template.'.tpl', $data));
				} else {
					$this->response->setOutput($this->load->view('default/template/'.$template.'.tpl', $data));
				}
			} else {
				$this->response->setOutput($this->load->view($template, $data));
			}
		} else {
			$url = '';

			if (isset($this->request->get['penblog_path'])) {
				$url .= '&penblog_path=' . $this->request->get['penblog_path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('penblog/article', $url . '&article_id=' . $article_id),
				'separator' => $this->language->get('text_separator')
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$template = 'error/not_found';
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

	public function comment() {
		$this->load->language('penblog/article');

		$this->load->model('penblog/comment');

		$data['text_no_comments'] = $this->language->get('text_no_comments');

		// reply
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_comment'] = $this->language->get('entry_comment');
		$data['entry_rating'] = $this->language->get('entry_rating');
		$data['entry_good'] = $this->language->get('entry_good');
		$data['entry_bad'] = $this->language->get('entry_bad');
		$data['entry_captcha'] = $this->language->get('entry_captcha');

		$data['text_write'] = $this->language->get('text_write');
		$data['text_note'] = $this->language->get('text_note');

		$data['button_continue'] = $this->language->get('button_continue');

		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('penblog_article', (array)$this->config->get('config_captcha_page'))) {
			$data['captcha'] = $this->load->controller('captcha/' . $this->config->get('config_captcha'));
		} else {
			$data['captcha'] = '';
		}

		if (isset($this->request->get['article_id'])) {
			$data['article_id'] = (int)$this->request->get['article_id'];
		} else {
			$data['article_id'] = 0;
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['comments'] = array();

		$comment_total = $this->model_penblog_comment->getTotalCommentsByArticleId($this->request->get['article_id']);

		$results = $this->model_penblog_comment->getCommentsByArticleId($this->request->get['article_id'], ($page - 1) * 5, 10);

		foreach ($results as $result) {
			$childs_1 = $this->model_penblog_comment->getCommentsByCommentId($result['comment_id']);
			$childs_comment_1 = array();
			foreach($childs_1 as $child){
				$childs_comment_1[] = array(
					'comment_id'             => $child['comment_id'],
					'author'         => $child['author'],
					'text'           => nl2br($child['text']),
					'rating'     => (int)$child['rating'],
					'date_added'     => $child['date_added']
				);
			}
			$data['comments'][] = array(
				'comment_id' => $result['comment_id'],
				'author'     => $result['author'],
				'text'       => nl2br($result['text']),
				'rating'     => (int)$result['rating'],
				'date_added' => $result['date_added'],
				'childs' => $childs_comment_1
			);
		}

		$pagination = new Pagination();
		$pagination->total = $comment_total;
		$pagination->page = $page;
		$pagination->limit = 5;
		$pagination->url = $this->url->link('penblog/article/comment', 'article_id=' . $this->request->get['article_id'] . '&page={page}');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($comment_total) ? (($page - 1) * 5) + 1 : 0, ((($page - 1) * 5) > ($comment_total - 5)) ? $comment_total : ((($page - 1) * 5) + 5), $comment_total, ceil($comment_total / 5));

		$template = 'penblog/comment';
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

	public function write() {
		$this->load->language('penblog/article');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
				$json['error'] = $this->language->get('error_name');
			}

			if (!filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL) === true) {
				$json['error'] = $this->language->get('error_email');
			}

			if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
				$json['error'] = $this->language->get('error_text');
			}

			if (empty($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5) {
				$json['error'] = $this->language->get('error_rating');
			}

			// Captcha
			if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('penblog_article', (array)$this->config->get('config_captcha_page'))) {
				$captcha = $this->load->controller('captcha/' . $this->config->get('config_captcha') . '/validate');

				if ($captcha) {
					$json['error'] = $captcha;
				}
			}

			if (!isset($json['error'])) {
				$this->load->model('penblog/comment');

				$this->model_penblog_comment->addComment($this->request->get['article_id'], $this->request->post);

				$json['success'] = $this->language->get('text_success');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}



	public function reply(){
		$this->load->language('penblog/article');

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
				$json['error'] = $this->language->get('error_name');
			}

			if (!filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL) === true) {
				$json['error'] = $this->language->get('error_email');
			}

			if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
				$json['error'] = $this->language->get('error_text');
			}

			if (empty($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5) {
				$json['error'] = $this->language->get('error_rating');
			}

			// Captcha
			if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('penblog_article', (array)$this->config->get('config_captcha_page'))) {
				$captcha = $this->load->controller('captcha/' . $this->config->get('config_captcha') . '/validate');

				if ($captcha) {
					$json['error'] = $captcha;
				}
			}

			if (!isset($json['error'])) {
				$this->load->model('penblog/comment');

				$this->model_penblog_comment->addReply($this->request->get['article_id'], $this->request->get['comment_id'], $this->request->post);

				$json['success'] = $this->language->get('text_success');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function download() {

		$this->load->model('penblog/article');

		if (isset($this->request->get['download_id'])) {
			$download_id = $this->request->get['download_id'];
		} else {
			$download_id = 0;
		}

		$download_info = $this->model_penblog_article->getDownload($download_id);

		if ($download_info) {

			$file = DIR_DOWNLOAD . $download_info['filename'];
			$mask = basename($download_info['mask']);

			if (!headers_sent()) {
				if (file_exists($file)) {
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="' . ($mask ? $mask : basename($file)) . '"');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));

					if (ob_get_level()) {
						ob_end_clean();
					}

					readfile($file, 'rb');

					exit();
				} else {
					exit('Error: Could not find file ' . $file . '!');
				}
			} else {
				exit('Error: Headers already sent out!');
			}

		}
	}
}
?>