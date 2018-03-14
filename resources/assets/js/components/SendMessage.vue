<template>
  <div class="row send-message-box">
    <form ref="form">
      <div class="col-md-12">
        &nbsp<i class="fa fa-link icon-file" @click="pickFile()"></i>
        <input type="file" ref="fileInput" style="display: none;" @change="imageChanged">
      </div>
      <div class="col-md-11">
        <input type="text" class="form-control" id="message" v-model="message" @keyup.enter="save()" />
        <span style="display: none;" id="status">{{ filename }} has ready</span>
      </div>
      <div class="col-md-1">
        <button class="btn" @click.prevent="save()">
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
        filename: ''
      };
    },

    methods: {
      pickFile () {
        this.$refs.fileInput.click()
      },

      imageChanged (e) {
        //console.log(e.target.files[0])
        var fileReader = new FileReader()

        fileReader.readAsDataURL(e.target.files[0])
        this.filename = e.target.files[0].name

        fileReader.onload = (e) => {
          this.image = e.target.result

          if(this.image != '') {
            $('#status').css('display', 'block')
          }

        }

        //console.log(this.image)
      },
      save(){

        var msg = {}

        if(this.image != '') {
          msg = { message: this.image, user: this.user.id, type: 'images' }
        } else {
          msg = { message: this.message, user: this.user.id, type: 'text' }
        }

        axios.post('/send-message', msg).then((response) => {
          bus.$emit('setConversation', response.data);
        });

        this.message = ""
        this.image = ""
        this.filename = ''
        $('#status').css('display', 'none')
      }, 
    }
  }
</script>

<style scoped>
  .form-control{
    border-radius: 0px;
  }

  .icon-file {
    font-size: 25px;
  }
</style>
