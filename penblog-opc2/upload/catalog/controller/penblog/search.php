<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerPenBlogSearch extends Controller {
	public function index() {
		$languages = $this->load->language('penblog/search');

		foreach($languages as $key => $value){
			$data[$key] = $value;
		}

		$this->load->model('penblog/category');

		$this->load->model('penblog/article');

		$this->load->model('penblog/image');

		$setting = $this->config->get('penblog_setting');

		foreach($setting as $key => $value){
			$data[$key] = $value;
		}

		if (isset($this->request->get['penblog_search'])) {
			$penblog_search = $this->request->get['penblog_search'];
		} else {
			$penblog_search = '';
		}

		if (isset($this->request->get['tag'])) {
			$tag = $this->request->get['tag'];
		} elseif (isset($this->request->get['penblog_search'])) {
			$tag = $this->request->get['penblog_search'];
		} else {
			$tag = '';
		}

		if (isset($this->request->get['description'])) {
			$description = $this->request->get['description'];
		} else {
			$description = '';
		}

		if (isset($this->request->get['category_id'])) {
			$category_id = $this->request->get['category_id'];
		} else {
			$category_id = 0;
		}

		if (isset($this->request->get['sub_category'])) {
			$sub_category = $this->request->get['sub_category'];
		} else {
			$sub_category = '';
		}

		if (isset($this->request->get['date_added'])) {
			$date_added = $this->request->get['date_added'];
		} else {
			$date_added = '';
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

		if (isset($this->request->get['penblog_search'])) {
			$this->document->setTitle($this->language->get('heading_title') .  ' - ' . $this->request->get['penblog_search']);
		} elseif (isset($this->request->get['tag'])) {
			$this->document->setTitle($this->language->get('heading_title') .  ' - ' . $this->language->get('heading_tag') . $this->request->get['tag']);
		} else {
			$this->document->setTitle($this->language->get('heading_title'));
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$url = '';

		if (isset($this->request->get['penblog_search'])) {
			$url .= '&search=' . urlencode(html_entity_decode($this->request->get['penblog_search'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['tag'])) {
			$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
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

		if (isset($this->request->get['date_added'])) {
			$url .= '&date_added=' . $this->request->get['date_added'];
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
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('penblog/search', $url)
		);

		if (isset($this->request->get['penblog_search'])) {
			$data['heading_title'] = $this->language->get('heading_title') .  ' - ' . $this->request->get['penblog_search'];
		} else {
			$data['heading_title'] = $this->language->get('heading_title');
		}

		$data['button_search'] = $this->language->get('button_search');
		$data['button_list'] = $this->language->get('button_list');
		$data['button_grid'] = $this->language->get('button_grid');

		$data['link_to_product_search'] = $this->url->link('product/search', $url);

		$this->load->model('penblog/category');

		// 3 Level Category Search
		$data['categories'] = array();

		$categories_1 = $this->model_penblog_category->getCategories(0);

		foreach ($categories_1 as $category_1) {
			$level_2_data = array();

			$categories_2 = $this->model_penblog_category->getCategories($category_1['category_id']);

			foreach ($categories_2 as $category_2) {
				$level_3_data = array();

				$categories_3 = $this->model_penblog_category->getCategories($category_2['category_id']);

				foreach ($categories_3 as $category_3) {
					$level_3_data[] = array(
						'category_id' => $category_3['category_id'],
						'name'        => $category_3['name'],
					);
				}

				$level_2_data[] = array(
					'category_id' => $category_2['category_id'],
					'name'        => $category_2['name'],
					'children'    => $level_3_data
				);
			}

			$data['categories'][] = array(
				'category_id' => $category_1['category_id'],
				'name'        => $category_1['name'],
				'children'    => $level_2_data
			);
		}

		$data['articles'] = array();

		if (isset($this->request->get['penblog_search']) || isset($this->request->get['tag']) || isset($this->request->get['date_added'])) {
			$filter_data = array(
				'filter_name'         => $penblog_search,
				'filter_tag'          => $tag,
				'filter_description'  => $description,
				'filter_category_id'  => $category_id,
				'filter_sub_category' => $sub_category,
				'filter_date_added' => $date_added,
				'sort'                => $sort,
				'order'               => $order,
				'start'               => ($page - 1) * $limit,
				'limit'               => $limit
			);

			$article_total = $this->model_penblog_article->getTotalArticles($filter_data);

			$results = $this->model_penblog_article->getArticles($filter_data);

			foreach ($results as $result) {
				if ($result['image']) {
					$img_type = json_decode($result['image'], true);
					if($img_type['type']=='image'){
						if(!empty($img_type['image']) && is_file(DIR_IMAGE . $img_type['image'])){
							$image = $this->model_penblog_image->cropsize($img_type['image'], $setting['catalog_image_article_width'], $setting['catalog_image_article_height']);
						} else {
							$image = $this->model_penblog_image->cropsize('catalog/penblog/penblog.png', $setting['catalog_image_article_width'], $setting['catalog_image_article_height']);
						}

					} elseif($img_type['type']=='youtube'){
						$yt_link = str_replace('https://www.youtube.com/watch?v=', 'http://www.youtube.com/embed/', $img_type['youtube']) ;
						$image = $yt_link.'?&fs='.$setting['youtube_allow_fullsreen'].'&ap='.$setting['youtube_quanlity'].'&theme='.$setting['youtube_template'].'&controls='.$setting['youtube_show_control'].'&autohide='.$setting['youtube_autohide'].'&rel='.$setting['youtube_related_video'];
					}
				} else {
					$image = $this->model_penblog_image->cropsize('catalog/penblog/penblog.png', $setting['catalog_image_article_width'], $setting['catalog_image_article_height']);
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
					$link = $this->url->link('penblog/article', 'article_id=' . $result['article_id']);
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

			if (isset($this->request->get['penblog_search'])) {
				$url .= '&penblog_search=' . urlencode(html_entity_decode($this->request->get['penblog_search'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
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

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['sorts'] = array();

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('penblog/search', 'sort=p.sort_order&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('penblog/search', 'sort=pd.name&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('penblog/search', 'sort=pd.name&order=DESC' . $url)
			);

			if ($setting['comment_status']) {
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/search', 'sort=rating&order=DESC' . $url)
				);

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('product/search', 'sort=rating&order=ASC' . $url)
				);
			}

			$url = '';

			if (isset($this->request->get['penblog_search'])) {
				$url .= '&penblog_search=' . urlencode(html_entity_decode($this->request->get['penblog_search'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
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

			$data['limits'] = array();

			$limits = array_unique(array($setting['catalog_limit'], 25, 50, 75, 100));

			sort($limits);

			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('penblog/search', $url . '&limit=' . $value)
				);
			}

			$url = '';

			if (isset($this->request->get['penblog_search'])) {
				$url .= '&penblog_search=' . urlencode(html_entity_decode($this->request->get['penblog_search'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
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

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$pagination = new Pagination();
			$pagination->total = $article_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('penblog/search', $url . '&page={page}');

			$data['pagination'] = $pagination->render();

			$data['results'] = sprintf($this->language->get('text_pagination'), ($article_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($article_total - $limit)) ? $article_total : ((($page - 1) * $limit) + $limit), $article_total, ceil($article_total / $limit));
		}

		$data['penblog_search'] = $penblog_search;
		$data['description'] = $description;
		$data['category_id'] = $category_id;
		$data['sub_category'] = $sub_category;

		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['limit'] = $limit;

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$template = 'penblog/search';
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