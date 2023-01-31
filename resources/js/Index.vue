<template>
  <div id="main">
    <div class="top-menu">
        <div class="container" style="position: relative;">
            <span style="float: left;" >
        <router-link :to="{name: 'home'}" style="font-size:24px; text-transform: uppercase; text-decoration: none; font-weight: bold;">
<!--          <img :src="'/images/logoBT.png'" width="40" style="margin:5px;"/>-->
          SachHay
        </router-link>
      </span>
            <search></search>
            <navigationMenu v-bind:auth="user" ></navigationMenu>
        </div>
    </div>

    <div id="content">

      <div class="flex-center position-ref full-height" style="margin-top: 50px;">
        <div class="col-md-12">

          <!-- left side start -->
<!--          <leftSidebarCom v-if="$auth.check()" ></leftSidebarCom>-->
          <!-- left side end -->
          <!-- center content start -->
          <router-view v-bind:auth="user" :contact="selectedContact" :messages="messages" @newMess="saveNewMessage" ></router-view>
          <!-- center content end -->
          <!-- right side start -->
<!--          <contactsList v-if="$auth.check()" :contacts="contacts" @selected="startConversationWith" ></contactsList>-->
          <!-- right side end -->

        </div>
      </div>

    </div>
      <AppModals />
  </div>
</template>

<script>
  import navigationMenu from './components/Menu.vue';
  import leftSidebarCom from './components/leftSidebar';
  import rightSidebarCom from './components/rightSidebar';
  import search from './components/Search';
  import AppModals from './pages/modals/index';

  import EventBus from '../js/app';
  import Login from '../js/pages/Login';

  export default {
    components: {
      navigationMenu,
      leftSidebarCom,
      rightSidebarCom,
      search,
        AppModals
    },

    data() {
      return {
        user: {},
        selectedContact: null,
        messages: [],
        contacts: [],
        countTotalUnread : 0,
      }
    },
    ready: function() {
      this.created();
    },
    created() {
      // show info user
      axios.get('/user')
      .then(response => {
        this.user = response.data;
        console.log(this.user);
        //lang nghe mot kenh rieng, nhan tin nhan moi
        // socket.io-client

        // var socket = io.connect('http://127.0.0.1:8090');

          EventBus.$on(Login.LOGIN, () => {
              axios.get('/user')
                  .then(response => {
                      this.user = response.data;

                      console.log(this.user);
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
          });
        // lang nghe
        // socket.on(`private-chat.${this.user.id}:message`, (data) => {
        //     console.log('on redis');
        //     // console.log(data);
        //     this.hanleIncoming(data);
        // });


        // // get list contacts
        // axios.get('/contacts')
        // .then((response) => {
        //   this.contacts = response.data;
        //   console.log(this.contacts);
        //   this.countTotalUnread = 0;
        //   this.contacts.map((single) => {
        //     this.countTotalUnread += single.unread;
        //   })
        // });
      })
      .catch(function (error) {
        console.log(error);
      });



    },

    computed: {
      // sap xep theo thong bao tin moi
      sortedContacts() {
        this.countTotalUnread = 0;
        return _.sortBy(this.contacts, [(contact) => {
          if (contact == this.selected) {
              return Infinity;
          }
          this.countTotalUnread += contact.unread;
          return contact.unread;
        }]).reverse();

      }
    },

    methods: {
      // chon 1 cuoc noi chuyen rieng
      startConversationWith(contact) {
          //
          this.updateUnreadCount(contact, true);

          axios.get(`/conversation/${contact.id}`)
            .then((response) => {
                this.messages = response.data;
                this.selectedContact = contact;
            })
      },
      // push new messages
      saveNewMessage(message) {
          this.messages.push(message);
      },
      hanleIncoming(message) {
          if (this.selectedContact && message.user_from == this.selectedContact.id) {
              this.saveNewMessage(message);
              return;
          }
          this.updateUnreadCount(message.from_contact, false);
      },

      // updat dem tin chua doc ben user_from
      updateUnreadCount(contact, reset) {
        // map mang contacts
        this.contacts = this.contacts.map((single) => {
          // console.log(single)
          if (single.id !== contact.id) {
            return single;
          }

          if (reset)
            single.unread = 0;
          else
            single.unread += 1;

          return single;
        })
      }

    },

  }


</script>

<style scoped>
  body {
    overflow-y: hidden;
  }
  #content {
      background-color: white;
      margin-top: 70px;
  }


  .top-menu {
    position: fixed;
    top: 0px;
    left: 0px;
    right: 0px;
    z-index: 1000;
      background-color: white;
      height: 50px;
      box-shadow: rgba(0, 0, 0, 0.15) 0px 2px 5px 0px;
  }
  .msg_main{
    background-color:#ffff;
    border-left:5px solid #F5F8FA;
    position: absolute;
    left: calc(25%);
  }
  .msg_right{
    background-color:#ffff;
    border-left:5px solid #F5F8FA;
    min-height:600px;
    position:fixed;
    right:0px
  }
  .msgDiv{
    position:fixed; left:0
  }

  .left-sidebar li {
    padding:10px;
    border-bottom:1px solid #ddd;
    list-style:none;
    margin-left:-20px;
  }

  .msgDiv li:hover{
    cursor:pointer;
  }
  .jobDiv{
    border:1px solid #ddd;
    margin:10px; width:30%;
    float:left; padding:10px;
    color:#000
  }

  .caption li {
    list-style:none !important;
    padding:5px
  }

  .jobDiv .company_pic{
    width:50px;
    height:50px;
    margin:5px
  }

  .jobDetails h4{
    border:1px solid green;
    width:60%;
    padding:5px; margin:0 auto;
    text-align:center;
    color:green
  }

  .jobDetails .job_company{
    padding-bottom:10px;
    border-bottom:1px solid #ddd;
    margin-top:20px
  }

  .jobDetails .job_point{
    color:green;
    font-weight:bold
  }

  .jobDetails .email_link{
    padding:5px;
    border:1px solid green;
    color:green
  }

  html, body {
    /*background-color: #ddd;*/
    font-family: 'Raleway', sans-serif;
    font-weight: 100;
    margin: 0;
  }
  .top_bar{
    position:relative; width:99%; top:0; padding:5px; margin:0 5
  }
  .full-height {
    margin-top:50px
  }
  .position-ref {
    position: relative;
  }
  .top-right {
    position: absolute;
    right:5px; top:15px
  }
  .top-left {
    position: absolute;
    left: 300px;
    width:20%
  }
  .content {
    text-align: center;
  }
  .title {
    font-size: 84px;
  }
  .links a {
    color: #636b6f !important;
    padding: 0 25px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .1rem;
    text-decoration: none;
    text-transform: uppercase;
  }
  .m-b-md {
    margin-bottom: 30px0;
  }
  .head_har{
    background-color: #f6f7f9;
    border-bottom: 1px solid #dddfe2;
    border-radius: 2px 2px 0 0;
    font-weight: bold;
    padding: 8px 6px;
  }
  .left-sidebar, .right-sidebar{
    background-color:#fff;
    height:600px;
  }
  .posts_div{
    margin-bottom:10px !important;
  }
  .posts_div h3{
    margin-top:4px !important;
  }
  #postText{
    border:none;
    height:100px
  }
  .likeBtn{
    color: #4b4f56; font-weight:bold; cursor: pointer;
  }
  .left-sidebar li { padding:10px;
    border-bottom:1px solid #ddd;
    list-style:none; margin-left:-20px
  }
  .dropdown-menu{
    min-width:120px; left:-30px
  }
  .dropdown-menu a{
    cursor: pointer;
  }
  .dropdown-divider {
    height: 1px;
    margin: .5rem 0;
    overflow: hidden;
    background-color: #eceeef;
  }
  .user_name{
    font-size:18px;
    font-weight:bold;
    text-transform:capitalize;
    margin:3px
  }
  .all_posts{
    background-color:#fff;
    padding:5px;
    margin-bottom:15px;
    border-radius:5px;
    -webkit-box-shadow: 0 8px 6px -6px #666;
    -moz-box-shadow: 0 8px 6px -6px #666;
    box-shadow: 0 8px 6px -6px #666;
  }
  #commentBox{
    padding:10px;
    width:99%; margin:0 auto;
    padding:10px;
    margin-bottom:10px
  }

  #commentBox li {
    list-style:none;
    padding:10px; border-bottom:1px solid #ddd
  }
  .commet_form{
    padding:10px;
    margin-bottom:10px
  }
  .commentHand{
    color:blue
  }
  .commentHand:hover{
    cursor:pointer
  }
  .upload_wrap{
    position:relative;
    display:inline-block;
    width:100%
  }
  .center-con{
    max-height:880px;
    position: absolute;
    left:calc(25%);
    overflow-y: scroll;
    margin-left: 15px;
  }

  @media (min-width: 268px) and (max-width: 768px) {
    .center-con{
      max-height:880px;
      position: relative;
      left:0px;
      overflow-y: scroll;
      margin-left: 15px;
    }
  }

  .show {
    opacity: 1;
  }

</style>
