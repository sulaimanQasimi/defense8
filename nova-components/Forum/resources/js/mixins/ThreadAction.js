export default {

    methods: {
        pin(id) {
            Nova.request()
                .post(`/forum/api/thread/${id}/pin`)
            this.initialize();
        },
        unpin(id) {
            Nova.request()
                .post(`/forum/api/thread/${id}/pin`)
            this.initialize();
        },
        lock(id) {
            Nova.request()
                .post(`/forum/api/thread/${id}/pin`)
            this.initialize();
        },
        unlock(id) {
            Nova.request()
                .post(`/forum/api/thread/${id}/pin`)
            this.initialize();
        }
    },
}
