<template>
  <div class="row send-message-box">
    <form ref="form" @submit.prevent="save()">
      <div class="col-md-1 col-xs-1 text-right">
        <i class="fa fa-camera icon-file" @click="pickFile()"></i>
        <input type="file" ref="fileInput" style="display: none;" @change="imageChanged">
      </div>
      <div class="col-md-9 col-xs-8">
        <input type="text" class="form-control" id="message" v-model="message" />
      </div>
      <div class="col-md-2 col-xs-2">
        <button class="btn">
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
        this.$refs.fileInput.click()
      },

      imageChanged (e) {
        var fileReader = new FileReader();

        fileReader.readAsDataURL(e.target.files[0]);
        this.filename = e.target.files[0].name;

        fileReader.onload = (e) => {
          this.image = e.target.result;

          this.save();
        }
      },
      save(){

        var msg = {}

        if(this.image != '') {
          msg = { message: this.image, user: this.user.id, type: 'images' }
        } else {
          msg = { message: this.message, user: this.user.id, type: 'text' }
        }

        axios.post('/send-message', msg).then((response) => {
          $(".chat-box").scrollTop($("#chat-box").height());
        });

        this.message = '';
        this.image = '';
        this.filename = '';
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
