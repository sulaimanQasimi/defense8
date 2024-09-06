<template>
  <teleport to="body">
    <template v-if="show">
      <div
        class="modal fixed inset-0 z-[60]"
        :class="{
          'px-3 md:px-0 py-3 md:py-6 overflow-x-hidden overflow-y-auto':
            modalStyle === 'window',
          'h-full': modalStyle === 'fullscreen',
        }"
        :role="role"
        :data-modal-open="show"
        :aria-modal="show"
      >
        <div class="@container/modal relative mx-auto z-20" ref="modalContent">
          <slot />
        </div>
      </div>

      <div
        class="fixed inset-0 z-[55] bg-gray-500 dark:bg-gray-900 opacity-75"
        dusk="modal-backdrop"
      />
    </template>
  </teleport>
</template>

<script>
export default {
  props: {
    show: { type: Boolean, default: false },
    size: {
      type: String,
      default: "xl",
    },
    modalStyle: { type: String, default: "window" },
    role: { type: String, default: "dialog" },
    useFocusTrap: { type: Boolean, default: true },
  },
};
</script>
