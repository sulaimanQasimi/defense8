export default {
    data() {
        return {
            isAdmin: null
        }
    },
    mounted() {
        Nova.request().get(`/nova-vendor/forum/is_admin`)
        .then(({ data }) => {
            this.isAdmin = data;
        });
    },
}
