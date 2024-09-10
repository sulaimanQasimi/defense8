<template>
  <LoadingView :loading="loading">

    <Head :title="__('Category')" />
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
    <div class="flex gap-2 mb-6" v-if="category">
      <button
        v-if="category.accepts_threads"
        type="button"
        class="bg-yellow-300 dark:bg-gray-900 shrink-0 h-9 px-4 focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring text-white dark:text-gray-800 inline-flex items-center font-bold"
        @click="open()"
      >
        {{ __(!editable ? "Create" : "Edit") }}
      </button>
    </div>
    <ForumTitle :title="__('Create your issue here')" />
    <Card>
      <div v-if="category">
        <h1 class="text-center" style="font-size: 16px">{{ category.title }}</h1>
      </div>
    </Card>

    <div class="grid md:grid-cols-4 sm:grid-cols-1 gap-3" style="margin-top: 20px">
      <ForumPostCard
        :resource="thread"
        v-for="(thread, index) in threads"
        :user="thread.author_name"
        :content="thread.title"
        @visit="visit"
      >
        <ForumThreadAction
          v-if="isAdmin"
          @visit="visit"
          :resource="thread"
          @edit="editResource"
          @delete="deleteResource"
          @lock="lock"
          @unlock="unlock"
        />

        <ForumActionButton v-else @handleClick="visit(thread.id)" icon="fas fa-eye" />
      </ForumPostCard>
    </div>
    <ForumPagination
      v-if="threads"
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
  </LoadingView>
</template>

<script>
import ForumPagination from "../components/ForumPagination";
import {
  PanelControl,
  VistitCategory,
  ThreadAction,
  Pagination,
  Authorize,
} from "../mixins";
export default {
  mixins: [VistitCategory, PanelControl, ThreadAction, Pagination, Authorize],

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
