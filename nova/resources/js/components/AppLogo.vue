<template>
  <PassthroughLogo v-if="logo" :logo="logo" :class="$attrs.class" />
  <img :src="logo" alt="" class="h-5" />
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
