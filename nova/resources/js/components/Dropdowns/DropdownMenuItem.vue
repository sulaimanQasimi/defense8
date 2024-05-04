<template>
  <component
    :is="component"
    v-bind="defaultAttributes"
    class="block w-full text-left py-2 px-3 focus:outline-none rounded truncate whitespace-nowrap"
    :class="{
      'hover:bg-gray-50 dark:hover:bg-gray-800 focus:ring cursor-pointer':
        !disabled,
      'text-gray-400 dark:text-gray-700 cursor-default': disabled,
      'text-red-500 hover:text-red-400 active:text-red-600 focus:ring-red-300':
        destructive && !disabled,
      'text-gray-500 active:text-gray-600 dark:text-gray-500 dark:hover:text-gray-400 dark:active:text-gray-600':
        !destructive && !disabled,
    }"
  >
    <slot />
  </component>
</template>

<script>
import filter from 'lodash/filter'

export default {
  props: {
    as: {
      type: String,
      default: 'external',
      validator: v => ['button', 'external', 'form-button', 'link'].includes(v),
    },

    destructive: {
      type: Boolean,
      default: false,
    },

    disabled: {
      type: Boolean,
      default: false,
    },
  },

  computed: {
    component() {
      return {
        button: 'button',
        external: 'a',
        link: 'Link',
        'form-button': 'FormButton',
      }[this.as]
    },

    defaultAttributes() {
      return {
        ...this.$attrs,
        ...{
          disabled:
            this.as === 'button' && this.disabled === true ? true : null,
        },
      }
    },
  },
}
</script>
