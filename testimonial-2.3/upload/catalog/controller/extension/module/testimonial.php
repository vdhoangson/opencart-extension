<?php
class ControllerExtensionModuleTestimonial extends Controller {

	public function index() {
		static $module = 0;
		$this->language->load('extension/module/testimonial');

		$testimonial_character_limit = $this->config->get('testimonial_character_limit');
		$testimonial_name = $this->config->get('testimonial_name');
		$testimonial_random = $this->config->get('testimonial_random');
		$testimonial_limit = $this->config->get('testimonial_limit');

		$data['testimonial_title'] = html_entity_decode($testimonial_name, ENT_QUOTES, 'UTF-8');

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_more'] = $this->language->get('text_more');
		$data['text_more2'] = $this->language->get('text_more2');
		$data['isi_testimonial'] = $this->language->get('isi_testimonial');
		$data['show_all'] = $this->language->get('show_all');
		$data['showall_url'] = $this->url->link('product/testimonial', '', true);
		$data['more'] = $this->url->link('product/testimonial', 'testimonial_id=' , true);
		$data['isitesti'] = $this->url->link('product/posttestimonial', '', true);

		$this->load->model('catalog/testimonial');

		$data['testimonials'] = array();

		$data['total'] = $this->model_catalog_testimonial->getTotalTestimonials();
		$results = $this->model_catalog_testimonial->getTestimonials(0, $testimonial_limit, ($testimonial_random)&&($testimonial_random==1)?true:false);

		foreach ($results as $result) {
			$result['description'] = '« '.trim($result['description']).' »';
			$result['description'] = str_replace('«<p>', '« ', $result['description']);
			$result['description'] = str_replace('</p>»', ' »', $result['description']);


			if (!$testimonial_character_limit){
				$testimonial_character_limit = 0;
			}
			if ($testimonial_character_limit>0) {
				$lim = $testimonial_character_limit;

				if (mb_strlen($result['description'],'UTF-8')>$lim)
					$result['description'] = mb_substr($result['description'], 0, $lim-3, 'UTF-8'). ' ' .'<a href="'.$data['more']. $result['testimonial_id'] .'" title="'.$data['text_more2'].'">'. $data['text_more'] . '</a>';

			}

			if (mb_strlen($result['title'],'UTF-8')>20)
				$result['title'] = mb_substr($result['title'], 0, 17, 'UTF-8').'...';

			if (mb_strlen($result['name'],'UTF-8')>10)
				$result['name'] = mb_substr($result['name'], 0, 7, 'UTF-8').'...';

			if (mb_strlen($result['city'],'UTF-8')>10)
				$result['city'] = mb_substr($result['city'], 0, 7, 'UTF-8').'...';

			$data['testimonials'][] = array(
				'testimonial_id' => $result['testimonial_id'],
				'title' => $result['title'],
				'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $testimonial_character_limit) . '..',
				'rating' => (int)$result['rating'],
				'city' => $result['city'],
				'name' => $result['name'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),

			);
		}

		 $data['module'] = $module++;

      return $this->load->view('extension/module/testimonial', $data);

	}
}