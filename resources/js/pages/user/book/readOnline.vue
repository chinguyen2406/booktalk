<template>
<div class=" container">
    <div class="row">
        <iframe class="pdf" :src="'../file/' + url" style="width: 100%; height: 100%; border: none;"></iframe>
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
            bookId: '',
            url: '',
        }
    },

    created() {
        this.bookId = this.$route.params.id;
        this.readOnline();
    },

    methods: {
        readOnline(){
            axios.get('/readOnline', {
                params: {
                    id: this.bookId,
                },
            })
            .then(response => {
                console.log(response.data);
                this.url = response.data[0].fileName;
            })
            .catch(function (error) {
                console.log(error);
            });
        },
    }
}
</script>
<style lang="scss" scoped >
    .row {
        height: 1000px;
    }
</style>
