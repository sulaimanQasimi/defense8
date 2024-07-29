export default {
    getDepartments() {

        return Nova.request()
            .get("nova-vendor/guest-report/departments")
            .then(response => response.data);

    },
};
