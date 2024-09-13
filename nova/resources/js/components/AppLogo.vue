<template>
  <img src="/app.png" alt="" class="h-5" />
</template>

<script>
export default {
  inheritAttrs: false,
  computed: {
    logo() {
      return window.Nova.config("logo");
    },
  },
};
</script>
