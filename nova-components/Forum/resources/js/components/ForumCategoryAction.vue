<template>
  <div class="flex items-center justify-end space-x-0 text-gray-400">
    <ForumActionButton @handleClick="$emit('visit',resource.id)" icon="fas fa-eye" />
    <ForumActionButton @handleClick="$emit('edit',resource.id)" icon="fas fa-marker" />
    <ForumActionButton
      @click="$emit('private',resource)"
      :icon="{
        'fas fa-user-lock text-green-300': resource.is_private,
        'fas fa-users': !resource.is_private,
      }"
    />
    <ForumActionButton
      @click="$emit('openChat',resource)"
      :class="{
        'fas fa-lock text-green-300': !resource.accepts_threads,
        'fas fa-lock-open': resource.accepts_threads,
      }"
    />
    
    <ForumActionButton @click="$emit('delete',resource.id)" class="fas fa-trash-can" />
  </div>
</template>
<script>
export default {
  props: {
    resource: Object,
  },
  methods: {
    me() {
      console.log(656);
    },
  },
};
</script>
