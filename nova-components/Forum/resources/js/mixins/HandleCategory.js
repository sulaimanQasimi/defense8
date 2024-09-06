export default {
    data() {
        return {
            loading: false,
        }
    },
    methods: {
        editCategory(id) {
            this.editId = id;
            this.loading = true;
            Nova.request()
                .get(`forum/api/category/${id}`)
                .then(({ data: { data } }) => {
                    this.intialize();
                    this.title = data.title;
                    this.description = data.description;
                    this.show = true;
                    this.editable = true;
                    this.loading = false;

                })
                .catch((e) => {
                    console.log(e);
                });
        },
        updateCategory() {

            this.loading = true;
            Nova.request()
                .patch(`/forum/api/category/${this.editId}`, {
                    title: this.title,
                    description: this.description,
                })
                .then(({ data: { data } }) => {
                    this.intialize();
                    this.title = null;
                    this.description = null;
                    this.show = false;
                    this.editable = false;
                    this.editId = id;
                    this.loading = false;

                })
                .catch((e) => {
                    console.log(e);
                });
        },
        deleteCategory(id) {

            this.loading = true;
            Nova.request()
                .delete(`/forum/api/category/${id}`, {
                    force: false,
                })
                .then(({ data: { data } }) => {
                    this.intialize();
                    this.loading = false;

                })
                .catch((e) => {
                    console.log(e);
                });
        },
        createCategory() {

            this.loading = true;
            Nova.request()
                .post(`/forum/api/category`, {
                    title: this.title,
                    description: this.description,
                })
                .then(({ data: { data } }) => {
                    this.intialize();
                    this.title = null;
                    this.description = null;
                    this.show = false;
                    this.loading = false;

                })
                .catch((e) => {
                    console.log(e);
                });
        },
        intialize() {
            this.loading = true;
            Nova.request()
                .get(`/forum/api/category`)
                .then(({ data: { data } }) => {
                    this.categories = data;
                    this.loading = false;

                })
                .catch((e) => { });
        },
        openChat(category) {
            this.loading = true;
            Nova.request()
                .patch(`/forum/api/category/${category.id}`, {
                    title: category.title,
                    description: category.description,
                    accepts_threads: !category.accepts_threads,
                })
                .then(({ data: { data } }) => {
                    this.intialize();
                    this.loading = false;

                })
                .catch((e) => {
                    console.log(e);
                });
        },
        private(category) {

            this.loading = true;
            Nova.request()
                .patch(`/forum/api/category/${category.id}`, {
                    title: category.title,
                    description: category.description,
                    is_private: !category.is_private,
                })
                .then(({ data: { data } }) => {
                    this.intialize();
                    this.loading = false;

                })
                .catch((e) => {
                    console.log(e);
                });
        },
    }
}
