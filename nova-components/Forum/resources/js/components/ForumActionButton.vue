<
<template>
  <button
    class="inline-flex items-center justify-center h-9 w-9 hover:text-primary-500 dark:hover:text-primary-500 v-popper--has-tooltip"
    @click="$emit('handleClick')"
  >
    <span class="flex items-center gap-1">
      <span :class="icon" />
    </span>
  </button>
</template>
<script>
export default {
  props: {
    icon: String,
  },
};
</script>
