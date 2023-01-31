<template>
  <span class="nav navbar-nav" style="position: absolute; left: 850px;">
    <router-link :to="{name: 'conversation'}" >
      <img :src="'/images/msg.png'" width="32" style="margin:5px; height:32px;" class="img-circle"  />
      {{countTotalUnread}}
    </router-link>
  </span>
</template>

<script>
  // import { mapGetters } from 'vuex'
  export default {
    props: {
      countTotalUnread : {
        type: Number
      }
    },
    data() {
      return {
        //
      }
    },

  }
</script>
