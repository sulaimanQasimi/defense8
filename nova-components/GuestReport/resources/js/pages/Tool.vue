<template>
  <LoadingView :loading="initialLoading">
    <Head :title="__('Guest Report')" />
    <div class="px-3 py-4 rounded-2xl">
      <g-card
        :title="__('Guest Report')"
        :repo="__('Here you can generate guest report')"
      >
        <div class="mt-6 bg-white px-3 py-4 rounded-2xl">
          <div class="grid md:grid-cols-3 sm:grid-cols-1 gap-3">
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
                    ><span v-html="__('Date')"></span
                    ><span class="text-red-500 text-sm">*</span></label
                  >
                </div>
                <div
                  class="w-full space-y-2 px-6 md:px-8 @md/modal:px-8 md:w-3/5 @md/modal:w-3/5"
                >
                  <!-- Search Input --><!-- Select Input Field -->
                  <div class="flex relative w-full">
                    <date-picker range color="#e91e63" v-model="from" />
                  </div>
                </div>
              </div>
            </div>
            <searchable-input
              url="/nova-api/card-infos/associatable/orginization"
              @fire-value="getDepartment"
            />
          </div>
        </div>
      </g-card>
      <div class="flex">
        <a
          v-bind:href="reportUrl + '?file=excel&date=' + this.date + '&department=' + this.department"
          target="_blank"
          class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center shadow h-9 px-3 bg-primary-500 border-primary-500 hover:[&:not(:disabled)]:bg-primary-400 hover:[&:not(:disabled)]:border-primary-400 text-white dark:text-gray-900 mt-2 mx-2"
        >
          <span class="fas fa-file-excel"></span>
          <span>{{ __("Excel") }}</span>
        </a>
        <a
          v-bind:href="
            reportUrl + '?file=pdf&date=' + this.date + '&department=' + this.department
          "
          target="_blank"
          class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center shadow h-9 px-3 bg-primary-500 border-primary-500 hover:[&:not(:disabled)]:bg-primary-400 hover:[&:not(:disabled)]:border-primary-400 text-white dark:text-gray-900 mt-2 mx-2"
        >
          <span class="fas fa-file-pdf"></span>
          <span>{{ __("PDF") }}</span>
        </a>
      </div>
    </div>
    <guest-details :pdfUrl="pdfUrl" :excelUrl="excelUrl" :guests="guests" />
  </LoadingView>
</template>

<script>
import Vue3PersianDatetimePicker from "vue3-persian-datetime-picker";
export default {
  props: {
    selectedDepartment: String,
    guests: Object,
    url: String,
    date: String,
  },
  components: {
    DatePicker: Vue3PersianDatetimePicker,
  },

  data() {
    return {
      reportUrl: Nova.config("report"),
      departments: null,
      department: this.selectedDepartment,
      initialLoading: false,
      from: this.date,
    };
  },
  watch: {
    from(newValue, oldValue) {
      Nova.visit(
        "/guest-report?page=1&date=" + newValue + "&department=" + this.department,
        {
          onFinish: () => Nova.success(`Filter Applied`),
        }
      );
    },
    department(newValue, oldValue) {
      Nova.visit("/guest-report?page=1&date=" + this.from + "&department=" + newValue, {
        onFinish: () => Nova.success(`Filter Applied`),
      });
    },
  },

  created() {},
  mounted() {
    Nova.addShortcut("ctrl+shift", (event) => {
      Nova.visit("/guest-report", {
        onFinish: () => Nova.success(`Page Reloaded`),
      });
    });
    Nova.request()
      .get("/nova-vendor/guest-report/departments")
      .then((response) => {
        this.departments = response.data;
        Nova.success("It worked!");
      });
  },
  methods: {
    getDepartment(value) {
      this.department = value;
    },
  },
  computed: {},
};
</script>

<style scoped>
/* Scoped Styles */
.grid {
  display: grid;
}
.grid-cols-2 {
  grid-template-columns: repeat(2, minmax(0, 1fr));
}
.gap-3 {
  gap: 0.75rem;
}
</style>
