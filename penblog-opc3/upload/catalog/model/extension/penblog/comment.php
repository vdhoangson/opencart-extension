<?php
class ModelExtensionPenBlogComment extends Model {
	public function addComment($article_id, $data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_comment SET author = '" . $this->db->escape($data['name']) . "', email = '" . $this->db->escape($data['email']) . "', customer_id = '" . (int)$this->customer->getId() . "', article_id = '" . (int)$article_id . "', text = '" . $this->db->escape($data['text']) . "', rating = '" . (int)$data['rating'] . "', date_added=NOW()");

		$comment_id = $this->db->getLastId();

		if ($this->config->get('config_review_mail')) {
			$this->load->language('mail/comment');
			$this->load->model('catalog/article');

			$article_info = $this->model_penblog_article->getArticle($article_id);

			$subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));

			$message  = $this->language->get('text_waiting') . "\n";
			$message .= sprintf($this->language->get('text_article'), html_entity_decode($article_info['name'], ENT_QUOTES, 'UTF-8')) . "\n";
			$message .= sprintf($this->language->get('text_viewer'), html_entity_decode($data['name'], ENT_QUOTES, 'UTF-8')) . "\n";
			$message .= sprintf($this->language->get('text_rating'), $data['rating']) . "\n";
			$message .= $this->language->get('text_comment') . "\n";
			$message .= html_entity_decode($data['text'], ENT_QUOTES, 'UTF-8') . "\n\n";

			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($this->config->get('config_email'));
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
			$mail->setSubject($subject);
			$mail->setText($message);
			$mail->send();

			// Send to additional alert emails
			$emails = explode(',', $this->config->get('config_mail_alert'));

			foreach ($emails as $email) {
				if ($email && preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $email)) {
					$mail->setTo($email);
					$mail->send();
				}
			}
		}

	}

	public function getCommentsByArticleId($article_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "penblog_comment c LEFT JOIN " . DB_PREFIX . "penblog_article a ON (c.article_id = a.article_id) WHERE c.article_id = '" . (int)$article_id . "' AND a.status = '1' AND c.status = '1' AND c.parent='0' ORDER BY c.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalCommentsByArticleId($article_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "penblog_comment c LEFT JOIN " . DB_PREFIX . "penblog_article a ON (c.article_id = a.article_id) WHERE a.article_id = '" . (int)$article_id . "' AND a.status = '1' AND c.status = '1'");

		return $query->row['total'];
	}

	public function getCommentsByCommentId($comment_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "penblog_comment WHERE parent='" . (int)$comment_id . "' AND status='1' ORDER BY date_added DESC");

		return $query->rows;
	}

	public function addReply($article_id, $comment_id, $data = array()){
		$this->db->query("INSERT INTO " . DB_PREFIX . "penblog_comment SET author = '" . $this->db->escape($data['name']) . "', email = '" . $this->db->escape($data['email']) . "', customer_id = '" . (int)$this->customer->getId() . "', parent='" .(int)$comment_id. "', article_id = '" . (int)$article_id . "', text = '" . $this->db->escape($data['text']) . "', rating = '" . (int)$data['rating'] . "', date_added=NOW()");
	}

	public function getComment($comment_id){
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."penblog_comment WHERE comment_id = '".(int)$comment_id."'");
		return $query->row;
	}
}