<template>
  <div class="col-md-8 messages-box">
  	<div class="row" style="height:93%;overflow-y:auto;">
      <div class="col-md-12" v-for="message in messages">
        <div class="row">
          <div class="col-md-1">
            <img :src="message.user.image" :alt="message.user.name" width="60px" />
          </div>
          <div class="col-md-11 message" v-if="message.type == 2 ">
            {{ message.message }}
          </div>
          <div class="col-md-11 message" v-if="message.type == 1 ">
            <img :src="'/laravel-chat/public/images/'+message.message" alt="" width="100">
          </div>
        </div>
      </div>
  	</div>
    <div class="row">
      <send-message :user="user" :conversation="conversation"></send-message>
    </div>
  </div>
</template>

<script>
  import bus from './../bus';
  export default {
    data(){
      return {
        user: null,
        conversation: null,
        messages: []
      }
    },

    created(){
      bus.$on('conversation', (user) => {
        this.user = user;

        axios.post('/messages', {
          user: this.user.id,
          conversation: this.conversation,
        }).then((response) => {
          this.messages = response.data;
          //console.log(this.messages)
        });
      });
    },

    sockets: {
      message(data) {
        let msg = JSON.parse(data)

        console.log(msg.id)

        axios.post('/messages', {
          user: this.user.id,
          conversation: this.conversation,
        }).then((response) => {
          this.messages = response.data;
          //console.log(this.messages)
        });
      }
    }
  }
</script>

<style scoped>
  .message{
    padding: 10px;
    padding-left: 20px;
  }
</style>
