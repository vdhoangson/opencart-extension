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
		$this->load->language('penblog/article');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('penblog/article');

		$this->getList();
	}

	public function add() {
		$this->load->language('penblog/article');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('penblog/article');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_penblog_article->addArticle($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->response->redirect($this->url->link('penblog/article', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('penblog/article');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('penblog/article');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_penblog_article->editArticle($this->request->get['article_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->response->redirect($this->url->link('penblog/article', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('penblog/article');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('penblog/article');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $article_id) {
				$this->model_penblog_article->deleteArticle($article_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->response->redirect($this->url->link('penblog/article', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	public function copy(){
		$this->load->language('penblog/article');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('penblog/article');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $article_id) {
				$this->model_penblog_article->copyArticle($article_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->response->redirect($this->url->link('penblog/article', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();

	}

	protected function getList() {
		$setting = $this->config->get('penblog_setting');

		$data_filter = array('filter_name', 'filter_category', 'filter_date_added','filter_date_modified', 'filter_status');

		foreach($data_filter as $filter){
			if (isset($this->request->get[$filter])) {
				$$filter = $this->request->get[$filter];
			} else {
				$$filter = null;
			}
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pd.name';
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

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . urlencode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . urlencode(html_entity_decode($this->request->get['filter_date_modified'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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

		$this->load->model('penblog/comment');

		$this->load->model('penblog/category');

		$data = array();

		$data['categories'] = $this->model_penblog_category->getCategories($data);

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('penblog_dashboard'),
			'href' => $this->url->link('penblog/dashboard', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('penblog/article', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('penblog/article/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('penblog/article/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['copy'] = $this->url->link('penblog/article/copy', 'token=' . $this->session->data['token'] . $url, true);


		$data['articles'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_category'	  => $filter_category,
			'filter_date_added'	=> $filter_date_added,
			'filter_date_modified'	=> $filter_date_modified,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $setting['admin_limit'],
			'limit'           => $setting['admin_limit']
		);

		$this->load->model('tool/image');

		$article_total = $this->model_penblog_article->getTotalArticles($filter_data);

		$results = $this->model_penblog_article->getArticles($filter_data);

		foreach ($results as $result) {
			$img_type = json_decode($result['image'], true);
			if($img_type['type']=='image'){
				if (is_file(DIR_IMAGE . $img_type['image'])) {
					$image = $this->model_tool_image->resize($img_type['image'], 40, 40);
				} else {
					$image = $this->model_tool_image->resize('catalog/penblog/penblog.png', 40, 40);
				}
			} elseif($img_type['type']=='youtube'){
				$image = $this->model_tool_image->resize('catalog/penblog/penblog_youtube.jpg', 40, 40);
			}

			$data['articles'][] = array(
				'article_id' => $result['article_id'],
				'image'      => $image,
				'name'       => $result['name'],
				'date_added'	=> date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'date_modified'	=> date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
				'order'		=> $result['sort_order'],
				'comment' 	=> $this->model_penblog_comment->getTotalCommentsByArticleId($result['article_id']),
				'status'     => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'       => $this->url->link('penblog/article/edit', 'token=' . $this->session->data['token'] . '&article_id=' . $result['article_id'] . $url, true),
				'view' => HTTP_CATALOG.'index.php?route=penblog/article&article_id=' . $result['article_id']
			);
		}

		$languages = $this->language->load('penblog/article');
		foreach($languages as $key => $text){
			$data[$key] = $text;
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . urlencode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . urlencode(html_entity_decode($this->request->get['filter_date_modified'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('penblog/article', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, true);
		$data['sort_date_added'] = $this->url->link('penblog/article', 'token=' . $this->session->data['token'] . '&sort=p.date_added' . $url, true);
		$data['sort_date_modified'] = $this->url->link('penblog/article', 'token=' . $this->session->data['token'] . '&sort=p.date_modified' . $url, true);
		$data['sort_status'] = $this->url->link('penblog/article', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, true);
		$data['sort_order'] = $this->url->link('penblog/article', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . urlencode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . urlencode(html_entity_decode($this->request->get['filter_date_modified'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $article_total;
		$pagination->page = $page;
		$pagination->limit = $setting['admin_limit'];
		$pagination->url = $this->url->link('penblog/article', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($article_total) ? (($page - 1) * $setting['admin_limit']) + 1 : 0, ((($page - 1) * $setting['admin_limit']) > ($article_total - $setting['admin_limit'])) ? $article_total : ((($page - 1) * $setting['admin_limit']) + $setting['admin_limit']), $article_total, ceil($article_total / $setting['admin_limit']));

		$data['filter_name'] = $filter_name;
		$data['filter_category'] = $filter_category;
		$data['filter_date_added'] = $filter_date_added;
		$data['filter_date_modified'] = $filter_date_modified;
		$data['filter_status'] = $filter_status;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['shortcut'] = $this->load->controller('penblog/shortcut');

		$this->response->setOutput($this->load->view('penblog/article_list.tpl', $data));
	}

	protected function getForm() {

		$languages = $this->language->load('penblog/article');

		foreach($languages as $key => $text){
			$data[$key] = $text;
		}
		$data['text_form'] = !isset($this->request->get['article_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('penblog_dashboard'),
			'href' => $this->url->link('penblog/dashboard', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('penblog/article', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['article_id'])) {
			$data['action'] = $this->url->link('penblog/article/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('penblog/article/edit', 'token=' . $this->session->data['token'] . '&article_id=' . $this->request->get['article_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('penblog/article', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['article_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$article_info = $this->model_penblog_article->getArticle($this->request->get['article_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['article_description'])) {
			$data['article_description'] = $this->request->post['article_description'];
		} elseif (isset($this->request->get['article_id'])) {
			$data['article_description'] = $this->model_penblog_article->getArticleDescriptions($this->request->get['article_id']);
		} else {
			$data['article_description'] = array();
		}

		$data['image_types'] = array('image', 'youtube');

		if (isset($this->request->post['image'])) {
			$data['image'] = $image = $this->request->post['image'];
		} elseif (!empty($article_info)) {
			$data['image'] = $image = json_decode($article_info['image'],true);
		} else {
			$data['image'] = $image = array('type'=>'image','image'=>'catalog/penblog/penblog.png','youtube'=>'');
		}

		if (isset($this->request->post['main_image'])) {
			$data['main_image'] = $main_image = $this->request->post['main_image'];
		} elseif (!empty($article_info)) {
			$data['main_image'] = $main_image = json_decode($article_info['main_image'], true);
		} else {
			$data['main_image'] = $main_image = array('type'=>'image','image'=>'catalog/penblog/penblog.png','youtube'=>'');
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $image['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($image['image'], 100, 100);
		} elseif (!empty($article_info) && is_file(DIR_IMAGE . $image['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($image['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('catalog/penblog/penblog.png', 100, 100);
		}
		/* thumb main image */
		if (isset($this->request->post['main_image']) && is_file(DIR_IMAGE . $main_image['image'])) {
			$data['thumb_main_image'] = $this->model_tool_image->resize($main_image['image'], 100, 100);
		} elseif (!empty($article_info) && is_file(DIR_IMAGE . $main_image['image'])) {
			$data['thumb_main_image'] = $this->model_tool_image->resize($main_image['image'], 100, 100);
		} else {
			$data['thumb_main_image'] = $this->model_tool_image->resize('catalog/penblog/penblog.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('catalog/penblog/penblog.png', 100, 100);

		/* Store */

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['article_store'])) {
			$data['article_store'] = $this->request->post['article_store'];
		} elseif (isset($this->request->get['article_id'])) {
			$data['article_store'] = $this->model_penblog_article->getArticleStores($this->request->get['article_id']);
		} else {
			$data['article_store'] = array(0);
		}

		/* Author */
		$this->load->model('user/user');

		$data['authors'] = $this->model_user_user->getUsers();

		$data_default = array(
			'login_to_view' => 0,
			'allow_comment' => 1,
			'keyword' => '',
			'sort_order' => 0,
			'status' => 1,
			'date_added' => date("Y-m-d"),
			'date_modified' => date("Y-m-d"),
			'date_public' => date("Y-m-d"),
			'article_author' => ''
		);

		foreach($data_default as $key => $value){
			if (isset($this->request->post[$key])) {
				$data[$key] = $this->request->post[$key];
			} elseif (!empty($article_info[$key])) {
				$data[$key] = $article_info[$key];
			} else {
				$data[$key] = $value;
			}
		}

		// Images
		if (isset($this->request->post['article_image'])) {
			$article_images = $this->request->post['article_image'];
		} elseif (isset($this->request->get['article_id'])) {
			$article_images = $this->model_penblog_article->getArticleImages($this->request->get['article_id']);
		} else {
			$article_images = array();
		}

		$data['article_images'] = array();

		foreach ($article_images as $article_image) {
			if (is_file(DIR_IMAGE . $article_image['image'])) {
				$image = $article_image['image'];
				$thumb = $article_image['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['article_images'][] = array(
				'image'      => $image,
				'thumb'      => $this->model_tool_image->resize($thumb, 100, 100),
				'sort_order' => $article_image['sort_order']
			);
		}

		// Categories
		$this->load->model('penblog/category');

		if (isset($this->request->post['article_category'])) {
			$categories = $this->request->post['article_category'];
		} elseif (isset($this->request->get['article_id'])) {
			$categories = $this->model_penblog_category->getCategoriesByArticleId($this->request->get['article_id']);
		} else {
			$categories = array();
		}

		$data['article_categories'] = array();

		foreach ($categories as $category_id) {
			$category_info = $this->model_penblog_category->getCategory($category_id);

			if ($category_info) {
				$data['article_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name' => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
				);
			}
		}

		// Article related
		if (isset($this->request->post['article_related'])) {
			$articles = $this->request->post['article_related'];
		} elseif (isset($this->request->get['article_id'])) {
			$articles = $this->model_penblog_article->getArticleRelated($this->request->get['article_id']);
		} else {
			$articles = array();
		}

		$data['article_relateds'] = array();

		foreach ($articles as $article_id) {
			$related_info = $this->model_penblog_article->getArticle($article_id);

			if ($related_info) {
				$data['article_relateds'][] = array(
					'article_id' => $related_info['article_id'],
					'name'       => $related_info['name']
				);
			}
		}

		// Download
		$this->load->model('penblog/download');

		if (isset($this->request->post['article_download'])) {
			$downloads = $this->request->post['article_download'];
		} elseif (isset($this->request->get['article_id'])) {
			$downloads = $this->model_penblog_download->getDownloadByArticleId($this->request->get['article_id']);
		} else {
			$downloads = array();
		}

		$data['downloads'] = array();

		foreach ($downloads as $download) {

			$data['downloads'][] = array(
				'download_id' => $download['download_id'],
				'name'       => $download['name']
			);
		}
		// Products
		$this->load->model('catalog/product');

		if (isset($this->request->post['article_product'])) {
			$products = $this->request->post['article_product'];
		} elseif (isset($this->request->get['article_id'])) {
			$products = $this->model_penblog_article->getProductsByArticleId($this->request->get['article_id']);
		} else {
			$products = array();
		}

		$data['products'] = array();

		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);

			if ($product_info) {
				$data['products'][] = array(
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name']
				);
			}
		}

		// Poll
		$this->load->model('penblog/poll');

		$data['polls'] = $this->model_penblog_poll->getPolls();

		if (isset($this->request->post['poll_id'])) {
      		$data['poll_id'] = $this->request->post['poll_id'];
		} elseif (!empty($article_info)) {
			$data['poll_id'] = $this->model_penblog_poll->getPollByArticleId($article_info['article_id']);
		} else {
      		$data['poll_id'] = 0;
    	} 

		if (isset($this->request->post['article_layout'])) {
			$data['article_layout'] = $this->request->post['article_layout'];
		} elseif (isset($this->request->get['article_id'])) {
			$data['article_layout'] = $this->model_penblog_article->getArticleLayouts($this->request->get['article_id']);
		} else {
			$data['article_layout'] = array();
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['shortcut'] = $this->load->controller('penblog/shortcut');

		$this->response->setOutput($this->load->view('penblog/article_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'penblog/article')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['article_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}

			if ((utf8_strlen($value['description']) < 30)) {
				$this->error['description'][$language_id] = $this->language->get('error_description');
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'penblog/article')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'penblog/article')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('penblog/article');

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 5;
			}

			$filter_data = array(
				'filter_name'  => $filter_name,
				'start'        => 0,
				'limit'        => $limit
			);

			$results = $this->model_penblog_article->getArticles($filter_data);

			foreach ($results as $result) {
				$option_data = array();

				$json[] = array(
					'article_id' => $result['article_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}