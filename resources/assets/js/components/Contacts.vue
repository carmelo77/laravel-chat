<template>
  <div class="col-md-4 contact">
  	<div class="row user" v-for="user in users" @click="changeConversation(user)">
  		<div class="col-xs-2 text-center">
  			<img :src="user.image" class="img-circle" width="60px">
  		</div>
      <div class="col-md-8">
        <div class="name">
          {{ user.name }}
        </div>
        <span class="last-message">
          Lorem ipsum dolor sit amet, elit...
        </span>
      </div>
  	</div>
  </div>
</template>

<script>
  import bus from './../bus';

  export default {
    data(){
      return {
        users: []
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
      }
    }
  }
</script>
