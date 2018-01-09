<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelExtensionPenBlogTestimonial extends Model {

	public function addTestimonial($data) {
		$this->db->query("INSERT INTO ".DB_PREFIX."penblog_testimonial SET 
		customer_name = '" . $this->db->escape($data['name']) . "',
		customer_telephone = '" . $this->db->escape($data['telephone']) . "',
		customer_email = '" . $this->db->escape($data['email']) . "',
		customer_company = '" . $this->db->escape($data['company']) . "',
		competence = '" . $this->db->escape($data['competence']) . "',
		message = '" . $this->db->escape($data['message']) . "',
		rating = '" . (int)$data['rating'] . "',
		date_added = NOW()");	
		
		$testimonial_id = $this->db->getLastId();

		if (isset($data['avatar'])) {
			$this->db->query("UPDATE ".DB_PREFIX."penblog_testimonial SET avatar = '" . $this->db->escape(html_entity_decode($data['avatar'], ENT_QUOTES, 'UTF-8')) . "' WHERE testimonial_id = '" . (int)$testimonial_id . "'");
		}
		
			
		$this->load->language('penblogthemes/testimonial');	
		$subject = $this->language->get('text_subject');		
		$message = $this->language->get('text_dear'). "\n\n";		
		$message .= sprintf($this->language->get('text_opening'), $this->db->escape($data['name'])) . "\n\n";	
		$message .= $this->language->get('text_details'). "\n\n";		
		
		$message .= sprintf($this->language->get('text_sender'), $this->db->escape($data['name'])) . "\n\n";	
		if($data['telephone']){$message .= sprintf($this->language->get('text_sender_phone'), $this->db->escape($data['telephone'])) . "\n\n";}	
		$message .= sprintf($this->language->get('text_sender_email'), $this->db->escape($data['email'])) . "\n\n";			
		$message .= sprintf($this->language->get('text_sender_enquiry'), $this->db->escape($data['message'])) . "\n\n";	
		$message .= $this->language->get('text_thanks') . "\n";
		
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');	
			// Send to main admin email if new account email is enabled
				$mail->setTo($this->config->get('config_email'));
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($this->config->get('config_name'));
				$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
				$mail->setText(strip_tags(html_entity_decode($message, ENT_QUOTES, 'UTF-8')));
				$mail->send();
				
				// Send to additional alert emails if new account email is enabled
				$emails = explode(',', $this->config->get('config_alert_emails'));
				
				foreach ($emails as $email) {
					if (strlen($email) > 0 && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {
						$mail->setTo($email);
						$mail->send();
					}
				}
	}

	public function getTestimonial($testimonial_id) {
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."penblog_testimonial r WHERE r.testimonial_id = '" . (int)$testimonial_id . "'");
		
		return $query->row;
	}

	public function getTestimonials($limit){
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."penblog_testimonial r WHERE r.status = '1' LIMIT " . (int)$limit);
		return $query->rows;
	}
}