@php
	/*===========================================
	=            Construction fields            =
	===========================================*/
	
	function field($field,$trans,$disabled = false,$user){

		$text_label 	= $trans . '.' . $field->name;
		$result 		= '';
		$value 			= null;

		if (!$disabled) {
			$label_name 	= $field->name;
		}else{
			$label_name 	= '';
		}
		
		if(isset($user)){
			$model_user = (array) $user;
			if (isset($model_user[$field->name])) {
				if (!is_array($model_user[$field->name])) {
					$value = $model_user[$field->name];
				}
			}
		}

		switch($field->type){
		    case 'text':
		    	$result = Form::label($field->name,trans($text_label));
		    	$result .= Form::text($label_name,$value,['class' => 'form-control','readonly' => $disabled,'required' => $field->required]);
		        break;
		    case 'select':
		        $result = Form::label($field->name,trans($text_label));
				$result .= Form::select($label_name,$field->values,$value,['class' => 'form-control','readonly' => $disabled,'required' => $field->required]);
		        break;
		    case 'nunber':
		        $result = Form::label($field->name,trans($text_label));
				$result .= Form::number($label_name,$value,['class' => 'form-control','readonly' => $disabled,'required' => $field->required]);
		        break;
		    case 'date':
		        $result = Form::label($field->name,trans($text_label));
				$result .= Form::date($label_name,$value,['class' => 'form-control','readonly' => $disabled,'required' => $field->required]);
		        break;
		    case 'file':
		        $result = Form::label($field->name,trans($text_label));
				$result .= Form::file($label_name,['class' => 'form-control','readonly' => $disabled,'required' => $field->required]);
		        break;
		    case 'textarea':
		        $result = Form::label($field->name,trans($text_label));
				$result .= Form::textarea($label_name,$value,['class' => 'form-control','readonly' => $disabled,'required' => $field->required]);
		        break;
		    case 'options':
		    	$result = Form::label($field->name,trans($text_label)) . '<br>';
		    	foreach ($field->values as $key => $element) {
					$result .= Form::label($field->name,$element);
					$result .= Form::radio($field->name,$key,false);
		    	}
		        break;
		    default :

		}
		return $result;
	}
	
	/*=====  End of Construction fields  ======*/

	/*=============================================
	=            Positions Block                  =
	=============================================*/

	$positions = array();
	foreach($fields as $field){
		if(!in_array( $field->position,$positions)){
			$positions[] = $field->position;
			${'array_' . $field->position} = array();
		}
	}
	
	/*=====  End of Positions Block        ======*/
	
	/*=============================================
	=            Saved in each position           =
	=============================================*/
	$user_model = null;
	if(isset($user)){
		$user_model = $user;
	}
	
	foreach ($fields as $field) {
		$result = '';
		if ($field->type != 'json') {
			${'array_' . $field->position}[] = 	'<div class="col-md-6">'. field($field,$trans,false,$user_model) .'</div>';	
		}else{
			$result .= '<div class="col-xs-12"><br><div class="box box-primary"><div class="box-header"><h4>' . trans($trans . '.' . $field->name) . '</h4></div><div class="box-body ">';
			foreach ($field->field as $element) {
				$result .= '<div class="col-md-6">'. field($element,$trans,true,$user_model) .'</div>';
			}
			$result .= '</div></div></div>';
			${'array_' . $field->position}[] = $result;
		}
	}
	
	/*==  End of Section saved in each position  =*/
	
@endphp

{{-- main --}}

@foreach ($positions as $position)
	@foreach (${'array_' . $position} as $element)
		@push($position)
			{!! $element !!}
		@endpush
	@endforeach
@endforeach

{{-- End main --}}
