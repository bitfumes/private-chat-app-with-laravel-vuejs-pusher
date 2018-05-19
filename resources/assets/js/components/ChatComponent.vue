<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card card-default">
                    <div class="card-header">
                        Private Chat App
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item"
                        @click.prevent="openChat(friend)"
                        :key=friend.id
                        v-for="friend in friends"> 
                          <a href="">
                            {{friend.name}}
                            <span class="text-danger" v-if="friend.session && (friend.session.unreadCount > 0)">{{friend.session.unreadCount}}</span>
                          </a>
                          <i class="fa fa-circle float-right text-success" v-if="friend.online" aria-hidden="true"></i>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <span v-for="friend in friends" :key="friend.id" v-if="friend.session">
                    <message-component
                    v-if="friend.session.open"
                    @close="close(friend)"
                    :friend=friend
                    ></message-component>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
import MessageComponent from "./MessageComponent";
export default {
  data() {
    return {
      friends: []
    };
  },
  methods: {
    close(friend) {
      friend.session.open = false;
    },
    getFriends() {
      axios.post("/getFriends").then(res => {
        this.friends = res.data.data;
        this.friends.forEach(
          friend => (friend.session ? this.listenForEverySession(friend) : "")
        );
      });
    },
    openChat(friend) {
      if (friend.session) {
        this.friends.forEach(
          friend => (friend.session ? (friend.session.open = false) : "")
        );
        friend.session.open = true;
        friend.session.unreadCount = 0;
      } else {
        this.createSession(friend);
      }
    },
    createSession(friend) {
      axios.post("/session/create", { friend_id: friend.id }).then(res => {
        (friend.session = res.data.data), (friend.session.open = true);
      });
    },
    listenForEverySession(friend) {
      Echo.private(`Chat.${friend.session.id}`).listen(
        "PrivateChatEvent",
        e => (friend.session.open ? "" : friend.session.unreadCount++)
      );
    }
  },
  created() {
    this.getFriends();

    Echo.channel("Chat").listen("SessionEvent", e => {
      let friend = this.friends.find(friend => friend.id == e.session_by);
      friend.session = e.session;
      this.listenForEverySession(friend);
    });

    Echo.join(`Chat`)
      .here(users => {
        this.friends.forEach(friend => {
          users.forEach(user => {
            if (user.id == friend.id) {
              friend.online = true;
            }
          });
        });
      })
      .joining(user => {
        this.friends.forEach(
          friend => (user.id == friend.id ? (friend.online = true) : "")
        );
      })
      .leaving(user => {
        this.friends.forEach(
          friend => (user.id == friend.id ? (friend.online = false) : "")
        );
      });
  },
  components: { MessageComponent }
};
</script>