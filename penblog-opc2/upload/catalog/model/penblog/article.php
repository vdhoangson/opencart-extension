<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelPenBlogArticle extends Model {

	public function updateViewed($article_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "penblog_article SET viewed = (viewed + 1) WHERE article_id = '" . (int)$article_id . "'");
	}

	public function checkAccess(){
		if($this->customer->isLogged()){
            return 1;
        } else {
            return 0;
        }
	}

	public function getArticle($article_id) {

		$sql = "SELECT DISTINCT *, ad.name AS name, a.image, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "penblog_comment r1 WHERE r1.article_id = a.article_id AND r1.status = '1' AND r1.parent='0' GROUP BY r1.article_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "penblog_comment r2 WHERE r2.article_id = a.article_id AND r2.status = '1' GROUP BY r2.article_id) AS comments, a.sort_order FROM " . DB_PREFIX . "penblog_article a LEFT JOIN " . DB_PREFIX . "penblog_article_description ad ON (a.article_id = ad.article_id) LEFT JOIN " . DB_PREFIX . "penblog_article_to_store p2s ON (a.article_id = p2s.article_id) WHERE a.article_id = '" . (int)$article_id . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND a.status = '1' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		$query = $this->db->query($sql);

		if ($query->num_rows) {
			return array(
				'article_id'       => $query->row['article_id'],
				'author_id'		   => $query->row['author_id'],
				'name'             => $query->row['name'],
				'description'      => $query->row['description'],
				'short_description'      => $query->row['short_description'],
				'meta_description' => $query->row['meta_description'],
				'meta_keyword'     => $query->row['meta_keyword'],
				'tag'              => $query->row['tag'],
				'image'            => $query->row['image'],
				'main_image'		=> $query->row['main_image'],
				'rating'           => round($query->row['rating']),
				'comments'          => $query->row['comments'] ? $query->row['comments'] : 0,
				'sort_order'       => $query->row['sort_order'],
				'status'           => $query->row['status'],
				'date_added'       => $query->row['date_added'],
				'date_modified'    => $query->row['date_modified'],
				'viewed'           => $query->row['viewed'],
				'login_to_view'			=> $query->row['login_to_view'],
				'allow_comment'			=> $query->row['allow_comment'],
			);
		} else {
			return false;
		}
	}

	public function getArticles($data = array()) {

		$sql = "SELECT a.article_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "penblog_comment r WHERE r.article_id = a.article_id AND r.status = '1' GROUP BY r.article_id) AS rating";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "penblog_category_path cp LEFT JOIN " . DB_PREFIX . "penblog_article_to_category a2c ON (cp.category_id = a2c.category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "penblog_article_to_category a2c";
			}

			$sql .= " LEFT JOIN " . DB_PREFIX . "penblog_article a ON (a2c.article_id = a.article_id)";

		} else {
			$sql .= " FROM " . DB_PREFIX . "penblog_article a";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "penblog_article_description ad ON (a.article_id = ad.article_id) LEFT JOIN " . DB_PREFIX . "penblog_article_to_store a2s ON (a.article_id = a2s.article_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND a.status = '1' AND a2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
                $implode_data = array();

                $implode_data[] = "a2c.category_id = '" . (int)$data['filter_category_id'] . "'";

                $this->load->model('penblog/category');

                $categories = $this->model_penblog_category->getTotalCategoriesByCategoryId($data['filter_category_id']);

                foreach ($categories as $category_id) {
                        $implode_data[] = "a2c.category_id = '" . (int)$category_id . "'";
                }

                $sql .= " AND (" . implode(' OR ', $implode_data) . ")";
            } else {
                if(is_array($data['filter_category_id'])){
                        $cat_ids = " a2c.category_id = ".implode(' OR a2c.category_id = ', $data['filter_category_id']);
                }
                else{
                        $cat_ids = ' a2c.category_id = '.(int)$data['filter_category_id'];
                }

                $sql .= ' AND (' .$cat_ids . ')';

            }
			
		}

		if(!empty($data['article'])){
            if(!empty($data['filter_category_id'])){
                $sql .= " OR ";
            }
            else{
                $sql .= " AND ";
            }
            if(count($data['article'])>1){
                $art_ids = " a.article_id = ".implode(" OR a.article_id = ", $data['article']);
            }
            else{
                $art_ids = " a.article_id = '".(int)$data['article'][0]."'";
            }

            $sql .= $art_ids;
        }

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "ad.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR ad.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$sql .= "ad.tag LIKE '%" . $this->db->escape($data['filter_tag']) . "%'";
			}

			$sql .= ")";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND ( a.date_added LIKE '" . $this->db->escape($data['filter_date_added']) . "%')";
		}

		$sql .= " GROUP BY a.article_id";



		$sort_data = array(
			'ad.name',
			'rating',
			'a.sort_order',
			'a.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'ad.name') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} elseif(!empty($data['order'])){
			if($data['order'] == 'latest'){
        		$sql .= " ORDER BY a.date_added ";
        	} elseif($data['order'] == 'most_view'){
        		$sql .= " ORDER BY a.viewed ";
        	}
		} else {
			$sql .= " ORDER BY a.sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(ad.name) DESC";
		} elseif(!empty($data['set_order'])){
			$sql .= " DESC";
		} else {
			$sql .= " ASC, LCASE(ad.name) ASC";
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

		$articles_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$articles_data[$result['article_id']] = $this->getArticle($result['article_id']);
		}

		return $articles_data;
	}

	public function getArticleDescriptions($article_id) {
		$article_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "penblog_article_description WHERE article_id = '" . (int)$article_id . "'");

		foreach ($query->rows as $result) {
			$article_description_data[$result['language_id']] = array(
				'name'       => $result['name'],
				'description' => $result['description']
			);
		}

		return $article_description_data;
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

	public function getTotalArticles() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "penblog_article");

		return $query->row['total'];
	}

	public function getTotalArticlesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "penblog_article_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}

	public function getCategoriesByArticleId($article_id) {
		$article_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "penblog_article_to_category a2c LEFT JOIN " . DB_PREFIX . "penblog_category_description c ON (a2c.category_id = c.category_id) WHERE article_id = '" . (int)$article_id . "'");

		foreach ($query->rows as $result) {
			$article_category_data[$result['category_id']] = array(
				'category_id' => $result['category_id'],
				'name' => $result['name'],
				'href' => 'index.php?route=penblog/category&penblog_path='.$result['category_id'],
			);
		}

		return $article_category_data;
	}

	public function getCategoryByArticleId($article_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "penblog_article_to_category a2c LEFT JOIN " . DB_PREFIX . "penblog_category_description c ON (a2c.category_id = c.category_id) WHERE article_id = '" . (int)$article_id . "'");

		return $query->row;
	}

	public function getArticleRelated($article_id) {
		$article_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "penblog_article_to_related a2r LEFT JOIN " . DB_PREFIX . "penblog_article a ON (a2r.related_id = a.article_id) LEFT JOIN " . DB_PREFIX . "penblog_article_to_store a2s ON (a.article_id = a2s.article_id) LEFT JOIN " . DB_PREFIX . "penblog_article_description ad ON (a.article_id=ad.article_id) WHERE a2r.article_id = '" . (int)$article_id . "' AND a.status = '1' AND a2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		foreach ($query->rows as $result) {
			$article_data[$result['related_id']] = $this->getArticle($result['related_id']);
		}

		return $article_data;
	}


	public function getArticleImages($article_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "penblog_article_image WHERE article_id = '" . (int)$article_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getLatestArticles($limit) {
		$article_data = $this->cache->get('article.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$article_data) {
			$query = $this->db->query("SELECT p.article_id FROM " . DB_PREFIX . "penblog_article a LEFT JOIN " . DB_PREFIX . "penblog_article_to_store a2s ON (a.article_id = a2s.article_id) WHERE a.status = '1' AND a2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY a.date_added DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$article_data[$result['article_id']] = $this->getArticle($result['article_id']);
			}

			$this->cache->set('article.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $article_data);
		}

		return $article_data;
	}

	public function getArticlesByCategory($category_id, $limit){
		$article_data = array();
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "penblog_article_to_category` WHERE category_id ='" . (int)$category_id . "' LIMIT 0, " . (int)$limit);
		foreach($query->rows as $result){
			$article_data[$result['article_id']] = $this->getArticle($result['article_id']);
		}
		return $article_data;
	}

	public function getDownloadsByArticleId($article_id){
		$query = $this->db->query("SELECT d.download_id, d.filename, d.mask, d.login_to_download, d.date_added, dd.name FROM " . DB_PREFIX . "penblog_download d LEFT JOIN " . DB_PREFIX . "penblog_article_to_download a2d ON(a2d.download_id=d.download_id) LEFT JOIN ".DB_PREFIX."penblog_download_description dd ON(d.download_id=dd.download_id) WHERE a2d.article_id='" . (int)$article_id . "' AND dd.language_id='". (int)$this->config->get('config_language_id')."'");
		return $query->rows;
	}

	public function getDownload($download_id) {

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "penblog_download` WHERE download_id = '" . (int)$download_id . "'");

		return $query->row;
	}

	public function getProductsByArticleId($article_id){
		$product_data = array();

		$query = $this->db->query("SELECT * FROM " .DB_PREFIX. "penblog_article_to_product WHERE article_id='" . (int)$article_id ."'");

		foreach($query->rows as $result){
			$product_data[] = $result['product_id'];
		}
		return $product_data;
	}
}
?>