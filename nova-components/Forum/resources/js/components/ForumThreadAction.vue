<template>
  <div class="flex items-center justify-end space-x-0 text-gray-400">
    <ForumActionButton @handleClick="$emit('visit', resource.id)" icon="fas fa-eye" />
    <ForumActionButton @handleClick="$emit('edit', resource.id)" icon="fas fa-marker" />
    <ForumActionButton
      @handleClick="$emit(resource.locked ? 'unlock' : 'lock', resource.id)"
      :icon="{
        'fas fa-lock-open': !resource.locked,
        'fas fa-lock text-green-300': resource.locked,
      }"
    />
    <ForumActionButton
      @handleClick="$emit('delete', resource.id)"
      icon="fas fa-trash-can"
    />
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
