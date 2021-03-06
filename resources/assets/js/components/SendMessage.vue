<template>
  <div class="row send-message-box">
    <form id="conversation-id" method="POST" autocomplete="false" enctype="multipart/form-data">
      <div class="col-md-1 col-xs-1 text-right">
        <i class="fa fa-camera icon-file" @click="pickFile()"></i>
        <input type="file" name="image" ref="fileInput" style="display: none;" @change="imageChanged" accept="image/*" />
      </div>
      <div class="col-md-9 col-xs-8">
        <input type="text" class="form-control regular-input" v-model="message" autocomplete="false" @keypress.enter.prevent="save()" />
        <emoji-picker @emoji="append" :search="search">
          <div
               class="emoji-invoker"
               slot="emoji-invoker"
               slot-scope="{ events }"
               v-on="events"
               >
            <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
              <path d="M0 0h24v24H0z" fill="none"/>
              <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
            </svg>
          </div>
          <div slot="emoji-picker" slot-scope="{ emojis, insert, display }">
            <div class="emoji-picker" :style="{ top: display.y + 'px', left: display.x + 'px' }">
              <div class="emoji-picker__search">
                <input type="text" v-model="search" v-focus>
              </div>
              <div>
                <div v-for="(emojiGroup, category) in emojis">
                  <h5>{{ category }}</h5>
                  <div class="emojis">
                    <span v-for="(emoji, emojiName) in emojiGroup" @click="insert(emoji)" :title="emojiName">{{ emoji }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </emoji-picker>
      </div>
      <div class="col-md-2 col-xs-2 wrapper">
        <button type="submit" class="btn" @click.prevent="save()">
          <i class="fa fa-send"></i>
          Send
        </button>
      </div>
    </form>
  </div>
</template>

<script>
  import bus from './../bus';
  import EmojiPicker from 'vue-emoji-picker'
  Vue.use(EmojiPicker)

  export default {
    props: ['user', 'conversation'],

    components: { EmojiPicker },

    data(){
      return {
        message: '',
        image: '',
        filename: '',
        search: '',
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
        formData.append('message', this.message);

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
            form.reset();
            this.message = '';
            $(".chat-box").scrollTop($("#chat-box").height());
          });
      }, 
      append(emoji) {
        this.message += emoji
      },
    },

    directives: {
      focus: {
        inserted(el) {
          el.focus()
        },
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

  .wrapper {
    position: relative;
    display: inline-block;
  }

  .regular-input {
    padding: 0.5rem 1rem;
    border-radius: 3px;
    border: 1px solid #ccc;
  }

  .emoji-invoker {
    position: absolute;
    top: 0.5rem;
    right: 3em;
    width: 1.5rem;
    height: 1.5rem;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.2s;
  }
  .emoji-invoker:hover {
    transform: scale(1.1);
  }
  .emoji-invoker > svg {
    fill: #b1c6d0;
  }

  .emoji-picker {
    z-index: 1;
    font-family: Montserrat;
    border: 1px solid #ccc;
    /*width: 30em; */
    height: 20rem;
    overflow: scroll;
    padding: 1em;
    box-sizing: border-box;
    border-radius: 0.5rem;
    background: #fff;
    box-shadow: 1px 1px 8px #c7dbe6;
    margin-top: -235px;
    
  }
  .emoji-picker__search {
    display: flex;
  }
  .emoji-picker__search > input {
    flex: 1;
    border-radius: 10rem;
    border: 1px solid #ccc;
    padding: 0.5rem 1rem;
    outline: none;
  }
  .emoji-picker h5 {
    margin-bottom: 0;
    color: #b1b1b1;
    text-transform: uppercase;
    font-size: 0.8rem;
    cursor: default;
  }
  .emoji-picker .emojis {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
  }
  .emoji-picker .emojis:after {
    content: "";
    flex: auto;
  }
  .emoji-picker .emojis span {
    padding: 0.2rem;
    cursor: pointer;
    border-radius: 5px;
  }
  .emoji-picker .emojis span:hover {
    background: #ececec;
    cursor: pointer;
  }

</style>
