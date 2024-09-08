export default {

    methods: {
        pin(id) {
            Nova.request()
                .post(`/forum/api/thread/${id}/pin`).
                this.initialize();
        },
        unpin(id) {
            Nova.request()
                .post(`/forum/api/thread/${id}/pin`)
            this.initialize();
        },
        lock(id) {
            this.loading = true;
            Nova.request()
                .post(`/forum/api/thread/${id}/lock`)
                .then(({ data }) => {
                    this.initialize();
                    this.loading = false;
                })
        },
        unlock(id) {
            this.loading = true;
            Nova.request()
                .post(`/forum/api/thread/${id}/unlock`)
                .then(({ data }) => {
                    this.initialize();
                    this.loading = false;
                })
        }
    },
}
