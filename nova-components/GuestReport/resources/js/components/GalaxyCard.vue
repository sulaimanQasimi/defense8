<template>
  <div class="card bg-white dark:bg-gray-900 rounded-xl px-10">
    <div class="text-center text-2xl dark:text-white" v-text="title"></div>
    <div class="text-center text-xl dark:text-white" v-text="repo"></div>
    <div class="flex justify-center">
      
    </div>
    <slot />
  </div>
</template>
<script>
export default {
  props: {
    title: String,
    repo: String,
    pdfUrl: String,
    excelUrl: String,
  },
};
</script>
<style >
.card{
    padding-right:2.5rem;
    padding-left:2.5rem;
    padding-top:2.5rem;
    padding-bottom:2.5rem;
}
</style>
