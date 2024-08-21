<template>
  <div>
    <SearchInput
      :dusk="`departments-search-input`"
      :disabled="currentlyIsReadonly"
      @input="performResourceSearch"
      @clear="clearResourceSelection"
      @selected="selectResource"
      :value="selectedResource"
      :data="filteredResources"
      trackBy="value"
      class="w-full"
      :mode="mode"
    >
      <div v-if="selectedResource" class="flex items-center">
        {{ selectedResource.display }}
      </div>

      <template #option="{ selected, option }">
        <SearchInputResult
          :option="option"
          :selected="selected"
          :with-subtitles="false"
        />
      </template>
    </SearchInput>

    <!--  -->
  </div>
</template>

<script>
import find from "lodash/find";
import isNil from "lodash/isNil";
import debounce from "lodash/debounce";
export default {
  emits: ["fire-value"],
  props: {
    url: String,
    resourceId: Number,
  },
  data() {
    return {
      availableResources: [],
      initializingWithExistingResource: false,
      selectedResource: null,
      selectedResourceId: null,
      search: "",
    };
  },
  mounted() {
    this.initializeComponent();
  },
  methods: {
    selectResource(resource) {
      this.selectedResource = resource;
      this.selectedResourceId = resource.value;
      //
      this.$emit("fire-value", resource.value);
    },

    /**
     * Handle the search box being cleared.
     */
    handleSearchCleared() {
      this.availableResources = [];
    },

    /**
     * Clear the selected resource and availableResources
     */
    clearSelection() {
      this.selectedResource = null;
      this.selectedResourceId = null;
      this.availableResources = [];
    },

    /**
     * Perform a search to get the relatable resources.
     */
    performSearch(search) {
      this.search = search;

      const trimmedSearch = search.trim();
      // If the user performs an empty search, it will load all the results
      // so let's just set the availableResources to an empty array to avoid
      // loading a huge result set
      if (trimmedSearch == "") {
        return;
      }

      this.searchDebouncer(() => {
        this.getAvailableResources(trimmedSearch);
      }, 500);
    },

    /**
     * Debounce function for the search handler
     */
    searchDebouncer: debounce((callback) => callback(), 500),

    //
    initializeComponent() {
      this.selectedResourceId = this.resourceId;
      //   this.getAvailableResources();

      if (this.useSearchInput) {
        // If we should select the initial resource and the field is
        // searchable, we won't load all the resources but we will select
        // the initial option.
        this.getAvailableResources().then(() => this.selectInitialResource());
      } else {
        // If we should select the initial resource but the field is not
        // searchable we should load all of the available resources into the
        // field first and select the initial option.
        this.initializingWithExistingResource = false;

        this.getAvailableResources().then(() => this.selectInitialResource());
      }
    },
    //
    selectResourceFromSelectControl(value) {
      this.selectedResourceId = value;
      this.selectInitialResource();

      if (this.field) {
        this.emitFieldValueChange(this.fieldAttribute, this.selectedResourceId);
      }
    },

    /**
     * Fill the forms formData with details from this field
     */
    fill(formData) {
      this.fillIfVisible(
        formData,
        this.fieldAttribute,
        this.selectedResource ? this.selectedResource.value : ""
      );
      this.fillIfVisible(formData, `${this.fieldAttribute}_trashed`, this.withTrashed);
    },
    // Get All Department Resources
    getAvailableResources() {
      Nova.$progress.start();
      return Nova.request()
        .get(`${this.url}?search=${this.search}`)
        .then(({ data: { resources, softDeletes, withTrashed } }) => {
          Nova.$progress.done();
          this.availableResources = resources;
        })
        .catch((e) => {
          Nova.$progress.done();
        });
    },

    /**
     * Determine if the given value is numeric.
     */
    isNumeric(value) {
      return !isNaN(parseFloat(value)) && isFinite(value);
    },

    /**
     * Select the initial selected resource
     */
    selectInitialResource() {
      this.selectedResource = find(this.availableResources, (r) =>
        this.isSelectedResourceId(r.value)
      );
    },

    /**
     * Toggle the trashed state of the search
     */

    performResourceSearch(search) {
      if (this.useSearchInput) {
        this.performSearch(search);
      } else {
        this.search = search;
      }
    },

    clearResourceSelection() {
      this.clearSelection();
      this.getAvailableResources();
    },

    onSyncedField() {
      this.initializeComponent();
    },
    emitOnSyncedFieldValueChange() {
      if (this.viaRelatedResource) {
        return;
      }

      this.emitFieldValueChange(this.fieldAttribute, this.selectedResourceId);
    },

    syncedFieldValueHasNotChanged() {
      return this.isSelectedResourceId(this.currentField.value);
    },

    isSelectedResourceId(value) {
      console.log(value);
      return !isNil(value) && value?.toString() === this.selectedResourceId?.toString();
    },
  },
  computed: {
    /**
     * Determine if the related resources is searchable
     */
    isSearchable() {
      return true;
    },

    /**
     * Get the query params for getting available resources
     */

    shouldLoadFirstResource() {
      return (
        (this.initializingWithExistingResource &&
          !this.shouldIgnoresViaRelatedResource) ||
        Boolean(this.currentlyIsReadonly && this.selectedResourceId)
      );
    },

    shouldShowTrashed() {
      return (
        this.softDeletes &&
        !this.viaRelatedResource &&
        !this.currentlyIsReadonly &&
        this.currentField.displaysWithTrashed
      );
    },

    /**
     * Return the placeholder text for the field.
     */
    placeholder() {
      return this.currentField.placeholder || this.__("—");
    },

    /**
     * Return the field options filtered by the search string.
     */
    filteredResources() {
      if (!this.isSearchable) {
        return this.availableResources.filter((option) => {
          return (
            option.display.toLowerCase().indexOf(this.search.toLowerCase()) > -1 ||
            new String(option.value).indexOf(this.search) > -1
          );
        });
      }

      return this.availableResources;
    },
    useSearchInput() {
      return this.isSearchable || this.viaRelatedResource;
    },
  },
  queryParams() {
    return {
      search: this.search,
    };
  },
};
</script>
