<template>
  <LoadingView :loading="loading">
    <Modal :show="show">
      <div class="bg-gray-100 dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden p-8">
        <ModalHeader v-text="__(!editable ? 'Create Thread' : 'Edit Thread')" />
        <ModalContent>
          <div class="mt-2" v-if="!editable">
            <FormLabel class="space-x-1">
              <span>
                {{ __("Remark") }}
              </span>
            </FormLabel>
            <textarea
              rows="1"
              v-model="content"
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
    <div class="flex gap-2 mb-6" v-if="isAdmin">
      <button
        v-if="!thread.locked"
        type="button"
        class="bg-yellow-300 dark:bg-gray-900 shrink-0 h-9 px-4 focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring text-white dark:text-gray-800 inline-flex items-center font-bold"
        @click="open()"
      >
        {{ __(!editable ? "Create" : "Edit") }}
      </button>
    </div>

    <ForumTitle :title="__('Developers Guide')" />
    <div>
      <div v-if="thread">
        <h1 class="text-center">{{ thread.title }}</h1>
        <p class="text-center">{{ thread.content }}</p>
      </div>
      <div class="grid md:grid-cols-4 sm:grid-cols-1 gap-3">
        <ForumPostCard
          v-for="(post, index) in posts"
          :user="post.author_name"
          :content="post.content"
          :resource="post"
        />
      </div>
      <ForumPagination
        v-if="posts"
        @page="changePage"
        :currentResourceCount="meta.total"
        :allMatchingResourceCount="1"
        :resourceCountLabel="null"
        :page="meta.current_page"
        :pages="meta.links"
        :next="links.next ? true : false"
        :previous="links.prev ? true : false"
        :linksDisabled="false"
      />
    </div>
  </LoadingView>
</template>

<script>
import { ThreadVisit, Pagination, PanelControl, Authorize } from "../mixins";
export default {
  mixins: [ThreadVisit, Pagination, PanelControl, Authorize],
  props: {
    request: Object,
  },
  data() {
    return {};
  },
};
</script>
<style scoped>
.grid {
  display: grid;
}
.grid-cols-1 {
  grid-template-columns: repeat(1, minmax(0, 1fr));
}
.grid-cols-4 {
  grid-template-columns: repeat(4, minmax(0, 1fr));
}
.gap-3 {
  gap: 0.75rem;
}
@media (min-width: 640px) {
  .sm\:grid-cols-1 {
    grid-template-columns: repeat(1, minmax(0, 1fr));
  }
}
@media (min-width: 768px) {
  .md\:grid-cols-4 {
    grid-template-columns: repeat(4, minmax(0, 1fr));
  }
}
</style>
