<template>
  <LoadingView :loading="false">
    <div>
      <Head :title="__('Oil Report')" />
      <report-header />
      <Card>
        <div class="grid grid-cols-3 gap-2">
          <date-picker
            range
            clearable
            color="#e91e63"
            v-model="from"
            style="margin: 5px"
          />
          <searchable-input
            url="/nova-api/card-infos/associatable/orginization"
            @fire-value="getDepartment"
            :resourceId="department"
          />
          <employee-searchable-input
            :department="department"
            @fire-value="getEmployee"
            :resourceId="employee"
          />
        </div>
      </Card>
    </div>
    <div class="mb-2">
      <a
        class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center shadow h-9 px-3 bg-primary-500 border-primary-500 hover:[&:not(:disabled)]:bg-primary-400 hover:[&:not(:disabled)]:border-primary-400 text-white dark:text-gray-900 mt-2 mx-2"
        v-bind:href="`${this.requirement.disterbute}?file=excel&date=${from}&department=${department}&employee=${employee}`"
        target="_blank"
      >
        <span class="fas fa-file-excel mx-2"></span>
        {{ __("Create Disterbuted Oil Report") }}
      </a>
      <a
        class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center shadow h-9 px-3 bg-primary-500 border-primary-500 hover:[&:not(:disabled)]:bg-primary-400 hover:[&:not(:disabled)]:border-primary-400 text-white dark:text-gray-900 mt-2 mx-2"
        v-bind:href="`${this.requirement.importOil}?file=excel&date=${from}`"
        href="#"
        target="_blank"
      >
        <span class="fas fa-file-excel mx-2"></span>
        {{ __("Create Imported Oil Report") }}
      </a>
      <a
        class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center shadow h-9 px-3 bg-primary-500 border-primary-500 hover:[&:not(:disabled)]:bg-primary-400 hover:[&:not(:disabled)]:border-primary-400 text-white dark:text-gray-900 mt-2 mx-2"
        v-bind:href="`${this.requirement.disterbute}?&date=${from}&department=${department}&employee=${employee}`"
        href="#"
        target="_blank"
      >
        <span class="fas fa-file-pdf mx-2"></span>
        {{ __("Create Disterbuted Oil Report") }}
      </a>
      <a
        class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center shadow h-9 px-3 bg-primary-500 border-primary-500 hover:[&:not(:disabled)]:bg-primary-400 hover:[&:not(:disabled)]:border-primary-400 text-white dark:text-gray-900 mt-2 mx-2"
        v-bind:href="`${this.requirement.importOil}?&date=${from}`"
        target="_blank"
      >
        <span class="fas fa-file-pdf mx-2"></span>
        {{ __("Create Imported Oil Report") }}
      </a>
    </div>
    <Card>
      <table
        class="w-full divide-y divide-gray-100 dark:divide-gray-700"
        dusk="resource-table"
      >
        <thead class="bg-gray-50 dark:bg-gray-800">
          <tr>
            <th
              v-for="(field, index) in requirement.fields"
              :key="index"
              :class="{
                [`text-center`]: true,
                'border-r border-gray-200 dark:border-gray-600': false,
                'px-6': true,
              }"
              class="uppercase text-gray-500 text-xxs tracking-wide py-2"
            >
              {{ field.label }}
            </th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
          <tr
            class="group"
            v-for="resource in disterbutes.data"
            @click.stop.prevent="handleClick(resource.id)"
          >
            <!-- Fields -->
            <td
              v-for="(field, index) in requirement.fields"
              class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
              v-text="resource[field.key]"
              :class="{
                [`text-center`]: true,
                'px-6': true,
                'px-2': true,
              }"
            />
          </tr>
        </tbody>
      </table>
    </Card>
    <div class="border-t border-gray-200 dark:border-gray-700">
      <nav class="rounded-b-lg font-bold flex items-center">
        <div class="flex text-sm">
          <!-- First Link -->

          <Link
            class="border-r border-gray-200 dark:border-gray-700 text-xl h-9 min-w-9 px-2 rounded-bl-lg focus:outline-none focus:bg-gray-50 hover:bg-gray-50 dark:hover:bg-gray-700"
            title="بعدی"
            :href="disterbutes.links.next"
          >
            <span class="fa fa-forward"></span>
          </Link>

          <Link
            id="pervious"
            class="border-r border-gray-200 dark:border-gray-700 text-xl h-9 min-w-9 px-2 rounded-bl-lg focus:outline-none focus:bg-gray-50 hover:bg-gray-50 dark:hover:bg-gray-700"
            :href="disterbutes.links.prev"
          >
            <span class="fa fa-backward"></span>
          </Link>
        </div>
      </nav>
    </div>
  </LoadingView>
</template>

<script>
import Vue3PersianDatetimePicker from "vue3-persian-datetime-picker";
export default {
  props: {
    request: Object,
    disterbutes: Object,
    employees: Object,
  },
  data() {
    return {
      requirement: [],
      from: this.request.date || '',
      departments: null,
      department: this.request.department || '',
      employee: this.request.employee || '',
    };
  },
  components: {
    DatePicker: Vue3PersianDatetimePicker,
  },
  watch: {
    from(newValue, oldValue) {
      Nova.visit(`${Nova.config('path')}?page=1&date=${newValue}&department=${this.department}&employee=${this.employee}`);
    },
    department(newValue, oldValue) {
      Nova.visit(`${Nova.config('path')}?page=1&date=${this.from}&department=${newValue}&employee=${this.employee}`);
    },
    employee(newValue, oldValue) {
        Nova.visit(`${Nova.config('path')}?page=1&date=${this.from}&department=${this.department}&employee=${newValue}`);

    },
  },

  created() {},
  mounted() {
    Nova.request()
      .get("/nova-vendor/guest-report/departments")
      .then((response) => {
        this.departments = response.data;
      });
    Nova.request()
      .get(`nova-vendor/oil-report/requirement`)
      .then((res) => {
        this.requirement = res.data;
      })
      .catch((e) => {});

    Nova.addShortcut("ctrl+shift", (event) => {
      Nova.visit(Nova.config("path"));
    });
  },
  methods: {
    getDepartment(value) {
      this.department = value;
    },
    getEmployee(value) {
      this.employee = value;
    },
    handleClick(resourceId) {},
  },
  computed: {},
};
</script>

<style>
/* Scoped Styles */
.grid {
  display: grid;
}
.grid-cols-3 {
  grid-template-columns: repeat(3, minmax(0, 1fr));
}
</style>
