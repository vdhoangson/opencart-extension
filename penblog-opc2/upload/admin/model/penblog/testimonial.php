<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelPenBlogTestimonial extends Model {
	public function addTestimonial($data) {
		$this->db->query("INSERT INTO ".DB_PREFIX."penblog_testimonial SET 
		customer_name = '" . $this->db->escape($data['customer_name']) . "',
		customer_telephone = '" . $this->db->escape($data['customer_telephone']) . "',
		customer_email = '" . $this->db->escape($data['customer_email']) . "',
		customer_company = '" . $this->db->escape($data['customer_company']) . "',
		competence = '" . $this->db->escape($data['competence']) . "',
		message = '" . $this->db->escape($data['message']) . "',
		rating = '" . (int)$data['rating'] . "', 
		`read` = '" . (int)$data['read'] . "',
		status = '" . (int)$data['status'] . "',
		date_added = NOW()");	
		
		$testimonial_id = $this->db->getLastId();

		if (isset($data['avatar'])) {
			$this->db->query("UPDATE ".DB_PREFIX."penblog_testimonial SET avatar = '" . $this->db->escape(html_entity_decode($data['avatar'], ENT_QUOTES, 'UTF-8')) . "' WHERE testimonial_id = '" . (int)$testimonial_id . "'");
		}
		if (isset($data['service_selection'])) {
			foreach ($data['service_selection'] as $service_id) {
				$this->db->query("INSERT INTO ".DB_PREFIX."penblog_testimonial_service SET testimonial_id = '" . (int)$testimonial_id . "', service_id = '" . (int)$service_id . "'");
			}
		}
		
		
	}
	
	public function setRead($testimonial_id) {
		$this->db->query("UPDATE ".DB_PREFIX."penblog_testimonial SET `read` = '1' WHERE testimonial_id = '" . (int)$testimonial_id . "'");	
	}
	
	public function editTestimonial($testimonial_id,$data) {
		$this->db->query("UPDATE ".DB_PREFIX."penblog_testimonial SET 
		customer_name = '" . $this->db->escape($data['customer_name']) . "',
		customer_telephone = '" . $this->db->escape($data['customer_telephone']) . "',
		customer_email = '" . $this->db->escape($data['customer_email']) . "',
		customer_company = '" . $this->db->escape($data['customer_company']) . "',
		competence = '" . $this->db->escape($data['competence']) . "',
		message = '" . $this->db->escape($data['message']) . "',
		rating = '" . (int)$data['rating'] . "', 
		`read` = '" . (int)$data['read'] . "',
		status = '" . (int)$data['status'] . "',
		date_added = NOW() WHERE testimonial_id = '" . (int)$testimonial_id . "'");
		
		if (isset($data['avatar'])) {
			$this->db->query("UPDATE ".DB_PREFIX."penblog_testimonial SET avatar = '" . $this->db->escape(html_entity_decode($data['avatar'], ENT_QUOTES, 'UTF-8')) . "' WHERE testimonial_id = '" . (int)$testimonial_id . "'");
		}
		$this->db->query("DELETE FROM ".DB_PREFIX."penblog_testimonial_service WHERE testimonial_id = '" . (int)$testimonial_id . "'");
		if (isset($data['service_selection'])) {
			foreach ($data['service_selection'] as $service_id) {
				$this->db->query("INSERT INTO ".DB_PREFIX."penblog_testimonial_service SET testimonial_id = '" . (int)$testimonial_id . "', service_id = '" . (int)$service_id . "'");
			}
		}
		
	}
	
	public function deleteTestimonial($testimonial_id) {
		$this->db->query("DELETE FROM ".DB_PREFIX."penblog_testimonial WHERE testimonial_id = '" . (int)$testimonial_id . "'");	
	}
	
	public function getTestimonial($testimonial_id) {
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."penblog_testimonial r WHERE r.testimonial_id = '" . (int)$testimonial_id . "'");
		
		return $query->row;
	}
	public function getTestimonialServices($testimonial_id) {
		$services_testimonial_data = array();
		$query = $this->db->query("SELECT * FROM ".DB_PREFIX."penblog_testimonial_service WHERE testimonial_id = '" . (int)$testimonial_id . "'");
		foreach ($query->rows as $result) {
			$services_testimonial_data[] = $result['service_id'];
		}
		return $services_testimonial_data;
	}

	public function getTestimonials($data = array()) {
		$sql = "SELECT * FROM ".DB_PREFIX."penblog_testimonial r WHERE 1=1";																																			      	
		if(!empty($data['filter_rating'])){
				$sql.=" AND LCASE(r.rating) LIKE '%".$this->db->escape(utf8_strtolower($data['filter_rating']))."%'";
		}
		if(!empty($data['filter_read'])){
				$sql.=" AND LCASE(r.read) LIKE '%".$this->db->escape(utf8_strtolower($data['filter_read']))."%'";
		}
		$sort_data = array(
			'r.customer_name',
			'r.read',
			'r.rating',
			'r.status',
			'r.date_added'
		);	
			
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

	public function getLatestTestimonials(){
		$latest_testimonials = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "penblog_testimonial WHERE date_added <= NOW() ORDER BY date_added DESC LIMIT 10");

		foreach($query->rows as $result){
			$latest_testimonials[$result['testimonial_id']] = $this->getTestimonial($result['testimonial_id']);
		}

		return $latest_testimonials;
	}
	
	public function getTotalTestimonials() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."penblog_testimonial");
		
		return $query->row['total'];
	}
	
	public function getTotalTestimonialsAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."penblog_testimonial WHERE status = '0'");
		
		return $query->row['total'];
	}	
}
