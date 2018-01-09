<?php
/******************************************************
 * @package Pen Blog
 * @author http://www.pencms.com
 * @copyright   Copyright (C) January 2015 www.pencms.com. All rights reserved.
 * @license     GNU General Public License version 2
*******************************************************/
class ControllerExtensionPenBlogPoll extends Controller
{
    private $error = array();

    public function index() {
        $this->checkVersion();

        $this->getList();
    }

    public function add()
    {
        $this->load->language('extension/penblog/poll');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('extension/penblog/poll');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_extension_penblog_poll->addPoll($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('extension/penblog/poll', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getForm();
    }

    public function edit()
    {
        $this->load->language('extension/penblog/poll');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('extension/penblog/poll');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_extension_penblog_poll->editPoll($this->request->get['poll_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('extension/penblog/poll', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getForm();
    }

    public function delete()
    {
        $this->load->language('extension/penblog/poll');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('extension/penblog/poll');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $poll_id) {
                $this->model_extension_penblog_poll->deletePoll($poll_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('extension/penblog/poll', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getList();
    }

    private function getList()
    {

        $this->load->model('extension/penblog/poll');

        $poll_lang = $this->load->language('extension/penblog/poll');
        foreach ($poll_lang as $key => $value) {
            $data[$key] = $value;
        }

        $this->document->setTitle($this->language->get('heading_title'));

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'question';
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
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/penblog/poll', 'user_token=' . $this->session->data['user_token'] . $url, true),
            'separator' => ' :: '
        );

        $data['insert'] = $this->url->link('extension/penblog/poll/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
        $data['delete'] = $this->url->link('extension/penblog/poll/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

        $data['polls'] = array();

        $filter_data = array(
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $poll_total = $this->model_extension_penblog_poll->getTotalPolls();

        $results = $this->model_extension_penblog_poll->getPolls($filter_data);

        foreach ($results as $result) {
            $action = array();

            $action[] = array(
                'text' => $this->language->get('text_edit'),
                'icon' => 'fa fa-pencil',
                'href' => $this->url->link('extension/penblog/poll/edit', 'user_token=' . $this->session->data['user_token'] . '&poll_id=' . $result['poll_id'] . $url, true)
            );

            $data['polls'][] = array(
                'poll_id' => $result['poll_id'],
                'question' => $result['question'],
                'selected' => isset($this->request->post['selected']) && in_array($result['poll_id'], $this->request->post['selected']),
                'action' => $action
            );
        }


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

        $url = '';

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['sort_question'] = $this->url->link('extension/penblog/poll', 'user_token=' . $this->session->data['user_token'] . '&sort=question' . $url, true);
        $data['sort_status']   = $this->url->link('extension/penblog/poll', 'user_token=' . $this->session->data['user_token'] . '&sort=status' . $url, true);

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination        = new Pagination();
        $pagination->total = $poll_total;
        $pagination->page  = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->text  = $this->language->get('text_pagination');
        $pagination->url   = $this->url->link('extension/penblog/poll', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();
        $data['results']    = sprintf($this->language->get('text_pagination'), ($poll_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($poll_total - $this->config->get('config_limit_admin'))) ? $poll_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $poll_total, ceil($poll_total / $this->config->get('config_limit_admin')));

        $data['sort']  = $sort;
        $data['order'] = $order;


        $data['shortcut'] = $this->load->controller('extension/penblog/shortcut');

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');
        $data['header']      = $this->load->controller('common/header');

        $this_template = 'extension/penblog/poll_list';
        $this->response->setOutput($this->load->view($this_template, $data));
    }

    private function getForm()
    {

        $poll_lang = $this->load->language('extension/penblog/poll');
        foreach ($poll_lang as $key => $value) {
            $data[$key] = $value;
        }

        $this->load->model('extension/penblog/poll');


        // Extract results
        if (isset($this->request->get['poll_id'])) {
            $poll_id                   = $this->request->get['poll_id'];
            $data['poll_data']         = $this->model_extension_penblog_poll->getPollData($poll_id);
            $data['text_poll_results'] = $this->language->get('text_poll_results');
            $data['poll_results']      = $this->url->link('module/ave_community_poll/full_result&poll_id=' . $poll_id);
            $data['action']            = $this->url->link('content/poll');
            $reactions                 = $this->model_extension_penblog_poll->getPollResults($poll_id);
            $total_votes               = $this->model_extension_penblog_poll->getTotalResults($poll_id);
            $percent                   = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0);
            $totals                    = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0);
            $vote                      = array();

            if ($reactions) {
                $data['reactions'] = TRUE;
                foreach ($reactions as $reaction) {
                    $totals[$reaction['answer']]++;
                }

                for ($i = 1; $i <= 10; $i++) {
                    $percent[$i] = round(100 * ($totals[$i] / $total_votes));
                    $vote[$i]    = $totals[$i];
                }
            }
            $data['percent']     = $percent;
            $data['vote']        = $vote;
            $data['total_votes'] = $total_votes;
        }
        // End extraction of results

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        if (isset($this->error['question'])) {
            $data['error_question'] = $this->error['question'];
        } else {
            $data['error_question'] = '';
        }

        if (isset($this->error['banner_image'])) {
            $data['error_banner_image'] = $this->error['banner_image'];
        } else {
            $data['error_banner_image'] = array();
        }

        for ($i = 1; $i <= 2; $i++) { //at least 2 possible answers
            if (isset($this->error['answer'][$i])) {
                $data['errors_answer'][$i] = $this->error['answer'][$i];
            } else {
                $data['errors_answer'][$i] = array();
            }
        }

        $data['breadcrumbs']   = array();
        $data['breadcrumbs'][] = array(
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true),
            'text' => $this->language->get('text_home'),
            'separator' => FALSE
        );
        $data['breadcrumbs'][] = array(
            'href' => $this->url->link('extension/penblog/poll', 'user_token=' . $this->session->data['user_token'], true),
            'text' => $this->language->get('heading_title'),
            'separator' => ' :: '
        );
        if (!isset($this->request->get['poll_id'])) {
            $data['new_poll'] = TRUE;
            $data['action']   = $this->url->link('extension/penblog/poll/add', 'user_token=' . $this->session->data['user_token'], true);
        } else {
            $data['action'] = $this->url->link('extension/penblog/poll/edit', 'user_token=' . $this->session->data['user_token'] . '&poll_id=' . $this->request->get['poll_id'], true);
        }
        $data['cancel']       = $this->url->link('extension/penblog/poll', 'user_token=' . $this->session->data['user_token'], true);
        $data['poll_setting'] = $this->url->link('module/ave_community_poll', 'user_token=' . $this->session->data['user_token'], true);


        if ((isset($this->request->get['poll_id'])) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $poll_info = $this->model_extension_penblog_poll->getPoll($this->request->get['poll_id']);
        }
        $this->load->model('localisation/language');
        $langs             = $this->model_localisation_language->getLanguages();
        $data['languages'] = array();
        foreach ($langs as $language) {
            if ((int) substr((string) str_replace('.', '', VERSION), 0, 3) > 210) {
                $image = 'language/' . $language['code'] . '/' . $language['code'] . '.png';
            } else {
                $image = '../image/flags/' . $language['image'];
            }
            $data['languages'][] = array(
                'language_id' => $language['language_id'],
                'name' => $language['name'],
                'code' => $language['code'],
                'image' => $image,
                'status' => $language['status']
            );
        }


        if (isset($this->request->post['color'])) {
            $data['color'] = $this->request->post['color'];
        } elseif (!empty($download_info)) {
            $data['color'] = $download_info['color'];
        } else {
            $data['color'] = 'blue-sky';
        }
        $data['setcolors'] = array();

        if (isset($this->request->post['poll_description'])) {
            $data['poll_description'] = $this->request->post['poll_description'];
        } elseif (isset($poll_info)) {
            $data['poll_description'] = $this->model_extension_penblog_poll->getPollDescriptions($this->request->get['poll_id']);
        } else {
            $data['poll_description'] = array();
        }

        $this->load->model('setting/store');
        $data['stores'] = $this->model_setting_store->getStores();
        if (isset($this->request->post['poll_store'])) {
            $data['poll_store'] = $this->request->post['poll_store'];
        } elseif (isset($poll_info)) {
            $data['poll_store'] = $this->model_extension_penblog_poll->getPollStores($this->request->get['poll_id']);
        } else {
            $data['poll_store'] = array(
                0
            );
        }

        $data['shortcut'] = $this->load->controller('extension/penblog/shortcut');
        $data['column_left']    = $this->load->controller('common/column_left');
        $data['footer']         = $this->load->controller('common/footer');
        $data['header']         = $this->load->controller('common/header');

        $this_template = 'extension/penblog/poll_form';
        $this->response->setOutput($this->load->view($this_template, $data));
    }

    private function validateForm()
    {

        if (!$this->user->hasPermission('modify', 'extension/penblog/poll')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }


        foreach ($this->request->post['poll_description'] as $language_id => $value) {
            if ((utf8_strlen($value['question']) < 1) || (utf8_strlen($value['question']) > 255)) {
                $this->error['question'][$language_id] = $this->language->get('error_question');
            }

            for ($i = 1; $i <= 2; $i++) {
                if (((utf8_strlen(utf8_decode($value['answer_' . $i])) < 2) || (utf8_strlen(utf8_decode($value['answer_' . $i])) > 128))) {
                    $this->error['answer'][$i][$language_id] = $this->language->get('error_answer');
                }
            }
        }



        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    private function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'extension/penblog/poll')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    public function autocomplete() {
        $json = array();

        if (isset($this->request->get['filter_name'])) {
            $this->load->model('extension/penblog/poll');

            $filter_data = array(
                'filter_name' => $this->request->get['filter_name'],
                'start'       => 0,
                'limit'       => 5
            );

            $results = $this->model_extension_penblog_poll->getPolls($filter_data);

            foreach ($results as $result) {
                $json[] = array(
                    'poll_id' => $result['poll_id'],
                    'question'        => strip_tags(html_entity_decode($result['question'], ENT_QUOTES, 'UTF-8'))
                );
            }
        }

        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['question'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function checkVersion(){
        if($this->config->get('penblog_version')){
            return true;
        } else {
            $this->response->redirect($this->url->link('extension/penblog/about', 'user_token=' . $this->session->data['user_token'], true));
        }
    }
}
?>