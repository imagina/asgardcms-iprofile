<div id="img-profile-store" class="mb-5" style="display:none;">

    <!-- imagen -->
        <div class="img-frame mx-auto">

            <img id="mainImage" v-if="place" class="img-fluid rounded-circle bg-white" :src="place.place.options.mainImage" alt="Logo">

                <img id="mainImage" v-else class="img-fluid rounded-circle bg-white" src="{{ Theme::url($default) }}" alt="Logo">

        </div>

        <!-- btn -->
        <div class="btn-upload mx-auto">
            <label class="btn btn-danger btn-sm btn-file mb-0 text-white rounded-circle">
                <i class="fa fa-camera"></i>
                <input type="file"
                       accept="image/*"
                       id="mainimage"
                       @change="onChangeFileUploadStore"
                       class="form-control"
                       style="display:none;">
            </label>
        </div>

        <div class="col-md-12 col-lg-auto text-center pt-4 pt-lg-0">
            <button type="button" @click="updateImageStore"
                class="btn btn-primary text-white font-weight-bold rounded-pill">
                {{ trans('core::core.button.update') }}
            </button>
        </div>

</div>

@section('scripts')
@parent
<script>
/* =========== VUE ========== */
const vue_profile_index = new Vue({
  el: '#img-profile-store',
  data: {
    store:{!! $store ? $store : "''"  !!},
    place:{!! $place ? $place : "''"  !!},
    fileStore:'',
    imageStorePath:"{{url('/')}}"+"/modules/iblog/img/post/default.jpg",
  },
  methods: {
    uploadFile(){
      var pathImage="{{url('/')}}"+"/modules/iblog/img/post/default.jpg";
      let formData = new FormData();
      formData.append('file', vue_profile_index.fileStore);
      formData.append('parent_id', 0);
      formData.append('Content-Type', "image/jpeg");
      axios.post("{{url('/')}}"+"/api/file",
      formData,
      {
        headers: {
          'Content-Type': 'multipart/form-data',
          'Authorization':'Bearer '+"{{\Auth::user()->createToken('Laravel Password Grant Client')->accessToken}}"
        }
      }
    ).then(function(data){
      //console.log(data.data.path_string);
      vue_profile_index.place.place.options.mainImage=data.data.path_string;
    })
    .catch(function(){
      vue_profile_index.place.place.options.mainImage=pathImage;
      console.log('FAILURE!!');
    });
  },
    onChangeFileUploadStore(e){
      this.fileStore = e.target.files[0];
      this.uploadFile();
    },
    updateImageStore(){
      axios.put("{{url('/')}}"+"/api/icommerce/v3/stores/"+this.store.store.id, {
        options:{
          hour_attention:vue_profile_partial_store.place.place.options.hour_attention,
          facebook:vue_profile_partial_store.place.place.options.facebook,
          twitter:vue_profile_partial_store.place.place.options.twitter,
          instagram:vue_profile_partial_store.place.place.options.instagram,
          store_parking:vue_profile_partial_store.place.place.options.store_parking,
          phone:vue_profile_partial_store.place.place.options.phone,
          mainImage:vue_profile_index.place.place.options.mainImage
        },
        place_id:this.place.place.id,
        user_id:"{{Auth::user()->id}}"
      })
      .then(function (response) {
        alert("Datos de tienda actualizados correctamente");
      })
      .catch(function (error) {
        console.log(error);
        alert("Se ha producido un error en el servidor.");
      });
    },
  },
  mounted: function () {
    this.$nextTick(function () {
    })
  }
});
</script>
@endsection
