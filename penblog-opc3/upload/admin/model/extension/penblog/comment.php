<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelExtensionPenBlogComment extends Model {
	public function addComment($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_comment SET author = '" . $this->db->escape($data['author']) . "', article_id = '" . $this->db->escape($data['article_id']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_added = NOW()");

		$this->cache->delete('article');
	}

	public function editComment($comment_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "penblog_comment SET author = '" . $this->db->escape($data['author']) . "', article_id = '" . $this->db->escape($data['article_id']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_added = NOW() WHERE comment_id = '" . (int)$comment_id . "'");

		$this->cache->delete('article');
	}

	public function deleteComment($comment_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "penblog_comment WHERE comment_id = '" . (int)$comment_id . "'");

		$this->cache->delete('article');
	}

	public function getComment($comment_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT ad.name FROM " . DB_PREFIX . "penblog_article_description ad WHERE ad.article_id = r.article_id AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "') AS article FROM " . DB_PREFIX . "penblog_comment r WHERE r.comment_id = '" . (int)$comment_id . "'");

		return $query->row;
	}

	public function getComments($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "penblog_comment r LEFT JOIN " . DB_PREFIX . "penblog_article_description ad ON (r.article_id = ad.article_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$sort_data = array(
			'ad.name',
			'r.author',
			'r.rating',
			'r.status',
			'r.date_added'
		);

		if (!empty($data['filter_date_added'])) {
				$sql .= " AND r.date_added LIKE '" . $this->db->escape($data['filter_date_added']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$sql .= " AND r.status = '" . (int)$data['filter_status'] . "'";
		}

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY r.date_added";
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
	}

	public function getTotalComments() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "penblog_comment");

		return $query->row['total'];
	}

	public function getTotalCommentsByArticleId($article_id){
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "penblog_comment WHERE article_id='" . $article_id . "'");

		return $query->row['total'];
	}

	public function getTotalPublicComments() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "penblog_comment WHERE status='1'");

		return $query->row['total'];
	}

	public function getTotalUnPublicComments() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "penblog_comment WHERE status = '0'");

		return $query->row['total'];
	}

	public function setApproval($comment_id){
		$this->db->query("UPDATE " . DB_PREFIX . "penblog_comment SET status='1' WHERE comment_id = '" . (int)$comment_id . "'");
	}

	public function setUnapproval($comment_id){
		$this->db->query("UPDATE " . DB_PREFIX . "penblog_comment SET status='0' WHERE comment_id = '" . (int)$comment_id . "'");
	}
}
?>