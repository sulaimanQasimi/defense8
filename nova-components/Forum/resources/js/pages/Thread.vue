<template></template>
<script>
export default {
  props: {
    request: Object,
  },
  data() {
    return {};
  },
  mounted() {
    Nova.request()
      .get(`/forum/api/thread/${this.request.id}`)
      .then(({ data: { data } }) => {
        console.log(data)
      })
      .catch((e) => {});
  Nova.request()
      .get(`/forum/api/thread/${this.request.id}/posts`)
      .then(({ data: { data } }) => {
        console.log(data)
      })
      .catch((e) => {});
  },
};
</script>
