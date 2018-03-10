<template>
  <div class="row send-message-box">
    <div class="col-md-11">
      <input type="text" class="form-control" v-model="message" />
    </div>
    <div class="col-md-1">
      <button class="btn" @click="save()">
        <i class="fa fa-send"></i>
        Send
      </button>
    </div>
  </div>
</template>

<script>
  import bus from './../bus';

  export default {
    props: ['user', 'conversation'],

    data(){
      return {
        message: null,
      };
    },

    methods: {
      save(){
        axios.post('/send-message', {
          message: this.message,
          user: this.user.id
        }).then((response) => {
          bus.$emit('setConversation', response.data);
        });
      }
    }
  }
</script>

<style scoped>
  .form-control{
    border-radius: 0px;
  }
</style>
