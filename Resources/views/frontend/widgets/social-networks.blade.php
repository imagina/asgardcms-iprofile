      @if((!isset($profile->social))||(empty($profile->social)))
        @php
          $social=array((object)array("label"=>"fa-share-alt","desc"=>""));
        @endphp
      @else
        @php
        if(!isset($profile->social))
          $social=null;
        else
          $social=$profile->social;
        @endphp
      @endif
      @php
        $cont_social=0;
      @endphp
          <div class="table-responsive">
            <table class="table table-form table-striped table-hover" id="dynamic_field_social">
              <thead>
                <tr>
                  <th>{{trans('iprofile::profiles.form.Social.icon')}}</th>
                  <th colspan="2">{{trans('iprofile::profiles.form.Social.link')}}</th>
                </tr>
              </thead>
              <tbody>
                @foreach($social as $item)
                @php
                $red=$item->label;
                $cont_social++;
                @endphp
                    <tr  id="row_social_{{$cont_social}}">
                      <td>
            <div id="socialShare" class="btn-group share-group">
                    <a data-toggle="dropdown" class="btn btn-info principal">
                         <i class="fa {{$red}}"></i>

                    </a>
                    <input type="hidden" value="{{$item->label}}" name="label[]" id="redsocial">
            <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li>
                  <a title="Twitter" data-toggle="tooltip" data-id="fa-twitter" class="btn social-link btn-twitter" data-placement="right">
                    <i class="fa fa-twitter"></i>
                  </a>
                  </li>
                  <li>
                    <a title="Facebook" data-toggle="tooltip" data-id="fa-facebook" class="btn social-link btn-facebook" data-placement="right">
                    <i class="fa fa-facebook"></i>
                  </a>
                  </li>
                  <li>
                    <a title="Google+" data-toggle="tooltip" data-id="fa-google-plus" class="btn social-link btn-google" data-placement="right">
                    <i class="fa fa-google-plus"></i>
                  </a>
                  </li>

                    <li>
                    <a title="LinkedIn" data-toggle="tooltip" data-id="fa-linkedin" class="btn social-link btn-linkedin" data-placement="right">
                    <i class="fa fa-linkedin"></i>
                  </a>
                  </li>
                  <li>
                    <a title="Pinterest" data-toggle="tooltip" data-id="fa-pinterest" class="btn social-link btn-pinterest" data-placement="right">
                    <i class="fa fa-pinterest"></i>
                  </a>
                  </li>
                  <li>
                    <a title="Instagram" data-toggle="tooltip" data-id="fa-instagram" class="btn social-link btn-instagram" data-placement="right">
                    <i class="fa fa-instagram"></i>
                  </a>
                  </li>
                            <li>
                    <a  title="Email" data-toggle="tooltip" data-id="fa-envelope" class="btn social-link btn-mail" data-placement="right">
                    <i class="fa fa-envelope"></i>
                  </a>
                  </li>
                    </ul>
          </div>
                      </td>
                      <td><input type="text" class="form-control desc" name="desc[]" value="{{$item->desc}}" id="desc"></td>
                      <td><button type="button" name="remove" id="social_{{$cont_social}}" class="btn btn-danger btn_remove"><i class="fa fa-trash"></i></button></td>
                    </tr>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                  <td><button type="button" name="add-social" id="add-social" class="btn btn-success"><i class="fa fa-plus"></i></button></td>
                </tr>
              </tfoot>
            </table>
             <input type="hidden" value="{{$cont_social}}" id="contRedes">
          </div>
