export default {
    data() {
        return {
            show: false,
            editId: null,
            editable: false,
        }
    },
    methods: {
        close() {
            this.show = false;
        },
        open() {
            this.show = true;
        },
    },
}

