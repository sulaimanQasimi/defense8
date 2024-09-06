<template>
  <Modal :show="show">
    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden p-8">
      <ModalHeader v-text="__(!editable ? 'Create Thread' : 'Edit Thread')" />
      <ModalContent>
        <div>
          <FormLabel class="space-x-1">
            <span>
              {{ __("Title") }}
            </span>
          </FormLabel>
          <input
            class="w-full form-control form-input form-control-bordered"
            v-model="title"
          />
        </div>
        <div class="mt-2" v-if="!editable">
          <FormLabel class="space-x-1">
            <span>
              {{ __("Remark") }}
            </span>
          </FormLabel>
          <textarea
            rows="1"
            v-model="description"
            type="text"
            class="font-mono text-xs resize-none block w-full px-3 py-3 dark:text-gray-400 bg-clip-border focus:outline-none focus:ring focus:ring-inset"
            style="background-clip: border-box"
          />
        </div>
      </ModalContent>

      <ModalFooter>
        <div class="flex items-center ml-auto">
          <CancelButton
            component="button"
            type="button"
            dusk="cancel-action-button"
            class="ml-auto mr-3"
            @click="close()"
          >
            {{ __("Cancel") }}
          </CancelButton>

          <Button
            type="button"
            ref="runButton"
            dusk="confirm-action-button"
            :loading="true"
            variant="solid"
            :state="'default'"
            @click="!editable ? createResource() : updateResource()"
          >
            {{ __(!editable ? "Create" : "Edit") }}
          </Button>
        </div>
      </ModalFooter>
    </div>
  </Modal>
  <div class="flex gap-2 mb-6">
    <button
      type="button"
      class="bg-yellow-300 dark:bg-gray-900 shrink-0 h-9 px-4 focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring text-white dark:text-gray-800 inline-flex items-center font-bold"
      @click="open()"
    >
      {{ __(!editable ? "Create" : "Edit") }}
    </button>
  </div>

  <Card>
    <LoadingView :loading="loading">
      <div v-if="category">
        <h1 class="text-center">{{ category.title }}</h1>
        <p class="text-center">{{ category.description }}</p>
      </div>
      <table
        class="w-full divide-y divide-gray-100 dark:divide-gray-700"
        dusk="resource-table"
      >
        <thead class="bg-gray-50 dark:bg-gray-800">
          <tr>
            <td v-text="__('Title')" class="header border border-gray-200" />
            <td v-text="__('User')" class="header border border-gray-200" />
            <td v-text="__('Reply')" class="header border border-gray-200" />
          </tr>
          <tr v-for="(thread, index) in threads">
            <td class="header border border-gray-200" v-text="thread.title" />
            <td class="header border border-gray-200" v-text="thread.author_name" />
            <td class="header border border-gray-200" v-text="thread.reply_count" />
            <td
              class="cursor-pointer px-2 w-[1%] white-space-nowrap text-right align-middle dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              <div class="flex items-center justify-end space-x-0 text-gray-400">
                <a
                  dusk="448-view-button"
                  class="inline-flex items-center justify-center h-9 w-9 hover:text-primary-500 dark:hover:text-primary-500 v-popper--has-tooltip"
                  disabled="false"
                  :href="`/forum/category?id=${thread.id}`"
                  ><span class="flex items-center gap-1"
                    ><span class="fas fa-eye"></span></span></a
                ><a
                  aria-label="ویرایش"
                  dusk="448-edit-button"
                  class="inline-flex items-center justify-center h-9 w-9 hover:text-primary-500 dark:hover:text-primary-500 v-popper--has-tooltip"
                  disabled="false"
                  @click="editResource(thread.id)"
                  ><span class="flex items-center gap-1"
                    ><span class="fas fa-marker"></span
                  ></span>
                </a>
                <button
                  type="button"
                  class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center bg-transparent border-transparent text-gray-500 dark:text-gray-400 hover:[&amp;:not(:disabled)]:text-primary-500 h-9 w-9 v-popper--has-tooltip"
                  @click="private(category)"
                >
                  <span class="flex items-center gap-1">
                    <span
                      :class="{
                        'fas fa-user-lock text-green-300': thread.is_private,
                        'fas fa-users': !thread.is_private,
                      }"
                    ></span
                  ></span>
                </button>
                <button
                  type="button"
                  class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center bg-transparent border-transparent text-gray-500 dark:text-gray-400 hover:[&amp;:not(:disabled)]:text-primary-500 h-9 w-9 v-popper--has-tooltip"
                  @click="thread.locked ? unlock(thread.id) : lock(thread.id)"
                >
                  <span class="flex items-center gap-1">
                    <span
                      :class="{
                        'fas fa-lock-open': !thread.locked,
                        'fas fa-lock text-green-300': thread.locked,
                      }"
                    ></span
                  ></span>
                </button>
                <button
                  type="button"
                  class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center bg-transparent border-transparent text-gray-500 dark:text-gray-400 hover:[&amp;:not(:disabled)]:text-primary-500 h-9 w-9 v-popper--has-tooltip"
                  @click="deleteResource(thread.id)"
                >
                  <span class="flex items-center gap-1"
                    ><span class="fas fa-trash-can"></span
                  ></span>
                </button>
              </div>
            </td>
          </tr>
        </thead>
      </table>
    </LoadingView>
  </Card>
</template>

<script>
import { PanelControl, VistitCategory, ThreadAction } from "../mixins";
export default {
  mixins: [VistitCategory, PanelControl, ThreadAction],
  props: {
    request: null,
  },
  data() {
    return {
      category: null,
      threads: null,
    };
  },
  created() {
    this.initialize();
  },
};
</script>
