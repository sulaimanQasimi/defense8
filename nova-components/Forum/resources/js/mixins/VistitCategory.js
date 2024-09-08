export default {
    data() {
        return {
            loading: false,
            categoryId: null,

            categories: [],
            title: null,
            description: null,
        }
    },
    methods: {
        initialize() {
            Nova.request()
                .get(`/forum/api/category/${this.request.id}`)
                .then(({ data: { data } }) => {
                    this.category = data;
                })
                .catch((e) => { });

            Nova.request()
                .get(`/forum/api/category/${this.request.id}/thread?page=${this.page}`)
                .then(({ data: { data, meta, links } }) => {
                    this.threads = data;
                    this.links = links;
                    this.meta = meta
                })
                .catch((e) => { });
        },
        changePage(page) {
            this.page = page
            this.initialize()
        },
        visit(id) {
            console.log(id)
            window.location = `/forum/thread?id=${id}`
        },
        createResource() {
            Nova.request()
                .post(`/forum/api/category/${this.request.id}/thread`, {
                    title: this.title,
                    content: this.description
                })
                .then(({ data }) => {
                    this.initialize()
                    this.title = null;
                    this.description = null;
                    this.show = false;
                    this.loading = false;


                })
                .catch((e) => { });
        },

        editResource(id) {
            this.editId = id;
            this.loading = true;
            Nova.request()
                .get(`/forum/api/thread/${id}`)
                .then(({ data: { data } }) => {
                    this.initialize();
                    this.title = data.title;
                    this.description = data.content;
                    this.show = true;
                    this.editable = true;
                    this.loading = false;

                })
                .catch((e) => {
                    console.log(e);
                });
        },
        updateResource() {

            this.loading = true;
            Nova.request()
                .post(`/forum/api/thread/${this.editId}/rename`, { title: this.title, })
                .then(({ data: { data } }) => {
                    this.initialize();
                    this.title = null;
                    this.description = null;
                    this.show = false;
                    this.editable = false;
                    this.loading = false;

                })
                .catch((e) => {
                    console.log(e);
                });
        },
        deleteResource(id) {
            this.loading = true;
            Nova.request()
                .delete(`/forum/api/thread/${id}`, {
                    force: false,
                })
                .then(({ data: { data } }) => {
                    this.initialize();
                    this.loading = false;

                })
                .catch((e) => {
                    console.log(e);
                });
        },
    },
}
