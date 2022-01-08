<template>
  <div class="container">
    <form class="chat mt-3" @submit.prevent="submit">
      <div class="user">
        <div class="mb-3 col-lg-3 col-md-6 col-sm-12">
          <input type="text" class="form-control" v-model="username" placeholder="Username">
        </div>
      </div>
      <div class="content">
        <ol class="list-group">
          <li class="list-group-item d-flex justify-content-between align-items-start"
              v-for="message in messages" :key="message.message.content"
          >
            <div class="ms-2 me-auto">
              <div class="fw-bold">{{ message.message.username }}</div>
              {{ message.message.content }}
            </div>
          </li>
        </ol>
      </div>
      <div class="message">
        <div class="mt-3">
          <input type="text" class="form-control" v-model="content" placeholder="Input message" v-on:keyup.enter.prevent="submit">
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import Pusher from 'pusher-js';

export default {
  data() {
    return {
      username: "Linh",
      content: "",
      messages: [],
    }
  },
  mounted() {
    Pusher.logToConsole = true;

    const pusher = new Pusher('f7529363803c00d22913', {
      cluster: 'ap1'
    });

    const channel = pusher.subscribe('chat');
    channel.bind('message', data => {
      this.messages.push(data)
    });
  },
  methods: {
    async submit() {
      let message = {
        'username': this.username,
        'content': this.content
      }
      await this.$axios.$post('http://127.0.0.1:8000/api/messages', {message});

      this.content = '';
    }
  }
}
</script>

<style scoped>
.content {
  min-height: 400px;
  max-height: 400px;
  overflow: scroll;
}
</style>
