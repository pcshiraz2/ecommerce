<template>
    <span>{{ data_output }}</span>
</template>

<script>
    export default {
        props: ['webAddress'],
        name: "notification-navbar-component",
        data() {
            return {
                data_output: 0
            }
        },
        mounted() {
            var v = this;
            axios.get(v.webAddress).then(function (response) {
                v.data_output = response.data;
            }).catch(function (error) {
                console.log(error);
            });
        }
    }
</script>