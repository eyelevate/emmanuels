<?php

class Page extends \Eloquent {
	protected $fillable = [];

	use SoftDeletingTrait;

	public static $pages_add = array(
		'title'=>'required|min:1',
		'description'=>'required|min:1',
		'url'=>'required|min:1',
		'keywords'=>'required|min:1'
		);
	public static $pages_edit = array(
		'name'=>'required|min:1'
		);

	public static function preparePages($data) {
		if(isset($data)) {
			foreach ($data as $key => $value) {
				$data[$key]['company_name'] = Company::where('id',1)->pluck('name');
			}
		}
		return $data;
	}
	public static function prepareContentArea($count) {

		$html = '';
		$html .= '<div class="panel panel-success content-set" style="margin-top:10px;">';
		$html .= '<div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse"';
		$html .= 'data-parent="#accordion" href="#accordion-'.$count.'" aria-expanded="true" aria-controls="collapseOne"';
		$html .= 'style="cursor: pointer;">';
		$html .= '<h4 class="panel-title">';
		$html .= '<a class="this-title">';
		$html .= 'Section '.($count+1);
		$html .= '</a>';
		$html .= '<a>';
		$html .= '<i class="glyphicon glyphicon-chevron-down pull-right"></i>';
		$html .= '</a>';
		$html .= '</h4>';
		$html .= '</div>';
		$html .= '<div id="accordion-'.$count.'" this_set="'.$count.'" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">';
		$html .= '<div class="panel-body">';
		$html .= '<div class="form-group">';
		$html .= '<label class="control-label" for="title">Title</label>';
		$html .= '<input type="text" name="content['.$count.'][content_title]" class="form-control content-title" placeholder="Content Title">';
		$html .= '</div>';
		$html .= '<div class="form-group">';
		$html .= '<label class="control-label" for="content">Content</label>';
		$html .= '<textarea name="content['.$count.'][content_body]" style="resize:none;" class="form-control content-body" placeholder="Content Title"></textarea>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';


		$html .= '<div class="panel-footer clearfix">';
		$html .= '<button type="button" class="remove-collapse btn btn-danger pull-right"><i class="glyphicon glyphicon-remove"></i> Remove</button>';
		$html .= '</div>';

		$html .= '</div>';


		return $html;
	}

	public static function prepareForPreview($content) {
		// Job::dump($content);
		$html = '';
		if (isset($content)) {
			foreach ($content as $ckey => $cvalue) {
				$html .= '<h3>'.$cvalue['content_title'].'</h3>';
				$html .= '<p>'.$cvalue['content_body'].'</p>';
			}
		}
		return $html;
	}

	public static function prepareAddFormSession($form) {
		// Job::dump($content);
		$data_array = [];
		if (isset($form)) {
			$data_array['title'] = $form['title'];
			$data_array['description'] = $form['description'];
			$data_array['url'] = $form['url'];
			$data_array['keywords'] = $form['keywords'];
			$data_array['html'] = '';
			$i = 0;
			if (isset($form['content'])) {
				foreach ($form['content'] as $ckey => $cvalue) {

					$data_array['html'][$i] = '';
					$data_array['html'][$i] .= '<div class="panel panel-default content-set" style="margin-top:10px;">';
					$data_array['html'][$i] .= '<div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse"';
					$data_array['html'][$i] .= 'data-parent="#accordion" href="#accordion-'.$i.'" aria-expanded="true" aria-controls="collapseOne"';
					$data_array['html'][$i] .= 'style="cursor: pointer;">';
					$data_array['html'][$i] .= '<h4 class="panel-title">';
					$data_array['html'][$i] .= '<a class="this-title">';
					$data_array['html'][$i] .= 'Section '.($i+1);
					$data_array['html'][$i] .= '</a>';
					$data_array['html'][$i] .= '<a>';
					$data_array['html'][$i] .= '<i class="glyphicon glyphicon-remove pull-right"></i><i class="glyphicon glyphicon-chevron-down pull-right">&nbsp;&nbsp;</i>';
					$data_array['html'][$i] .= '</a>';
					$data_array['html'][$i] .= '</h4>';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '<div id="accordion-'.$i.'" this_set="'.$i.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">';
					$data_array['html'][$i] .= '<div class="panel-body">';
					$data_array['html'][$i] .= '<div class="form-group">';
					$data_array['html'][$i] .= '<label class="control-label" for="title">Title</label>';
					$data_array['html'][$i] .= '<input type="text" name="content['.$i.'][content_title]" value="'.$cvalue['content_title'].'" class="form-control content-title" placeholder="Content Title">';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '<div class="form-group">';
					$data_array['html'][$i] .= '<label class="control-label" for="content">Content</label>';
					$data_array['html'][$i] .= '<textarea name="content['.$i.'][content_body]" style="resize:none;" class="form-control content-body" placeholder="Content Title">'.$cvalue['content_body'].'</textarea>';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '<div class="panel-footer clearfix">';
					$data_array['html'][$i] .= '<button type="button" class="remove-collapse btn btn-danger pull-right"><i class="glyphicon glyphicon-remove"></i> Remove</button>';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '</div>';
					$i++;

				}
			}

			
		}
		// Job::dump($form['content']);
		return $data_array;
	}

	public static function prepareEditFormSession($form) {
		// Job::dump($content);
		$data_array = [];
		if (isset($form)) {
			$data_array['page_id'] = $form['page_id'];
			$data_array['title'] = $form['title'];
			$data_array['description'] = $form['description'];
			$data_array['url'] = $form['url'];
			$data_array['keywords'] = $form['keywords'];
			$data_array['status'] = $form['status'];
			$data_array['html'] = '';
			$i = 0;
			if (isset($form['content'])) {
				foreach ($form['content'] as $ckey => $cvalue) {
					$data_array['html'][$i] = '';
					$data_array['html'][$i] .= '<div class="panel panel-default content-set" style="margin-top:10px;">';
					$data_array['html'][$i] .= '<div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse"';
					$data_array['html'][$i] .= 'data-parent="#accordion" href="#accordion-'.$i.'" aria-expanded="true" aria-controls="collapseOne"';
					$data_array['html'][$i] .= 'style="cursor: pointer;">';
					$data_array['html'][$i] .= '<h4 class="panel-title">';
					$data_array['html'][$i] .= '<a class="this-title">';
					$data_array['html'][$i] .= 'Section '.($i+1);
					$data_array['html'][$i] .= '</a>';
					$data_array['html'][$i] .= '<a>';
					$data_array['html'][$i] .= '<i class="glyphicon glyphicon-remove pull-right"></i><i class="glyphicon glyphicon-chevron-down pull-right">&nbsp;&nbsp;</i>';
					$data_array['html'][$i] .= '</a>';
					$data_array['html'][$i] .= '</h4>';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '<div id="accordion-'.$i.'" this_set="'.$i.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">';
					$data_array['html'][$i] .= '<div class="panel-body">';
					$data_array['html'][$i] .= '<div class="form-group">';
					$data_array['html'][$i] .= '<label class="control-label" for="title">Title</label>';
					$data_array['html'][$i] .= '<input type="text" name="content['.$i.'][content_title]" value="'.$cvalue['content_title'].'" class="form-control content-title" placeholder="Content Title">';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '<div class="form-group">';
					$data_array['html'][$i] .= '<label class="control-label" for="content">Content</label>';
					$data_array['html'][$i] .= '<textarea name="content['.$i.'][content_body]" style="resize:none;" class="form-control content-body" placeholder="Content Title">'.$cvalue['content_body'].'</textarea>';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '<div class="panel-footer clearfix">';
					$data_array['html'][$i] .= '<button type="button" class="remove-collapse btn btn-danger pull-right"><i class="glyphicon glyphicon-remove"></i> Remove</button>';
					$data_array['html'][$i] .= '</div>';
					$data_array['html'][$i] .= '</div>';
					$i++;
				}
			}
		}
		// Job::dump($form['content']);
		return $data_array;
	}

	public static function prepareForEdit($page) {
		// Job::dump($content);
		$data_array = [];
		if (isset($page)) {
			$i = 0 ;
			foreach ($page as $ckey => $cvalue) {
				// for ($i=0; $i < count($form['content']); $i++) { 
				$data_array['html'][$i] = '';
				$data_array['html'][$i] .= '<div class="panel panel-default content-set" style="margin-top:10px;">';
				$data_array['html'][$i] .= '<div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse"';
				$data_array['html'][$i] .= 'data-parent="#accordion" href="#accordion-'.$i.'" aria-expanded="true" aria-controls="collapseOne"';
				$data_array['html'][$i] .= 'style="cursor: pointer;">';
				$data_array['html'][$i] .= '<h4 class="panel-title">';

				$data_array['html'][$i] .= '<a class="this-title">';
				$data_array['html'][$i] .= 'Section '.($i+1);
				$data_array['html'][$i] .= '</a>';
				$data_array['html'][$i] .= '<a>';
				$data_array['html'][$i] .= '<i class="glyphicon glyphicon-remove pull-right"></i><i class="glyphicon glyphicon-chevron-down pull-right">&nbsp;&nbsp;</i>';
				$data_array['html'][$i] .= '</a>';



				$data_array['html'][$i] .= '</h4>';
				$data_array['html'][$i] .= '</div>';
				$data_array['html'][$i] .= '<div id="accordion-'.$i.'" this_set="'.$i.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">';
				$data_array['html'][$i] .= '<div class="panel-body">';
				$data_array['html'][$i] .= '<div class="form-group">';
				$data_array['html'][$i] .= '<label class="control-label" for="title">Title</label>';
				$data_array['html'][$i] .= '<input type="text" name="content['.$i.'][content_title]" value="'.$cvalue->content_title.'" class="form-control content-title" placeholder="Content Title">';
				$data_array['html'][$i] .= '</div>';
				$data_array['html'][$i] .= '<div class="form-group">';
				$data_array['html'][$i] .= '<label class="control-label" for="content">Content</label>';
				$data_array['html'][$i] .= '<textarea name="content['.$i.'][content_body]" style="resize:none;" class="form-control content-body" placeholder="Content Title">'.$cvalue->content_body.'</textarea>';
				$data_array['html'][$i] .= '</div>';
				$data_array['html'][$i] .= '</div>';
				$data_array['html'][$i] .= '</div>';
				$data_array['html'][$i] .= '<div class="panel-footer clearfix">';
				$data_array['html'][$i] .= '<button type="button" class="remove-collapse btn btn-danger pull-right"><i class="glyphicon glyphicon-remove"></i> Remove</button>';
				$data_array['html'][$i] .= '</div>';
				$data_array['html'][$i] .= '</div>';
				$i++;
				// }
				
			}
			
		}


		// Job::dump($form['content']);
		return $data_array;
	}
	public static function prepareStatus()
	{
		return array(
			'1'	=> 'Draft',
			'2' => 'Public'
			);
	} 
}