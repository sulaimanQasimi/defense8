<template>
  <div class="flex items-center justify-end space-x-0 text-gray-400">
    <button
      dusk="448-view-button"
      class="inline-flex items-center justify-center h-9 w-9 hover:text-primary-500 dark:hover:text-primary-500 v-popper--has-tooltip"
      disabled="false"
      @click="$emit('visit', resource.id)"
    >
      <span class="flex items-center gap-1"
        ><span class="fas fa-eye"></span
      ></span></button
    ><button
      class="inline-flex items-center justify-center h-9 w-9 hover:text-primary-500 dark:hover:text-primary-500 v-popper--has-tooltip"
      @click="$emit('edit', resource.id)"
    >
      <span class="flex items-center gap-1"><span class="fas fa-marker"></span></span>
    </button>

    <button
      type="button"
      class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center bg-transparent border-transparent text-gray-500 dark:text-gray-400 hover:[&amp;:not(:disabled)]:text-primary-500 h-9 w-9 v-popper--has-tooltip"
      @click="$emit(resource.locked ? 'unlock' : 'lock', resource.id)"
    >
      <span class="flex items-center gap-1">
        <span
          :class="{
            'fas fa-lock-open': !resource.locked,
            'fas fa-lock text-green-300': resource.locked,
          }"
        ></span
      ></span>
    </button>

    <button
      type="button"
      class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center bg-transparent border-transparent text-gray-500 dark:text-gray-400 hover:[&amp;:not(:disabled)]:text-primary-500 h-9 w-9 v-popper--has-tooltip"
      @click="$emit('delete', resource.id)"
    >
      <span class="flex items-center gap-1"><span class="fas fa-trash-can"></span></span>
    </button>
  </div>
</template>
<script>
export default {
  props: {
    resource: Object,
  },
  methods: {},
};
</script>
