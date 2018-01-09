<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelExtensionPenBlogArticle extends Model {
	public function addArticle($data) {
		$this->event->trigger('pre.admin.article.add', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_article SET sort_order = '" . (int)$data['sort_order'] . "', author_id = '" . $data['article_author'] . "', login_to_view = '" . (int)$data['login_to_view'] . "', allow_comment = '" . (int)$data['allow_comment'] . "', status = '" . (int)$data['status'] . "', date_added = NOW()");

		$article_id = $this->db->getLastId();

		foreach ($data['article_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_article_description SET article_id = '" . (int)$article_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', short_description = '" . $this->db->escape($value['short_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', tag = '" . $this->db->escape($value['tag']) . "'");
		}

		if (isset($data['article_category'])) {
			foreach ($data['article_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_article_to_category SET article_id = '" . (int)$article_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "penblog_article SET image = '" . $this->db->escape(json_encode($data['image'], true)) . "' WHERE article_id = '" . (int)$article_id . "'");
		}

		if (isset($data['main_image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "penblog_article SET main_image = '" . $this->db->escape(json_encode($data['main_image'], true)) . "' WHERE article_id = '" . (int)$article_id . "'");
		}

		if (isset($data['article_image'])) {
			foreach ($data['article_image'] as $article_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_article_image SET article_id = '" . (int)$article_id . "', image = '" . $this->db->escape($article_image['image']) . "', sort_order = '" . (int)$article_image['sort_order'] . "'");
			}
		}

		if (isset($data['article_store'])) {
			foreach ($data['article_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_article_to_store SET article_id = '" . (int)$article_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['article_layout'])) {
			foreach ($data['article_layout'] as $store_id => $layout_id) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_article_to_layout SET article_id = '" . (int)$article_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");

			}
		}

		if (isset($data['article_related'])) {
			foreach ($data['article_related'] as $related_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_article_to_related SET article_id = '" . (int)$article_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_article_to_related SET article_id = '" . (int)$article_id . "', related_id = '" . (int)$related_id . "'");
			}
		}

		if (isset($data['article_download'])) {
			foreach ($data['article_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_article_to_download SET article_id = '" . (int)$article_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		if (isset($data['article_product'])) {
			foreach ($data['article_product'] as $product_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_article_to_product SET article_id = '" . (int)$article_id . "', product_id = '" . (int)$product_id . "'");
			}
		}

		if (isset($data['poll_id'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_poll_to_article SET poll_id = '" . (int)$data['poll_id'] . "', article_id = '" . (int)$article_id . "'");
		}

		if (isset($data['article_seo_url'])) {
			foreach ($data['article_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'article_id=" . (int)$article_id . "', keyword = '" . $this->db->escape($keyword) . "'");
					}
				}
			}
		}

        if(isset($data['date_added'])){
        	$this->db->query("UPDATE " . DB_PREFIX . "penblog_article SET date_added='" . $this->db->escape($data['date_added']) . "' WHERE article_id='" . (int)$article_id . "'");
        }

        if(isset($data['date_modified'])){
        	$this->db->query("UPDATE " . DB_PREFIX . "penblog_article SET date_modified='" . $this->db->escape($data['date_modified']) . "' WHERE article_id='" . (int)$article_id . "'");
        }

        if(isset($data['date_public'])){
        	$this->db->query("UPDATE " . DB_PREFIX . "penblog_article SET date_public='" . $this->db->escape($data['date_public']) . "' WHERE article_id='" . (int)$article_id . "'");
        } else {
        	$this->db->query("UPDATE " . DB_PREFIX . "penblog_article SET date_public='" . $this->db->escape($data['date_added']) . "' WHERE article_id='" . (int)$article_id . "'");
        }

		$this->cache->delete('article');
	}

	public function editArticle($article_id, $data) {

		$this->db->query("DELETE FROM " . DB_PREFIX . "penblog_article_description WHERE article_id = '" . (int)$article_id . "'");

		foreach ($data['article_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_article_description SET article_id = '" . (int)$article_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', short_description = '" . $this->db->escape($value['short_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', tag = '" . $this->db->escape($value['tag']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "penblog_article_to_category WHERE article_id = '" . (int)$article_id . "'");

		if (isset($data['article_category'])) {
			foreach ($data['article_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_article_to_category SET article_id = '" . (int)$article_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "penblog_article SET image = '" . $this->db->escape(json_encode($data['image'], true)) . "' WHERE article_id = '" . (int)$article_id . "'");
		}

		if (isset($data['main_image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "penblog_article SET main_image = '" . $this->db->escape(json_encode($data['main_image'], true)) . "' WHERE article_id = '" . (int)$article_id . "'");
		}

		if(isset($data['login_to_view'])){
			$this->db->query("UPDATE " . DB_PREFIX . "penblog_article SET login_to_view = '" . (int)$data['login_to_view'] . "' WHERE article_id = '" . (int)$article_id . "'");
		}

		if(isset($data['allow_comment'])){
			$this->db->query("UPDATE " . DB_PREFIX . "penblog_article SET allow_comment = '" . (int)$data['allow_comment'] . "' WHERE article_id = '" . (int)$article_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "penblog_article_image WHERE article_id = '" . (int)$article_id . "'");

		if (isset($data['article_image'])) {
			foreach ($data['article_image'] as $article_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_article_image SET article_id = '" . (int)$article_id . "', image = '" . $this->db->escape($article_image['image']) . "', sort_order = '" . (int)$article_image['sort_order'] . "'");
			}
		}


		$this->db->query("DELETE FROM " . DB_PREFIX . "penblog_article_to_store WHERE article_id = '" . (int)$article_id . "'");

		if (isset($data['article_store'])) {
			foreach ($data['article_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_article_to_store SET article_id = '" . (int)$article_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "penblog_article_to_layout WHERE article_id = '" . (int)$article_id . "'");

		if (isset($data['article_layout'])) {
			foreach ($data['article_layout'] as $store_id => $layout_id) {

				$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_article_to_layout SET article_id = '" . (int)$article_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");

			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "penblog_article_to_related WHERE article_id = '" . (int)$article_id . "'");

		if (isset($data['article_related'])) {
			foreach ($data['article_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "penblog_article_to_related WHERE article_id = '" . (int)$article_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_article_to_related SET article_id = '" . (int)$article_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "penblog_article_to_related WHERE article_id = '" . (int)$related_id . "' AND related_id = '" . (int)$article_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_article_to_related SET article_id = '" . (int)$related_id . "', related_id = '" . (int)$article_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "penblog_article_to_download WHERE article_id = '" . (int)$article_id . "'");

		if (isset($data['article_download'])) {
			foreach ($data['article_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_article_to_download SET article_id = '" . (int)$article_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "penblog_article_to_product WHERE article_id = '" . (int)$article_id . "'");

		if (isset($data['article_product'])) {
			foreach ($data['article_product'] as $product_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_article_to_product SET article_id = '" . (int)$article_id . "', product_id = '" . (int)$product_id . "'");
			}
		}
		// Poll
		$this->db->query("DELETE FROM " . DB_PREFIX . "penblog_poll_to_article WHERE article_id = '" . (int)$article_id . "'");

		if (isset($data['poll_id'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_poll_to_article SET poll_id = '" . (int)$data['poll_id'] . "', article_id = '" . (int)$article_id . "'");
		}

		// SEO
		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'article_id=" . (int)$article_id. "'");

		if (isset($data['article_seo_url'])) {
			foreach ($data['article_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'article_id=" . (int)$article_id . "', keyword = '" . $this->db->escape($keyword) . "'");
					}
				}
			}
		}

        if(isset($data['date_added'])){
        	$this->db->query("UPDATE " . DB_PREFIX . "penblog_article SET date_added='" . $this->db->escape($data['date_added']) . "' WHERE article_id='" . (int)$article_id . "'");
        }

        if(isset($data['date_modified'])){
        	$this->db->query("UPDATE " . DB_PREFIX . "penblog_article SET date_modified='" . $this->db->escape($data['date_modified']) . "' WHERE article_id='" . (int)$article_id . "'");
        }else{
        	$this->db->query("UPDATE " . DB_PREFIX . "penblog_article SET date_modified=NOW() WHERE article_id='" . (int)$article_id . "'");
        }

        if(isset($data['date_public'])){
        	$this->db->query("UPDATE " . DB_PREFIX . "penblog_article SET date_public='" . $this->db->escape($data['date_public']) . "' WHERE article_id='" . (int)$article_id . "'");
        }

        if(isset($data['status'])){
        	$this->db->query("UPDATE " . DB_PREFIX . "penblog_article SET status='" . (int)$data['status'] . "' WHERE article_id='" . (int)$article_id . "'");
        }

        if(isset($data['sort_order'])){
        	$this->db->query("UPDATE " . DB_PREFIX . "penblog_article SET sort_order='" . (int)$data['sort_order'] . "' WHERE article_id='" . (int)$article_id . "'");
        }

		$this->cache->delete('article');
	}

	public function copyArticle($article_id){
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "penblog_article a LEFT JOIN " . DB_PREFIX . "penblog_article_description ad ON (a.article_id = ad.article_id) WHERE a.article_id = '" . (int)$article_id . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		if ($query->num_rows) {
			$article = $query->row;

			$data['keyword'] = '';
			$data['status'] = '0';
			$data['viewed'] = '0';
			$data['sort_order'] = '0';
			$data['date_added'] = date("Y-m-d");
			$data['date_modified'] = date("Y-m-d");
			$data['date_public'] = date("Y-m-d");

			$data['login_to_view'] = $article['login_to_view'];
			$data['allow_comment'] = $article['allow_comment'];

			$data['article_description'] = $this->getArticleDescriptions($article_id);
			$data['article_category'] = $this->getArticleCategories($article_id);
			$data['article_author'] = $article['author_id'];
			$data['article_layout'] = $this->getArticleLayouts($article_id);
			$data['article_store'] = $this->getArticleStores($article_id);

			$this->addArticle($data);
		}
	}

	public function deleteArticle($article_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "penblog_article WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "penblog_article_description WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "penblog_article_to_store WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "penblog_article_to_layout WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "penblog_article_to_category WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'article_id=" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "penblog_article_to_related WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "penblog_article_to_related WHERE related_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "penblog_article_download WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "penblog_article_product WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "penblog_poll_to_article WHERE article_id = '" . (int)$article_id . "'");

		$this->cache->delete('article');
	}

	public function getArticle($article_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "seo_url WHERE query = 'article_id=" . (int)$article_id . "') AS keyword FROM " . DB_PREFIX . "penblog_article a LEFT JOIN " . DB_PREFIX . "penblog_article_description ad ON (a.article_id=ad.article_id) WHERE a.article_id = '" . (int)$article_id . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getArticles($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "penblog_article a LEFT JOIN " . DB_PREFIX . "penblog_article_description ad ON (a.article_id = ad.article_id)";

			if (!empty($data['filter_category'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "penblog_article_to_category a2c ON (a.article_id = a2c.article_id)";
			}

			$sql .= " WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			if (!empty($data['filter_name'])) {
				$sql .= " AND ad.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
			}

			if (!empty($data['filter_date_added'])) {
				$sql .= " AND a.date_added LIKE '" . $this->db->escape($data['filter_date_added']) . "%'";
			}

			if (!empty($data['filter_date_modified'])) {
				$sql .= " AND a.date_modified LIKE '" . $this->db->escape($data['filter_date_modified']) . "%'";
			}

			if (!empty($data['filter_category'])) {
				$sql .= " AND a2c.category_id = '" . $this->db->escape($data['filter_category']) . "'";
			}

			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$sql .= " AND a.status = '" . (int)$data['filter_status'] . "'";
			}

			$sort_data = array(
				'id.name',
				'a.sort_order'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY ad.name";
			}

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}

			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}

				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}

			$query = $this->db->query($sql);

			return $query->rows;
		} else {
			$articles_data = $this->cache->get('article.' . (int)$this->config->get('config_language_id'));

			if (!$articles_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "penblog_article i LEFT JOIN " . DB_PREFIX . "penblog_article_description id ON (i.article_id = id.article_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY id.name");

				$articles_data = $query->rows;

				$this->cache->set('article.' . (int)$this->config->get('config_language_id'), $articles_data);
			}

			return $articles_data;
		}
	}

	public function getArticleDescriptions($article_id) {
		$article_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "penblog_article_description WHERE article_id = '" . (int)$article_id . "'");

		foreach ($query->rows as $result) {
			$article_description_data[$result['language_id']] = array(
				'name'       => $result['name'],
				'description' => $result['description'],
				'short_description'	=> $result['short_description'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'	=> $result['meta_keyword'],
				'tag'	=> $result['tag']
			);
		}

		return $article_description_data;
	}

	public function getArticleCategories($article_id) {
		$article_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "penblog_article_to_category WHERE article_id = '" . (int)$article_id . "'");

		foreach ($query->rows as $result) {
			$article_category_data[] = $result['category_id'];
		}

		return $article_category_data;
	}

	public function getArticleStores($article_id) {
		$article_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "penblog_article_to_store WHERE article_id = '" . (int)$article_id . "'");

		foreach ($query->rows as $result) {
			$article_store_data[] = $result['store_id'];
		}

		return $article_store_data;
	}

	public function getArticleLayouts($article_id) {
		$article_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "penblog_article_to_layout WHERE article_id = '" . (int)$article_id . "'");

		foreach ($query->rows as $result) {
			$article_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $article_layout_data;
	}

	public function getArticleRelated($article_id) {
		$article_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "penblog_article_to_related WHERE article_id = '" . (int)$article_id . "'");

		foreach ($query->rows as $result) {
			$article_related_data[] = $result['related_id'];
		}

		return $article_related_data;
	}

	public function getTotalArticles() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "penblog_article");

		return $query->row['total'];
	}

	public function getTotalArticlesByCategory($category_id){
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "penblog_article_to_category a2c LEFT JOIN " . DB_PREFIX . "penblog_article a ON (a2c.article_id = a.article_id) WHERE category_id='" . $category_id . "'");

		return $query->row['total'];
	}

	public function getTotalArticlesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "penblog_article_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}

	public function getArticleImages($article_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "penblog_article_image WHERE article_id = '" . (int)$article_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}



	public function getTotalPublicArticles() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "penblog_article WHERE status='1'");

		return $query->row['total'];
	}

	public function getTotalUnPublicArticles() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "penblog_article WHERE status='0'");

		return $query->row['total'];
	}

	public function getLatestArticles(){
		$latest_articles = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "penblog_article a LEFT JOIN " .DB_PREFIX. "penblog_article_to_store a2s ON(a.article_id=a2s.article_id) WHERE a.status='1' AND a.date_public <= NOW() AND a2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY a.date_added DESC LIMIT 10");

		foreach($query->rows as $result){
			$latest_articles[$result['article_id']] = $this->getArticle($result['article_id']);
		}

		return $latest_articles;
	}

	public function getTotalArticlesByDownloadId($download_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "penblog_article_to_download WHERE download_id = '" . (int)$download_id . "'");

		return $query->row['total'];
	}

	public function getProductsByArticleId($article_id) {
		$article_product_data = array();

		$query = $this->db->query("SELECT * FROM " .DB_PREFIX. "penblog_article_to_product WHERE article_id='" . (int)$article_id . "'");

		foreach ($query->rows as $result) {
			$article_product_data[] = $result['product_id'];
		}

		return $article_product_data;
	}

	public function getArticleSeoUrls($article_id) {
		$article_seo_url_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query = 'article_id=" . (int)$article_id . "'");

		foreach ($query->rows as $result) {
			$article_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
		}

		return $article_seo_url_data;
	}

}
?>