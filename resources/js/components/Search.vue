<template>
    <!-- {{-- search --}} -->
    <div class="top-left search" style=" width: 300px;">
        <input type="text" class="form-control input-search" placeholder="Tìm kiếm sách?"
        v-model="qry" v-on:keyup="autoComplete" />
        <i class="fas fa-search"></i>
        <div class="panel-results" v-if="results.length > 0"
        style="position:relative; z-index:1000; border:1px solid #ccc; background:#fff; height: 400px;">
        <p v-for="result in results">
            <router-link :to="{name:'book', params: { id: result.id } }">
                <b v-on:click="results=[]">{{result.name}} </b>
            </router-link>
        </p>
        </div>
    </div>
</template>

<script>
  export default {
    data() {
        return {
            qry:'',
            results: [],
        }
    },
    methods: {

        // clickHandler () {
        //     console.log("You clicked the button!");
        // },

        autoComplete() {
            this.results=[];
            // console.log(this.qry);
            axios.post('/search', { qry: this.qry }
            ).then( (response) => {
                // console.log(response);
                this.results = response.data;
                console.log(this.results);
            });
        },
    },
  }
</script>
<style lang="scss" scoped>
    .fa-search {
        position: absolute;
        top: 20px;
        left: .7em;
        margin-top: -9px;
        pointer-events: none;
    }
    .search {
        margin-top: 5px;
        input {
            padding-left: 40px;
        }
        p {
            padding: 5px 15px;
            margin: 0px !important;
        }
        p:hover {
            background: #E6F7FE;
        }

        a {
            color: var(--primary-text);
            font-weight: bold;
        }

        .input-search:hover, .input-search:focus  {
            border-color: rgb(64 169 255);
            border-right-width: 1px!important;
        }

        .input-search:focus {
            box-shadow: 0 0 0 2px rgba(24,144,255,.2);
        }

        .panel-results {
            overflow-y: scroll;
        }

    }
</style>
