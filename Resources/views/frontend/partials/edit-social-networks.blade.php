 
          <div class="table-responsive">
            <table class="table table-form table-striped table-hover" id="dynamic_field_social">
              <thead>
                <tr>
                  <th>{{trans('iprofile::profiles.form.Social.icon')}}</th>
                  <th colspan="2">{{trans('iprofile::profiles.form.Social.link')}}</th>
                </tr>
              </thead>
              <tbody>
                  <tr v-for="(item, index) in social" :id="'row_social_'+index">
                      <td>
            <div id="socialShare" class="btn-group share-group">
                    <a data-toggle="dropdown" class="btn btn-info principal">
                         <i :class="'fa '+item.label"></i>

                    </a>
                    <input type="hidden" :value="social[index].label" name="label[]" id="redsocial">
                <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
                    <i class="fa fa-caret-down" style="font-size: 24px"></i>
                </button>
              <ul class="dropdown-menu px-2">
                <li>
                  <a @click="addLabel(index,'fa-twitter')" title="Twitter" data-toggle="tooltip" data-id="fa-twitter" class="btn social-link btn-twitter" data-placement="right">
                    <i class="fa fa-twitter"  style="font-size: 14px"></i>
                  </a>
                  </li>
                  <li>
                    <a @click="addLabel(index,'fa-facebook')" title="Facebook" data-toggle="tooltip" data-id="fa-facebook" class="btn social-link btn-facebook" data-placement="right">
                    <i class="fa fa-facebook" style="font-size: 14px"></i>
                  </a>
                  </li>
                  <li>
                    <a @click="addLabel(index,'fa-google')" title="Google+" data-toggle="tooltip" data-id="fa-google-plus" class="btn social-link btn-google" data-placement="right">
                    <i class="fa fa-google-plus" style="font-size: 14px"></i>
                  </a>
                  </li>

                    <li>
                    <a @click="addLabel(index,'fa-linkedin')" title="LinkedIn" data-toggle="tooltip" data-id="fa-linkedin" class="btn social-link btn-linkedin" data-placement="right">
                    <i class="fa fa-linkedin" style="font-size: 14px"></i>
                  </a>
                  </li>
                  <li>
                    <a @click="addLabel(index,'fa-pinterest')" title="Pinterest" data-toggle="tooltip" data-id="fa-pinterest" class="btn social-link btn-pinterest" data-placement="right">
                    <i class="fa fa-pinterest" style="font-size: 14px"></i>
                  </a>
                  </li>
                  <li>
                    <a @click="addLabel(index,'fa-instagram')" title="Instagram" data-toggle="tooltip" data-id="fa-instagram" class="btn social-link btn-instagram" data-placement="right">
                    <i class="fa fa-instagram" style="font-size: 14px"></i>
                  </a>
                  </li>
                            <li>
                    <a  @click="addLabel(index,'fa-envelope')" title="Email" data-toggle="tooltip" data-id="fa-envelope" class="btn social-link btn-mail" data-placement="right">
                    <i class="fa fa-envelope" style="font-size: 14px"></i>
                  </a>
                  </li>
                    </ul>
          </div>
                      </td>
                      <td><input type="text" class="form-control desc" name="desc[]" v-model="social[index].desc" id="desc"></td>
                      <td><button type="button" name="remove" :id="'social_'+index" @click="removeSocial(index)" class="btn btn-danger btn_remove"><i class="fa fa-trash"></i></button></td>
                    </tr>
        

              </tbody>
              <tfoot>
                <tr>
                  <td><button type="button" name="add-social" @click="addSocial" id="add-social" class="btn btn-success"><i class="fa fa-plus"></i></button></td>
                </tr>
              </tfoot>
            </table>
             <input type="hidden" :value="social.length" id="contRedes">
          </div>
