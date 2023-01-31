<template>
    <div class="col-md-3 left-sidebar hidden-xs hidden-sm" style="position:fixed; left:10px; top: 50px;">
      <ul>
        <li>
          <router-link :to="'/profile/' + user.slug " >
            <img width="32" :src="'images/' + user.pic "  style="margin:5px; height:32px;" class="img-circle"  />
              {{ user.name }}
          </router-link>
        </li>
        <li>
          <router-link :to="{name: 'dashboard'}" >
            <img :src="'images/news_feed.png'"  width="32" style="margin:5px; height:32px;" class="img-circle"  />
            News Feed
          </router-link>

        </li>
        <li>
          <router-link :to="{name: 'friends'}" >
            <img :src="'images/friends.png'" width="32" style="margin:5px; height:32px;" class="img-circle"  />
            Friends
          </router-link>
        </li>
        <li>
          <router-link :to="{name: 'conversation'}" >
            <img :src="'images/msg.png'" width="32" style="margin:5px; height:32px;" class="img-circle"  />
            Messages
          </router-link>
        </li>
        <li>
          <router-link :to="{name: 'findFriends'}" >
            <img :src="'images/friends.png'" width="32" style="margin:5px; height:32px;" class="img-circle"  />
            Find Friends
          </router-link>
        </li>
      </ul>
    </div>
</template>

<script>
  // import { mapGetters } from "vuex";
  export default {
    data() {
      return {
        user: {},
        message:''
      }
    },

    ready: function(){
        this.created();
      },

    created(){
      // show info user
      axios.get('/user')
      .then(response => {
        this.user = response.data;
        this.$emit("ComponentDashboard",response.data);
        // console.log(this.user);
      })
      .catch(function (error) {
        console.log(error);
      });
    },


  }
</script>

<style scoped>

</style>