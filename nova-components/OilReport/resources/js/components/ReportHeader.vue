<template>
  <div class="bg-white px-3 py-4 rounded-2xl">
    <div
      class="text-center font-medium text-2xl text-blue-500"
      v-html="__('Oil Report')"
    />
    <div
      v-html="__('Here you can generate report')"
      class="text-sm text-blue-300 text-center"
    />
  </div>
</template>
<script>

export default {
    props:{

    }
}
</script>
