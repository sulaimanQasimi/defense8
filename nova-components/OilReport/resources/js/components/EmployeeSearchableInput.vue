<template>
  <div>
    <div
      class="space-y-2 md:flex @md/modal:flex md:flex-row @md/modal:flex-row md:space-y-0 @md/modal:space-y-0 py-5"
      index="5"
    >
      <div
        class="w-full px-6 md:mt-2 @md/modal:mt-2 md:px-8 @md/modal:px-8 md:w-1/5 @md/modal:w-1/5"
      >
        <label
          for="enter_gate-aygad-mhman-select-field"
          class="inline-block leading-tight space-x-1"
          ><span v-html="__('Employee')"></span
          ><span class="text-red-500 text-sm">*</span></label
        >
      </div>
      <div class="w-full space-y-2 px-6 md:px-8 @md/modal:px-8 md:w-3/5 @md/modal:w-3/5">
        <!-- Search Input --><!-- Select Input Field -->
        <div class="flex relative w-full">
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
              {{ selectedResource.title }}
            </div>

            <template #option="{ selected, option }">
              <div class="flex items-center">
                <div class="flex-auto">
                  <div
                    class="text-sm font-semibold leading-normal"
                    :class="{ 'text-white dark:text-gray-900': selected }"
                  >
                    {{ option.title }}
                  </div>
                </div>
              </div>
            </template>
          </SearchInput>
        </div>
        <!--v-if--><!--v-if-->
      </div>
    </div>

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
    department: Number,
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
      this.selectedResourceId = resource.id.value;
      console.log(resource.id.value);
      //
      this.$emit("fire-value", resource.id.value);
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
      console.log(search);

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
      this.selectedResourceId = 1;
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
      console.log(this.queryParams);
      return Nova.request()
        .get(`/nova-api/card-infos`, {
          params: {
            search: this.search,
            relationshipType: "hasMany",
            trashed: null,
            viaRelationship: "card_infos",
            viaResource: "departments",
            viaResourceId: this.department,
          },
        })
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
        this.isSelectedResourceId(r.id.value)
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
            option.title.toLowerCase().indexOf(this.search.toLowerCase()) > -1 ||
            new String(option.id.value).indexOf(this.search) > -1
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
      relationshipType: "hasMany",
      trashed: null,
      viaRelationship: "card_infos",
      viaResource: "departments",
      viaResourceId: this.department,
    };
  },
};
</script>
