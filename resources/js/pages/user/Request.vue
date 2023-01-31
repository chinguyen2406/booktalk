<template>
<div class="col-md-6 col-sm-12 col-xs-12 center-con">
    <div class="row">
        <div class="">
            <div class="panel panel-default">
                <div class="panel-heading">{{ auth.name}}</div>
                <div class="panel-body">
                    <div class="col-sm-12 col-md-12">
                        <div v-for="(friendRequest, index) in friendRequests" :key="friendRequest.id"> 
                            <div class="row" style="border-bottom:1px solid #ccc; margin-bottom:15px" v-if="friendRequest.acted == 0">
                                <div class="col-md-2 pull-left">
                                    <img  :src="'/images/'+ friendRequest.pic " width="80px" height="80px" class="img-rounded"/>
                                </div>
                                <div class="col-md-7 pull-left">
                                    <h3 style="margin:0px;"><a href="">{{ friendRequest.name}}</a></h3>
                                    <p><b>Gender:</b> {{ friendRequest.gender}}</p>
                                    <p><b>Email:</b> {{ friendRequest.email}}</p>
                                </div>
                                <div class="col-md-3 pull-right"  style="padding-right: 0px; padding-left: 0px;" >
                                    <input @click="accept(friendRequest.id, index)" type="submit" class="btn btn-info btn-sm" value="Confirm">
                                    <input @click="requestRemove(friendRequest.id, index)" type="submit" class="btn btn-info btn-sm" value="Remove">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: {
      auth: {
        type: Object
      }
    },  

    data() {
        return {
            friendRequests:[],
        }
    },

    ready: function() {
      this.created();
    },

    created() {
      //get all friendRequests
      axios.get('/requests')
      .then(response => {
        this.friendRequests = response.data;
        console.log(this.friendRequests);
        this.friendRequests.forEach(item => {
          Vue.set(item, 'acted', 0)
        })
      }) 
      .catch(function (error) {
        console.log(error);
      }); 
    },

    methods: {
        accept(id,index) {
            axios.get('/accept/' + id)
            .then( (response) =>{
            this.friendRequests[index].acted = 1;  
            })
            .catch(function (error) {
            console.log(error); 
            });
        },

        requestRemove(id,index) {
            axios.get('/requestRemove/' + id)
            .then( (response) =>{
            this.friendRequests[index].acted = 1;  
            })
            .catch(function (error) {
            console.log(error); 
            });
        },
    }
}
</script>