<template>
  <div class="row send-message-box">
    <form id="conversation-id" @submit.prevent="save()" autocomplete="false" enctype="multipart/form-data">
      <div class="col-md-1 col-xs-1 text-right">
        <i class="fa fa-camera icon-file" @click="pickFile()"></i>
        <input type="file" name="image" ref="fileInput" style="display: none;" @change="imageChanged" accept="image/*" />
      </div>
      <div class="col-md-9 col-xs-8">
        <input type="text" name="message" class="form-control" id="message" v-model="message" autocomplete="false" />
      </div>
      <div class="col-md-2 col-xs-2">
        <button type="submit" class="btn">
          <i class="fa fa-send"></i>
          Send
        </button>
      </div>
    </form>
  </div>
</template>

<script>
  import bus from './../bus';

  export default {
    props: ['user', 'conversation'],

    data(){
      return {
        message: null,
        image: '',
        filename: '',
      };
    },

    methods: {
      pickFile () {
        this.$refs.fileInput.click();
      },

      imageChanged (e) {
        var fileReader = new FileReader();

        fileReader.readAsDataURL(e.target.files[0]);
        this.filename = e.target.files[0].name;

        fileReader.onload = (e) => {
          this.image = e.target.result;

          this.save(1);
        }
      },
      save(type){

        let form = $('#conversation-id')[0];

        let formData = new FormData(form);

        formData.append('user', this.user.id);

        switch (type) {
          case 1:
            formData.append('type', 1);
            break;
          default:
            formData.append('type', 2);
            break;
        }

        axios.post('/send-message', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
          .then((response) => {
            $(".chat-box").scrollTop($("#chat-box").height());
          });
      }, 
    }
  }
</script>

<style>
  .form-control{
    border-radius: 0px;
  }

  .icon-file {
    font-size: 25px;
  }
</style>
