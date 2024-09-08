<template>
  <div style="margin-top:20px" class="h-10 w-full hover:text-primary-500">
    <span class="cursor-pointer fas fa-bug fa-2xl" @click="redirect" />
  </div>
</template>

<script>
export default {
  methods: {
    redirect() {
      Nova.visit("/forum");
    },
  },
};
</script>
