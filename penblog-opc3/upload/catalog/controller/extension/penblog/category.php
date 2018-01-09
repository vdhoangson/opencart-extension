<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerExtensionPenBlogCategory extends Controller {
	public function index() {
		$languages = $this->language->load('extension/penblog/category');
		foreach($languages as $key => $text){
			$data[$key] = $text;
		}

		$this->load->model('extension/penblog/category');

		$this->load->model('extension/penblog/article');

		$this->load->model('extension/penblog/image');

		$setting = $this->config->get('penblog_setting');

		foreach($setting as $key => $value) {
			$data[$key] = $value;
		}

		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $setting['catalog_limit'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		if (isset($this->request->get['penblog_path'])) {
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$path = '';

			$parts = explode('_', (string)$this->request->get['penblog_path']);

			$category_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}

				$category_info = $this->model_extension_penblog_category->getCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $category_info['name'],
						'href' => $this->url->link('extension/penblog/category', 'penblog_path=' . $path . $url)
					);
				}
			}
		} else {
			$category_id = 0;
		}

		$category_info = $this->model_extension_penblog_category->getCategory($category_id);

		if ($category_info) {
			$this->document->setTitle($category_info['name']);
			$this->document->setDescription($category_info['meta_description']);
			$this->document->setKeywords($category_info['meta_keyword']);
			$this->document->addLink($this->url->link('extension/penblog/category', 'penblog_path=' . $this->request->get['penblog_path']), 'canonical');

			$data['heading_title'] = $category_info['name'];

			$data['button_continue'] = $this->language->get('button_continue');
			$data['button_list'] = $this->language->get('button_list');
			$data['button_grid'] = $this->language->get('button_grid');

			$article_language = $this->language->load('penblog/article');
			foreach($article_language as $key => $text){
				$data[$key] = $text;
			}

			// Set the last category breadcrumb
			$data['breadcrumbs'][] = array(
				'text' => $category_info['name'],
				'href' => $this->url->link('extension/penblog/category', 'penblog_path=' . $this->request->get['penblog_path'])
			);

			if ($category_info['image']) {
				$data['thumb'] = $this->model_extension_penblog_image->cropsize($category_info['image'], $setting['catalog_image_width'], $setting['catalog_image_height']);
			} else {
				$data['thumb'] = '';
			}

			$data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['categories'] = array();

			$results = $this->model_extension_penblog_category->getCategories($category_id);

			foreach ($results as $result) {
				$filter_data = array(
					'filter_category_id'  => $result['category_id'],
					'filter_sub_category' => true
				);

				$data['categories'][] = array(
					'name'  => $result['name'] . ($this->config->get('config_article_count') ? ' (' . $this->model_extension_penblog_article->getTotalArticles($filter_data) . ')' : ''),
					'href'  => $this->url->link('extension/penblog/category', 'penblog_path=' . $this->request->get['penblog_path'] . '_' . $result['category_id'] . $url)
				);
			}

			/* Article */
			$data['articles'] = array();

			$filter_data = array(
				'filter_category_id' => $category_id,
				'filter_filter'      => $filter,
				'sort'               => $sort,
				'order'              => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);

			$article_total = $this->model_extension_penblog_article->getTotalArticles($filter_data);

			$results = $this->model_extension_penblog_article->getArticles($filter_data);

			foreach ($results as $result) {
				if ($result['image']) {
					$img_type = json_decode($result['image'], true);
					if($img_type['type']=='image'){
						if(!empty($img_type['image']) && is_file(DIR_IMAGE . $img_type['image'])){
							$image = $this->model_extension_penblog_image->cropsize($img_type['image'], $setting['catalog_image_article_width'], $setting['catalog_image_article_height']);
						} else {
							$image = $this->model_extension_penblog_image->cropsize('catalog/penblog/penblog.png', $setting['catalog_image_article_width'], $setting['catalog_image_article_height']);
						}

					} elseif($img_type['type']=='youtube'){
						$yt_link = str_replace('https://www.youtube.com/watch?v=', 'http://www.youtube.com/embed/', $img_type['youtube']) ;
						$image = $yt_link.'?&fs='.$setting['youtube_allow_fullsreen'].'&ap='.$setting['youtube_quanlity'].'&theme='.$setting['youtube_template'].'&controls='.$setting['youtube_show_control'].'&autohide='.$setting['youtube_autohide'].'&rel='.$setting['youtube_related_video'];
					}
				} else {
					$image = $this->model_extension_penblog_image->cropsize('catalog/penblog/penblog.png', $setting['catalog_image_article_width'], $setting['catalog_image_article_height']);
					$img_type = array('type'=>'','image'=>'','youtube'=>'');
				}



				if ($setting['comment_status'] == 1 && $result['allow_comment'] == 1) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}

				if($result['author_id']){
					$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "user` WHERE user_id = '" . (int)$result['author_id'] . "'");

					$author = $query->row['username'];
				}

				if(($result['login_to_view'] == 1 && $this->customer->isLogged()) || $result['login_to_view'] == 0){
					$link = $this->url->link('extension/penblog/article', 'article_id=' . $result['article_id']);
				} else {
					$link = $this->url->link('account/login');
				}

				$data['articles'][] = array(
					'article_id'        => $result['article_id'],
					'thumb'             => $image,
					'img_type'          => $img_type['type'],
					'name'              => $result['name'],
					'short_description' => utf8_substr(strip_tags(html_entity_decode($result['short_description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
					'rating'            => $result['rating'],
					'href'              => $link,
					'author'            => $author,
					'date_added'        => date(isset($setting['date_format'])?$setting['date_format']:"Y-m-d",strtotime($result['date_added'])),
					'date_modified'     => date(isset($setting['date_format'])?$setting['date_format']:"Y-m-d",strtotime($result['date_modified'])),
					'viewed'            => $result['viewed']
				);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['sorts'] = array();

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('extension/penblog/category', 'penblog_path=' . $this->request->get['penblog_path'] . '&sort=p.sort_order&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('extension/penblog/category', 'penblog_path=' . $this->request->get['penblog_path'] . '&sort=pd.name&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('extension/penblog/category', 'penblog_path=' . $this->request->get['penblog_path'] . '&sort=pd.name&order=DESC' . $url)
			);


			$data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_desc'),
				'value' => 'rating-DESC',
				'href'  => $this->url->link('extension/penblog/category', 'penblog_path=' . $this->request->get['penblog_path'] . '&sort=rating&order=DESC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_rating_asc'),
				'value' => 'rating-ASC',
				'href'  => $this->url->link('extension/penblog/category', 'penblog_path=' . $this->request->get['penblog_path'] . '&sort=rating&order=ASC' . $url)
			);

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			$data['limits'] = array();

			$limits = array_unique(array($setting['catalog_limit'], 5, 15, 25, 50));

			sort($limits);

			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('extension/penblog/category', 'penblog_path=' . $this->request->get['penblog_path'] . $url . '&limit=' . $value)
				);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$pagination = new Pagination();
			$pagination->total = $article_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('extension/penblog/category', 'penblog_path=' . $this->request->get['penblog_path'] . $url . '&page={page}');

			$data['pagination'] = $pagination->render();

			$data['results'] = sprintf($this->language->get('text_pagination'), ($article_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($article_total - $limit)) ? $article_total : ((($page - 1) * $limit) + $limit), $article_total, ceil($article_total / $limit));

			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;

			$data['continue'] = $this->url->link('common/home');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$template = 'extension/penblog/category';
			$this->response->setOutput($this->load->view($template, $data));
		} else {
			$url = '';

			if (isset($this->request->get['penblog_path'])) {
				$url .= '&penblog_path=' . $this->request->get['penblog_path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
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
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('extension/penblog/category', $url)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$template = 'error/not_found';
			$this->response->setOutput($this->load->view($template, $data));
		}
	}
}