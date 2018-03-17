<template>
  <div class="col-md-4 contact">
    <div class="col-xs-9 col-md-12">
      <div class="row user" v-for="user in users" @click="changeConversation(user)">
        <div class="col-xs-2 text-center">
          <img :src="user.image" class="img-circle" width="60px">
        </div>
        <div class="col-xs-8">
          <div class="name">
            {{ user.name }}
          </div>
          <span class="last-message">
            Lorem ipsum dolor sit amet, elit...
          </span>
        </div>
      </div>
    </div>
    <div class="col-xs-3 text-right hidden-md hidden-lg">
      <button class="btn btn-primary" @click="showUsers">
        <i class="fa fa-bars"></i>
      </button>
    </div>
  </div>
</template>

<script>
  import bus from './../bus';

  export default {
    data(){
      return {
        users: [],
        show: false,
      };
    },

    created(){
      axios.get('/contacts').then((response) => {
        this.users = response.data;
      });
    },

    methods: {
      changeConversation(user){
        bus.$emit('conversation', user);
      },
      showUsers(){
        if (!this.show) {
          $('.contact .user').show();
          this.show = !this.show;

          return;
        }

        $('.contact .user').hide();
        this.show = !this.show;
      }
    }
  }
</script>

<style>
  @media (max-width: 994px) {
    .contact{
      overflow: auto;
      padding-top: 0px;
      height: 100% !important;
    }

    .contact .user{
      display: none;
    }
  }
</style>
