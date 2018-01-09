<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ModelExtensionPenBlogSetup extends Model
{

    private $version = '1.0';

    public function install()
    {
        $queries = array();

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "penblog_article` (
					  `article_id` int(11) NOT NULL AUTO_INCREMENT,
					  `author_id` int(11) NOT NULL,
					  `date_added` datetime NOT NULL ,
					  `date_modified` datetime NOT NULL ,
					  `date_public` datetime NOT NULL ,
					  `image` varchar(225) NOT NULL,
					  `main_image` varchar(225) NOT NULL,
					  `sort_order` int(3) NOT NULL DEFAULT '0',
					  `status` tinyint(1) NOT NULL DEFAULT '1',
					  `viewed` int(11) NOT NULL DEFAULT '0',
					  `login_to_view` int(11) NOT NULL DEFAULT '0',
					  `allow_comment` int(11) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`article_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "penblog_article_description` (
					  `article_id` int(11) NOT NULL,
					  `language_id` int(11) NOT NULL,
					  `name` varchar(64) NOT NULL,
					  `description` text NOT NULL,
					  `short_description` text NOT NULL,
					  `meta_description` varchar(255) NOT NULL,
					  `meta_keyword` varchar(255) NOT NULL,
					  `tag` varchar(255) NOT NULL,
					  PRIMARY KEY (`article_id`,`language_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "penblog_article_image` (
					  `image_id` int(11) NOT NULL AUTO_INCREMENT,
					  `article_id` int(11) NOT NULL,
					  `image` varchar(255) DEFAULT NULL,
					  `sort_order` int(3) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`image_id`),
					  KEY `article_id` (`article_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "penblog_article_to_category` (
					  `article_id` int(11) NOT NULL DEFAULT '0',
					  `category_id` int(11) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`article_id`,`category_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "penblog_article_to_layout` (
					  `article_id` int(11) NOT NULL,
					  `store_id` int(11) NOT NULL,
					  `layout_id` int(11) NOT NULL,
					  PRIMARY KEY (`article_id`,`store_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "penblog_article_to_related` (
					  `article_id` int(11) NOT NULL,
					  `related_id` int(11) NOT NULL,
					  PRIMARY KEY (`article_id`,`related_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "penblog_article_to_download` (
					  `article_id` int(11) NOT NULL,
					  `download_id` int(11) NOT NULL,
					  PRIMARY KEY (`article_id`,`download_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "penblog_article_to_product` (
					  `article_id` int(11) NOT NULL,
					  `product_id` int(11) NOT NULL,
					  PRIMARY KEY (`article_id`,`product_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "penblog_article_to_store` (
					  `article_id` int(11) NOT NULL,
					  `store_id` int(11) NOT NULL,
					  PRIMARY KEY (`article_id`,`store_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "penblog_category` (
					  `category_id` int(11) NOT NULL AUTO_INCREMENT,
					  `image` varchar(255) DEFAULT NULL,
					  `parent_id` int(11) NOT NULL DEFAULT '0',
					  `top` tinyint(1) NOT NULL,
					  `column` int(3) NOT NULL,
					  `sort_order` int(3) NOT NULL DEFAULT '0',
					  `status` tinyint(1) NOT NULL,
					  `date_added` datetime NOT NULL ,
					  `date_modified` datetime NOT NULL ,
					  PRIMARY KEY (`category_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "penblog_category_description` (
					  `category_id` int(11) NOT NULL,
					  `language_id` int(11) NOT NULL,
					  `name` varchar(255) NOT NULL,
					  `description` text NOT NULL,
					  `meta_title` varchar(255) NOT NULL,
					  `meta_keyword` varchar(255) NOT NULL,
					  `meta_description` varchar(255) NOT NULL,
					  PRIMARY KEY (`category_id`,`language_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "penblog_category_path` (
					  `category_id` int(11) NOT NULL,
					  `path_id` int(11) NOT NULL,
					  `level` int(11) NOT NULL,
					  PRIMARY KEY (`category_id`,`path_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "penblog_category_to_layout` (
					  `category_id` int(11) NOT NULL,
					  `store_id` int(11) NOT NULL,
					  `layout_id` int(11) NOT NULL,
					  PRIMARY KEY (`category_id`,`store_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "penblog_category_to_store` (
					  `category_id` int(11) NOT NULL,
					  `store_id` int(11) NOT NULL,
					  PRIMARY KEY (`category_id`,`store_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "penblog_comment` (
					  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
					  `article_id` int(11) NOT NULL,
					  `customer_id` int(11) NOT NULL,
					  `parent` int(11) NOT NULL,
					  `author` varchar(64) NOT NULL,
					  `email` varchar(64) NOT NULL,
					  `text` text NOT NULL,
					  `rating` int(1) NOT NULL,
					  `status` tinyint(1) NOT NULL DEFAULT '0',
					  `date_added` datetime NOT NULL ,
					  PRIMARY KEY (`comment_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "penblog_download` (
					  `download_id` int(11) NOT NULL AUTO_INCREMENT,
					  `filename` varchar(128) NOT NULL,
					  `mask` varchar(128) NOT NULL,
					  `login_to_download` tinyint(1) NOT NULL DEFAULT '0',
					  `date_added` datetime NOT NULL,
					  PRIMARY KEY (`download_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "penblog_download_description` (
					  `download_id` int(11) NOT NULL,
					  `language_id` int(11) NOT NULL,
					  `name` varchar(64) NOT NULL,
					  PRIMARY KEY (`download_id`,`language_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "penblog_poll` (
					  `poll_id` int(11) NOT NULL AUTO_INCREMENT,
					  `color` varchar(64) DEFAULT 'blue-sky',
					  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					  PRIMARY KEY (`poll_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "penblog_poll_description` (
					  `poll_id` int(11) NOT NULL,
					  `language_id` int(11) NOT NULL,
					  `question` varchar(255) NOT NULL,
					  `answer_1` varchar(255) NOT NULL,
					  `answer_2` varchar(255) NOT NULL,
					  `answer_3` varchar(255) NOT NULL,
					  `answer_4` varchar(255) NOT NULL,
					  `answer_5` varchar(255) NOT NULL,
					  `answer_6` varchar(255) NOT NULL,
					  `answer_7` varchar(255) NOT NULL,
					  `answer_8` varchar(255) NOT NULL,
					  `answer_9` varchar(255) NOT NULL,
					  `answer_10` varchar(255) NOT NULL,
					  `answer_11` varchar(255) NOT NULL,
					  `answer_12` varchar(255) NOT NULL,
					  `answer_13` varchar(255) NOT NULL,
					  `answer_14` varchar(255) NOT NULL,
					  `answer_15` varchar(255) NOT NULL,
					  PRIMARY KEY (`poll_id`,`language_id`),
					  KEY `question` (`question`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "penblog_poll_reactions` (
					  `poll_reaction_id` int(11) NOT NULL AUTO_INCREMENT,
					  `poll_id` int(11) NOT NULL,
					  `answer` int(11) NOT NULL,
					  PRIMARY KEY (`poll_reaction_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "penblog_poll_to_article` (
					  `article_id` int(11) NOT NULL,
					  `poll_id` int(11) NOT NULL,
					  PRIMARY KEY (`article_id`,`poll_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "penblog_poll_to_store` (
					  `poll_id` int(11) NOT NULL,
					  `store_id` int(11) NOT NULL,
					  PRIMARY KEY (`poll_id`,`store_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "penblog_testimonial` (
                        `testimonial_id` int(11) NOT NULL AUTO_INCREMENT,
                        `customer_id` int(11) NOT NULL,
                        `avatar` varchar(255) NOT NULL,
                        `customer_name` varchar(64) NOT NULL DEFAULT '',
                        `customer_telephone` varchar(64) NOT NULL,
                        `customer_email` varchar(128) NOT NULL,
                        `customer_company` varchar(128) NOT NULL,
                        `competence` varchar(64) NOT NULL,
                        `service_selection` varchar(128) NOT NULL,
                        `message` varchar(3000) NOT NULL,
                        `rating` int(1) NOT NULL,
                        `status` tinyint(1) NOT NULL DEFAULT '0',
                        `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                        `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                        `read` int(1) NOT NULL DEFAULT '0',
                        PRIMARY KEY (`testimonial_id`)
                      ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

        foreach ($queries as $query) {
            $this->db->query($query);
        }

        //permission
        $this->setPermission();

        $setting_default = $this->getSettingDefault();

        $this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET store_id = '0', `code` = 'penblog', `key` = 'penblog_setting', `value` = '" . $this->db->escape(json_encode($setting_default)) . "', `serialized` = '1'");
        $this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET store_id = '0', `code` = 'penblog', `key` = 'penblog_installed', `value` = '1', `serialized` = '1'");
        $this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET store_id = '0', `code` = 'penblog', `key` = 'penblog_version', `value` = '" . $this->version . "', `serialized` = '1'");
    }

    public function uninstall() {
        $queries[] = array();
        /*$queries[] = "DROP TABLE IF EXISTS `" . DB_PREFIX . "penblog_article`;";
		$queries[] = "DROP TABLE IF EXISTS `" . DB_PREFIX . "penblog_article_description`;";
		$queries[] = "DROP TABLE IF EXISTS `" . DB_PREFIX . "penblog_article_image`;";
		$queries[] = "DROP TABLE IF EXISTS `" . DB_PREFIX . "penblog_article_to_category`;";
		$queries[] = "DROP TABLE IF EXISTS `" . DB_PREFIX . "penblog_article_to_layout`;";
		$queries[] = "DROP TABLE IF EXISTS `" . DB_PREFIX . "penblog_article_to_related`;";
		$queries[] = "DROP TABLE IF EXISTS `" . DB_PREFIX . "penblog_article_to_download`;";
		$queries[] = "DROP TABLE IF EXISTS `" . DB_PREFIX . "penblog_article_to_product`;";
		$queries[] = "DROP TABLE IF EXISTS `" . DB_PREFIX . "penblog_article_to_store`;";
		$queries[] = "DROP TABLE IF EXISTS `" . DB_PREFIX . "penblog_category`;";
		$queries[] = "DROP TABLE IF EXISTS `" . DB_PREFIX . "penblog_category_description`;";
		$queries[] = "DROP TABLE IF EXISTS `" . DB_PREFIX . "penblog_category_path`;";
		$queries[] = "DROP TABLE IF EXISTS `" . DB_PREFIX . "penblog_category_to_layout`;";
		$queries[] = "DROP TABLE IF EXISTS `" . DB_PREFIX . "penblog_category_to_store`;";
		$queries[] = "DROP TABLE IF EXISTS `" . DB_PREFIX . "penblog_comment`;";
		$queries[] = "DROP TABLE IF EXISTS `" . DB_PREFIX . "penblog_download`;";
		$queries[] = "DROP TABLE IF EXISTS `" . DB_PREFIX . "penblog_download_description`;";*/
        $queries[] = "DELETE FROM `" . DB_PREFIX . "setting` WHERE `code`='penblog'";
        
        foreach ($queries as $query) {
            $this->db->query($query);
        }
    }

    public function getController() {
        $controller = array(
            'article',
            'category',
            'comment',
            'dashboard',
            'download',
            'setting',
            'shortcut',
            'poll',
            'testimonial',
            'about'
        );
        return $controller;
    }

    public function getSettingDefault() {
        return array(
            //Category
            'catalog_limit'                => 10,
            'catalog_show_filter'          => 1,
            'catalog_show_author'          => 1,
            'catalog_show_viewed'          => 1,
            'catalog_show_date_added'      => 1,
            'catalog_show_date_modified'   => 1,
            'catalog_image_width'          => 180,
            'catalog_image_height'         => 180,
            'catalog_image_article_width'  => 350,
            'catalog_image_article_height' => 250,
            //Article
            'article_show_author'          => 1,
            'article_show_viewed'          => 1,
            'article_show_date_added'      => 1,
            'article_show_date_modified'   => 1,
            'article_show_share_btn'       => 1,
            'article_thumb_width'          => 740,
            'article_thumb_height'         => 420,
            'article_popup_width'          => 500,
            'article_popup_height'         => 500,
            'article_additional_width'     => 80,
            'article_additional_height'    => 80,
            'article_related_width' => 250,
            'article_related_height' => 250,
            'article_product_width' => 180,
            'article_product_height' => 180,
            'article_related_display' => 'grid',
            'article_product_display' => 'grid',
            //Video
            'youtube_show_control' => 1,
            'youtube_allow_fullsreen' => 1,
            'youtube_related_video' => 1,
            'youtube_autohide' => 1,
            'youtube_template' => 'dark',
            'youtube_quanlity' => 'vq=hd1080',
            //Global
            'admin_limit' => 10,
            'comment_status' => 1,
            'date_format' => 'd-m-Y'
        );
    }

    public function getVersion() {
        return $this->version;
	}
	
	private function setPermission(){
		// update permission
        foreach ($this->getController() as $code) {
            $this->load->model('user/user_group');
            if (!$this->user->hasPermission('modify', 'extension/penblog/'. $code)) {
                $this->model_user_user_group->addPermission($this->user->getId(), 'access', 'extension/penblog/'. $code);
                $this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'extension/penblog/'. $code);
            }
		}
	}

    public function update() {

        $this->setPermission();
		
        $this->model_user_user_group->addPermission($this->user->getId(), 'access', 'extension/module/penblog_block');
        $this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'extension/module/penblog_block');

        $this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `key` = 'penblog_version'");

        $this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET store_id = '0', `code` = 'penblog', `key` = 'penblog_version', `value` = '" . $this->version . "', `serialized` = '0'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `key` = 'penblog_installed'");

        $this->db->query("INSERT INTO `" . DB_PREFIX . "setting` SET store_id = '0', `code` = 'penblog', `key` = 'penblog_installed', `value` = '1', `serialized` = '0'");
    }
}
