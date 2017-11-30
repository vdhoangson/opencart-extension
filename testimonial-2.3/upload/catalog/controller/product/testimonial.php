<?php
class ControllerProductTestimonial extends Controller {

	public function index() {
    	$languages = $this->language->load('product/testimonial');

    	foreach($languages as $key => $value){
    		$data[$key] = $value;
    	}

		$this->load->model('catalog/testimonial');

		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			    'href'      => $this->url->link('common/home', '', 'SSL'),
      		'separator' => false
   		);


		$testimonial_total = $this->model_catalog_testimonial->getTotalTestimonials();

		if ($testimonial_total > 0) {

	  		$this->document->setTitle($this->language->get('heading_title'));

	   		$data['breadcrumbs'][] = array(
	       		'text'      => $this->language->get('heading_title'),
				    'href'      => $this->url->link('product/testimonial', '', 'SSL'),
	   		);

			$data['continue'] = $this->url->link('common/home', '', 'SSL');

			$page_limit = $this->config->get($this->config->get('config_theme') . '_product_limit');

			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else {
				$page = 1;
			}

			$data['testimonials'] = array();

			if (isset($this->request->get['testimonial_id']) ){
				$results = $this->model_catalog_testimonial->getTestimonial($this->request->get['testimonial_id']);
			}
			else{
				$results = $this->model_catalog_testimonial->getTestimonials(($page - 1) * $page_limit, $page_limit);
			}

			foreach ($results as $result) {
				$data['testimonials'][] = array(
					'name'		=> $result['name'],
					'title'    		=> html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8'),
					'rating'		=> $result['rating'],
					'description'	=> html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
					'reply'	=> html_entity_decode($result['reply'], ENT_QUOTES, 'UTF-8'),
					'city'		=> $result['city'],
					'date_added'	=> date("H:i:s m-d-Y", strtotime($result['date_added']))
				);
			}
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

				$data['write_url'] = $this->url->link('product/posttestimonial', '', 'SSL');

			if ( isset($this->request->get['testimonial_id']) ){
				$data['showall_url'] = $this->url->link('product/testimonial', '', 'SSL');
			}
			else{
				$pagination = new Pagination();
				$pagination->total = $testimonial_total;
				$pagination->page = $page;
				$pagination->limit = $page_limit;
				$pagination->url = $this->url->link('product/testimonial','&page={page}');

				$data['pagination'] = $pagination->render();

			}

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

         $this->response->setOutput($this->load->view('/product/testimonial', $data));

    	} else {


      $this->document->setTitle ( $this->language->get('text_error'));
      $data['heading_title'] = $this->language->get('text_error');
      $data['text_error'] = $this->language->get('text_error');
      $data['button_continue'] = $this->language->get('button_continue');
      $data['continue'] = $this->url->link('common/home', '', 'SSL');


			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

         $this->response->setOutput($this->load->view('error/not_found', $data));
    	}

  	}
}