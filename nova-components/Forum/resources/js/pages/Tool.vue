<template>
  <LoadingView :loading="loading">
    <Head :title="__('Forum')" />
    <Modal :show="show">
      <div class="bg-gray-100 dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden p-8">
        <ModalHeader v-text="__(!editable ? 'Create Category' : 'Edit Category')" />
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
          <div class="mt-2">
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
              @click="!editable ? createCategory() : updateCategory()"
            >
              {{ __(!editable ? "Create" : "Edit") }}
            </Button>
          </div>
        </ModalFooter>
      </div>
    </Modal>
    <div class="flex gap-2 mb-6">
      <button
        v-if="isAdmin"
        type="button"
        class="bg-yellow-300 dark:bg-gray-900 shrink-0 h-9 px-4 focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring text-white dark:text-gray-800 inline-flex items-center font-bold"
        @click="open()"
      >
        {{ __(!editable ? "Create" : "Edit") }}
      </button>
    </div>

    <Card>
      <table
        class="w-full divide-y divide-gray-100 dark:divide-gray-700"
        dusk="resource-table"
      >
        <thead class="bg-gray-50 dark:bg-gray-800">
          <tr>
            <td v-text="__('Title')" class="header border border-gray-200" />
            <td v-text="__('Remark')" class="header border border-gray-200" />
            <th></th>
          </tr>
          <tr v-for="(category, index) in categories">
            <td
              v-on:click="visit(category.id)"
              class="cursor-pointer header border border-gray-200"
              v-text="category.title"
            />
            <td
              class="cursor-pointer header border border-gray-200"
              v-text="category.description"
            />
            <td
              v-if="isAdmin"
              class="cursor-pointer px-2 w-[1%] white-space-nowrap text-right align-middle dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              <ForumCategoryAction
                :resource="category"
                @visit="visit"
                @edit="edit"
                @private="private"
                @openChat="openChat"
                @delete="delete"
              />
            </td>
          </tr>
        </thead>
      </table>
    </Card>
  </LoadingView>
</template>
<script>
import { PanelControl, ToolControl, Authorize } from "../mixins";
export default {
  mixins: [ToolControl, PanelControl, Authorize],
  props: {},
  data() {
    return {
      categories: [],
      title: null,
      description: null,
    };
  },
  mounted() {},
  created() {
    this.intialize();
  },
  methods: {},
};
</script>

<style>
/* Scoped Styles */
</style>
