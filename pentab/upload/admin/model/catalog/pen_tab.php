<?php
class ModelCatalogPenTab extends Model {
	public function addTab($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "pen_tab SET position = '" . (int)$data['position'] . "', compare = '" . (int)$data['compare'] . "', type = 'tb', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "'");

		$tab_id = $this->db->getLastId();

		foreach ($data['tab_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "pen_tab_description SET tab_id = '" . (int)$tab_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', content = '" . $this->db->escape($value['content']) . "'");
		}

		if (isset($data['product']) && !empty($data['product'])) {
			foreach ($data['product'] as $product_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "pen_tab_to_product SET tab_id = '" . (int)$tab_id . "', product_id = '" . (int)$product_id . "'");
			}
		}

		if (isset($data['category']) && !empty($data['category'])) {
			foreach ($data['category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "pen_tab_to_category SET tab_id = '" . (int)$tab_id . "', category_id = '" . (int)$category_id . "'");
			}
		}
	}

	public function editTab($tab_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "pen_tab SET position = '" . (int)$data['position'] . "', compare = '" . (int)$data['compare'] . "', type = 'tb', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "' WHERE tab_id = '" . (int)$tab_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "pen_tab_description WHERE tab_id = '" . (int)$tab_id . "'");

		foreach ($data['tab_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "pen_tab_description SET tab_id = '" . (int)$tab_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', content = '" . $this->db->escape($value['content']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "pen_tab_to_product WHERE tab_id = '" . (int)$tab_id . "'");

		if (isset($data['product']) && !empty($data['product'])) {
			foreach ($data['product'] as $product_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "pen_tab_to_product SET tab_id = '" . (int)$tab_id . "', product_id = '" . (int)$product_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "pen_tab_to_category WHERE tab_id = '" . (int)$tab_id . "'");

		if (isset($data['product']) && !empty($data['product'])) {
			foreach ($data['category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "pen_tab_to_category SET tab_id = '" . (int)$tab_id . "', category_id = '" . (int)$category_id . "'");
			}
		}
	}

	public function deleteTab($tab_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "pen_tab WHERE tab_id = '" . (int)$tab_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "pen_tab_description WHERE tab_id = '" . (int)$tab_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "pen_tab_to_product WHERE tab_id = '" . (int)$tab_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "pen_tab_to_category WHERE tab_id = '" . (int)$tab_id . "'");
	}

	public function getTab($tab_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pen_tab t LEFT JOIN " . DB_PREFIX . "pen_tab_description td ON (t.tab_id = td.tab_id) LEFT JOIN " . DB_PREFIX . "pen_tab_to_product t2p ON (t.tab_id = t2p.tab_id) WHERE t.tab_id = '" . (int)$tab_id . "' AND td.language_id = '" . $this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getTabs() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pen_tab t LEFT JOIN " . DB_PREFIX . "pen_tab_description td ON (t.tab_id = td.tab_id) WHERE t.type = 'tb' AND td.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY t.tab_id ASC");

		return $query->rows;
	}

	public function getTabDescriptions($tab_id) {
		$tab_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pen_tab_description WHERE tab_id = '" . (int)$tab_id . "'");

		foreach ($query->rows as $result) {
			$tab_description_data[$result['language_id']] = array(
				'title'        => $result['title'],
				'content'      => $result['content']
			);
		}

		return $tab_description_data;
	}

    public function getTabProducts($tab_id) {
        $product_id = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pen_tab_to_product WHERE tab_id = '" . (int)$tab_id . "'");

        foreach ($query->rows as $result) {
            $product_id[] = $result['product_id'];
        }

        return $product_id;
    }

	public function getTotalTabs() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "pen_tab");

		return $query->row['total'];
	}

	public function getTabCategories($tab_id){
		$category_id = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pen_tab_to_category WHERE tab_id = '" . (int)$tab_id . "'");

		foreach ($query->rows as $result) {
			$category_id[] = $result['category_id'];
		}

		return $category_id;
	}

	public function installDb(){
		// New Installation
        $query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "product_additional_tab'");
        $query2 = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "pen_tab'");

        if ((!$query->num_rows) && (!$query2->num_rows)) {
            $this->db->query("CREATE TABLE IF NOT EXISTS`" . DB_PREFIX . "pen_tab` (`tab_id` int(11) NOT NULL AUTO_INCREMENT, `position` tinyint(1) NOT NULL DEFAULT '2', `compare` tinyint(1) NOT NULL DEFAULT '0', `type` varchar(2) COLLATE utf8_bin NOT NULL, `sort_order` int(3) NOT NULL DEFAULT '0', `status` tinyint(1) NOT NULL, PRIMARY KEY (`tab_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;");
        }

        $query_desc = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "product_additional_tab_description'");
        $query_desc2 = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "pen_tab_description'");

        if ((!$query_desc->num_rows) && (!$query_desc2->num_rows)) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "pen_tab_description` (`tab_id` int(11) NOT NULL, `language_id` int(11) NOT NULL, `title` varchar(64) COLLATE utf8_bin NOT NULL, `content` text COLLATE utf8_bin NOT NULL, PRIMARY KEY (`tab_id`,`language_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;");
        }

        $query_product = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "pen_tab_to_product'");

        if (!$query_product->num_rows) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "pen_tab_to_product` (`tab_id` int(11) NOT NULL, `product_id` int(11) NOT NULL, PRIMARY KEY (`tab_id`, `product_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;");
		}

		$query_product = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "pen_tab_to_category'");

		if (!$query_product->num_rows) {
			$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "pen_tab_to_category` (`tab_id` int(11) NOT NULL, `category_id` int(11) NOT NULL, PRIMARY KEY (`tab_id`, `category_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;");
		}
	}
}
?>