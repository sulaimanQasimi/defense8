<template>
  <LoadingView :loading="initialLoading">
    <Head :title="__('Guest Report')" />
    <div class="px-3 py-4 rounded-2xl">
      <g-card
        :title="__('Guest Report')"
        :repo="__('Here you can generate guest report')"
      >
        <div class="grid grid-cols-2 gap-3">
          <date-picker range clearable color="#e91e63" v-model="from" />
          <select
            v-model="department"
            class="w-full block form-control form-control-bordered form-input"
          >
            <option value="" selected>{{ __("Department") }}</option>
            <option
              :value="department.id"
              :key="department.id"
              v-for="department in departments"
            >
              {{ department.name }}
            </option>
          </select>
        </div>
      </g-card>
      <div class="flex">
        <a
          v-bind:href="excelUrl"
          target="_blank"
          class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center shadow h-9 px-3 bg-primary-500 border-primary-500 hover:[&:not(:disabled)]:bg-primary-400 hover:[&:not(:disabled)]:border-primary-400 text-white dark:text-gray-900 mt-2 mx-2"
        >
          <span class="fas fa-file-excel"></span>
          <span>{{ __("Excel") }}</span>
        </a>
        <a
          v-bind:href="pdfUrl"
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
      pdf: Nova.config("pdf"),
      excel: Nova.config("excel"),
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
        onFinish: () => Nova.success(`Filter Applied`),
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
    pdfUrl() {
      return this.pdf + "?date=" + this.date + "&department=" + this.department;
    },
    excelUrl() {
      return this.excel + "?date=" + this.date + "&department=" + this.department;
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
