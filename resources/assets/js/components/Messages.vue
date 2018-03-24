<template>
  <div class="col-md-8 messages-box">
  	<div class="row" id="visible-chat">
      <div class="chat-box">
        <div class="chats" id="chat-box">
          <div :class="{
            chat: true,
            'chat-left': currentUser.id != message.user.id
          }" v-for="message in messages">
            <div class="chat-avatar">
              <a class="avatar" data-toggle="tooltip" href="#" data-placement="right" title="" data-original-title="June Lane">
                <img :src="message.user.image" :alt="message.user.name" width="60px" />
              </a>
            </div>
            <div class="chat-body">
              <div class="chat-content" v-if="message.type == 2">
                <p v-text="message.message"></p>
                <time class="chat-time" :datetime="message.created_at">
                  {{ message.created_at }}
                </time>
              </div>

              <div class="chat-content" v-if="message.type == 1">
                <a :href="message.message" target="_blank">
                  <img :src="message.message" alt="" width="100">
                </a>
                <time class="chat-time" :datetime="message.created_at">
                  {{ message.created_at }}
                </time>
              </div>
            </div>
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
        messages: [],
        currentUser: null,
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

          setTimeout(() => {
            $(".chat-box").scrollTop($("#chat-box").height());
          }, 500)

          //$('#chat-box').scrollTop();​​
        });
      });

      axios.get('get-user').then((response) => {
        this.currentUser = response.data;
      });
    },

    methods:{
      
    },

    sockets: {
      message(data) {
        let msg = JSON.parse(data);

        console.log(this.conversation);

        this.messages.push(msg);

        setTimeout(() => {
          $(".chat-box").scrollTop($("#chat-box").height());
        }, 200);
      }
    },
  }
</script>

<style scoped>
  #visible-chat{
    height:93%;
    overflow-y:auto;
    margin-top:15px;
  }
  .message{
    padding: 10px;
    padding-left: 20px;
  }
</style>
