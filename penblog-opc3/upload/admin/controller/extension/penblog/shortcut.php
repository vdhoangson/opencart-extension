<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright	Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class ControllerExtensionPenBlogShortcut extends Controller
{
    public function index()
    {

        $data['shortcuts'] = $this->getShortcuts();

        $find[0] = '/\/add/';
        $find[1] = '/\/edit/';
        $replace[0] = $replace[1] = '';
        $route = '';
        if (isset($this->request->get['route'])) {
            $route = $this->request->get['route'];
        }

        $data['route'] = preg_replace($find, $replace, $route);

        return $this->load->view('extension/penblog/shortcut', $data);
    }

    private function getShortcuts()
    {
        $this->language->load('extension/penblog/shortcut');
        $results = array('dashboard', 'category', 'article', 'comment', 'download', 'setting');
        $shortcuts = array();

        $shortcuts[] = array(
            'text' => $this->language->get('text_dashboard'),
            'href' => $this->url->link('extension/penblog/dashboard', 'user_token=' . $this->session->data['user_token'], true),
            'route' => 'extension/penblog/dashboard',
            'icon' => 'fa fa-tachometer',
            'childs' => array()
        );
        $shortcuts[] = array(
            'text' => $this->language->get('text_category'),
            'href' => $this->url->link('extension/penblog/category', 'user_token=' . $this->session->data['user_token'], true),
            'route' => 'extension/penblog/category',
            'icon' => 'fa fa-folder-open-o',
            'childs' => array()
        );
        $shortcuts[] = array(
            'text' => $this->language->get('text_article'),
            'href' => $this->url->link('extension/penblog/article', 'user_token=' . $this->session->data['user_token'], true),
            'route' => 'extension/penblog/article',
            'icon' => 'fa fa-newspaper-o',
            'childs' => array()
        );
        $shortcuts[] = array(
            'text' => $this->language->get('text_comment'),
            'href' => $this->url->link('extension/penblog/comment', 'user_token=' . $this->session->data['user_token'], true),
            'route' => 'extension/penblog/comment',
            'icon' => 'fa fa-comments',
            'childs' => array()
        );
        $shortcuts[] = array(
            'text' => $this->language->get('text_poll'),
            'href' => $this->url->link('extension/penblog/poll', 'user_token=' . $this->session->data['user_token'], true),
            'route' => 'extension/penblog/poll',
            'icon' => 'fa fa-bar-chart',
            'childs' => array()
        );
        $shortcuts[] = array(
            'text' => $this->language->get('text_testimonial'),
            'href' => $this->url->link('extension/penblog/testimonial', 'user_token=' . $this->session->data['user_token'], true),
            'route' => 'extension/penblog/testimonial',
            'icon' => 'fa fa-comment-o',
            'childs' => array()
        );
        $shortcuts[] = array(
            'text' => $this->language->get('text_download'),
            'href' => $this->url->link('extension/penblog/download', 'user_token=' . $this->session->data['user_token'], true),
            'route' => 'extension/penblog/download',
            'icon' => 'fa fa-download',
            'childs' => array()
        );

        $shortcuts[] = array(
            'text' => $this->language->get('text_penblog_block'),
            'href' => $this->url->link('extension/module/penblog_block', 'user_token=' . $this->session->data['user_token'], true),
            'route' => 'extension/module/penblog_block',
            'icon' => 'fa fa-th-large',
            'childs' => array()
        );

        // setting
        $setting = array();
        $setting[] = array(
            'text' => $this->language->get('text_setting'),
            'href' => $this->url->link('extension/penblog/setting', 'user_token=' . $this->session->data['user_token'], true),
            'route' => 'extension/penblog/setting',
            'icon' => 'fa fa-cog'
        );

        $setting[] = array(
            'text' => $this->language->get('text_about'),
            'href' => $this->url->link('extension/penblog/about', 'user_token=' . $this->session->data['user_token'], true),
            'route' => 'extension/penblog/about',
            'icon' => 'fa fa-info-circle'
        );

        $shortcuts[] = array(
            'text' => $this->language->get('text_setting'),
            'href' => $this->url->link('extension/penblog/setting', 'user_token=' . $this->session->data['user_token'], true),
            'route' => 'extension/penblog/setting',
            'icon' => 'fa fa-cog',
            'childs' => $setting
        );

        return $shortcuts;
    }
}
