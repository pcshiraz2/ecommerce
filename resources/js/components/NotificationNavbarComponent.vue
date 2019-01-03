<template>
    <span v-if="show_badge" class="badge badge-pill badge-danger">{{ count_unread }}</span>
</template>

<script>
    export default {
        name: "notification-navbar-component",
        data() {
            return {
                weburl: process.env.MIX_APP_URL,
                count_unread: 0,
                show_badge: false
            }
        },
        mounted() {
            var self = this;
            self.webUrl = process.env.MIX_APP_URL;
            axios.get('/notification/count-unread')
                .then(function (response) {
                    console.log(response);
                    self.count_unread = response.data.unread;
                    if (self.count_unread > 0) {
                        self.show_badge = true;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            setInterval(function () {
                axios.get('/notification/count-unread')
                    .then(function (response) {
                        console.log(response);
                        self.count_unread = response.data.unread;
                        if (self.count_unread > 0) {
                            self.show_badge = true;
                        } else {
                            self.show_badge = false;
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }, process.env.MIX_INTERVAL_TIME);
        },
    }
</script>

<style scoped>

</style>