export default {
    data() {
        return {
            loading: true,
            thread: null,
            posts: null,
            content: null
        }
    },
    mounted() {
        this.threadInitialize();
        this.postsInitialize();
    },
    methods: {

        threadInitialize() {
            this.loading = true;
            Nova.request()
                .get(`/forum/api/thread/${this.request.id}`)
                .then(({ data: { data } }) => {
                    this.thread = data;
                    this.loading = false;

                })
                .catch((e) => { });
        },
        postsInitialize() {
            this.loading = true;

            Nova.request()
                .get(`/forum/api/thread/${this.request.id}/posts?page=${this.page}`)
                .then(({ data: { data, links, meta } }) => {
                    this.posts = data,
                        this.links = links,
                        this.meta = meta
                    this.loading = false;

                })
                .catch((e) => { });
        },

        changePage(page) {
            this.page = page
            this.postsInitialize()
        },
        createResource() {
            Nova.request().post(`/forum/api/thread/${this.request.id}/posts`, {
                content: this.content,
            }).then(({ data: { data } }) => {
                this.thread = data;
                this.loading = false;
                this.content = null;
                this.postsInitialize();
                this.close();

            }).catch((e)=>{
                console.log(e)
            })
        }
    },
}
