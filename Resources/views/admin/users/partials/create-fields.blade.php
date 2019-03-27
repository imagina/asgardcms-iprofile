<div class="box-body row">
{{--  @foreach($fields as $field)
  <div class="col-md-4">
    <label for="" class="text-capitalize">{{$field->name}}</label>
    @if($field->type=="select")
      <select class="form-control" name="{{$field->name}}">
        @foreach($field->values as $value)
          <option value="{{$value}}">{{$value}}</option>
        @endforeach
      </select>
    @else
      <input class="form-control" type="{{$field->type}}" name="{{$field->name}}" required="{{$field->required}}">
    @endif
  </div>
  @endforeach--}}
</div>
