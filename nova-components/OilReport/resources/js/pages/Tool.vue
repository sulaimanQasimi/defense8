<template>
  <LoadingView :loading="initialLoading">
    <div>
      <Head :title="__('Oil Report')" />
      <report-header />
      <div class="flex">
        <date-picker range clearable color="#e91e63" v-model="from" style="margin: 5px" />
        <select
          v-model="department"
          class="w-full block form-control form-control-bordered form-input"
          style="margin: 5px"
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
        <select
          v-model="employee"
          class="w-full block form-control form-control-bordered form-input"
          style="margin: 5px"
        >
          <option value="" selected>{{ __("Employee") }}</option>
          <option :value="employee.id" :key="employee.id" v-for="employee in employees">
            {{ employee.name }}
          </option>
        </select>
      </div>
    </div>
    <div class="mb-2">
      <a
        class="border text-left dark:text-white appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center shadow h-9 px-3 bg-primary-500 border-primary-500 hover:[&:not(:disabled)]:bg-primary-400 hover:[&:not(:disabled)]:border-primary-400 text-white dark:text-gray-900 mt-2 mx-2"
        v-bind:href="
          disterbute +
          '?file=excel&date=' +
          from +
          '&department=' +
          department +
          '&employee=' +
          employee
        "
        href="#"
        target="_blank"
      >
        <span class="dark:text-white fas fa-file-excel mx-2"></span>
        {{ __("Create Disterbuted Oil Report") }}
      </a>
      <a
        class="border text-left dark:text-white appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center shadow h-9 px-3 bg-primary-500 border-primary-500 hover:[&:not(:disabled)]:bg-primary-400 hover:[&:not(:disabled)]:border-primary-400 text-white dark:text-gray-900 mt-2 mx-2"
        v-bind:href="importOil + '?file=excel&date=' + from"
        href="#"
        target="_blank"
      >
        <span class="dark:text-white fas fa-file-excel mx-2"></span>
        {{ __("Create Imported Oil Report") }}
      </a>
      <a
        class="border text-left dark:text-white appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center shadow h-9 px-3 bg-primary-500 border-primary-500 hover:[&:not(:disabled)]:bg-primary-400 hover:[&:not(:disabled)]:border-primary-400 text-white dark:text-gray-900 mt-2 mx-2"
        v-bind:href="
          disterbute +
          '?&date=' +
          from +
          '&department=' +
          department +
          '&employee=' +
          employee
        "
        href="#"
        target="_blank"
      >
        <span class="dark:text-white fas fa-file-pdf mx-2"></span>
        {{ __("Create Disterbuted Oil Report") }}
      </a>
      <a
        class="border text-left dark:text-white appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center shadow h-9 px-3 bg-primary-500 border-primary-500 hover:[&:not(:disabled)]:bg-primary-400 hover:[&:not(:disabled)]:border-primary-400 text-white dark:text-gray-900 mt-2 mx-2"
        v-bind:href="importOil + '?&date=' + from"
        href="#"
        target="_blank"
      >
        <span class="dark:text-white fas fa-file-pdf mx-2"></span>
        {{ __("Create Imported Oil Report") }}
      </a>
    </div>
    <div class="bg-white px-4 py-8 dark:bg-gray-800">
      <table class="w-full divide-y divide-gray-100 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-800">
          <tr>
            <th
              style="border: 1px solid #18a2f3"
              class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2 text-black dark:text-white"
            >
              #
            </th>

            <th
              style="border: 1px solid #18a2f3"
              class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2 text-black dark:text-white"
              v-html="__('Department')"
            />

            <th
              style="border: 1px solid #18a2f3"
              class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2 text-black dark:text-white"
              v-html="__('Register No')"
            />
            <th
              style="border: 1px solid #18a2f3"
              class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2 text-black dark:text-white"
              v-html="__('Name')"
            />
            <th
              style="border: 1px solid #18a2f3"
              class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2 text-black dark:text-white"
              v-html="__('Father Name')"
            />
            <th
              style="border: 1px solid #18a2f3"
              class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2 text-black dark:text-white"
              v-html="__('Oil Type')"
            />
            <th
              style="border: 1px solid #18a2f3"
              class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2 text-black dark:text-white"
              v-html="__('Monthly Rate')"
            />
            <th
              style="border: 1px solid #18a2f3"
              class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2 text-black dark:text-white"
              v-html="__('Oil Amount')"
            />
            <th
              style="border: 1px solid #18a2f3"
              class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2 text-black dark:text-white"
              v-html="__('Date')"
            />
            <th
              style="border: 1px solid #18a2f3"
              class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2 text-black dark:text-white"
            ></th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
          <tr class="group" v-for="(oil,index) in disterbutes.data">
            <td
              style="border: 1px solid #18a2f3"
              class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              <div class="items-center justify-center flex text-center">
                <p class="text-center" v-text="index+1" />
              </div>
            </td>
            <td
              style="border: 1px solid #18a2f3"
              class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              <div class="items-center justify-center flex text-center">
                <p class="text-center" v-text="oil.department" />
              </div>
            </td>
            <td
              style="border: 1px solid #18a2f3"
              class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              <div class="items-center justify-center flex text-center">
                <p class="text-center" v-text="oil.registare_no" />
              </div>
            </td>
            <td
              style="border: 1px solid #18a2f3"
              class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              <div class="items-center justify-center flex text-center">
                <p class="text-center" v-text="oil.full_name" />
              </div>
            </td>
            <td
              style="border: 1px solid #18a2f3"
              class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              <div class="items-center justify-center flex text-center">
                <p class="text-center" v-text="oil.father_name" />
              </div>
            </td>
            <td
              style="border: 1px solid #18a2f3"
              class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              <div class="items-center justify-center flex text-center">
                <p class="text-center" v-text="oil.oil_type" />
              </div>
            </td>
            <td
              style="border: 1px solid #18a2f3"
              class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              <div class="items-center justify-center flex text-center">
                <p class="text-center" v-text="oil.monthly_rate" />
              </div>
            </td>
            <td
              style="border: 1px solid #18a2f3"
              class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              <div class="items-center justify-center flex text-center">
                <p class="text-center" v-text="oil.oil_amount" />
              </div>
            </td>
            <td
              style="border: 1px solid #18a2f3"
              class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              <div class="items-center justify-center flex text-center">
                <p class="text-center" v-text="oil.date" />
              </div>
            </td>
            <td
              style="border: 1px solid #18a2f3"
              class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              <Link
                class="items-center justify-center flex text-center"
                title=""
                :href="'resources/oil-disterbutions/' + oil.id"
              >
                <span class="fas fa-eye fa-xl text-blue-900"></span>
              </Link>
            </td>
          </tr>
        </tbody>
      </table>

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
    </div>
  </LoadingView>
</template>

<script>
import Vue3PersianDatetimePicker from "vue3-persian-datetime-picker";
export default {
  emits: ["get_date"],
  props: {
    selectedDepartment: String,
    disterbutes: Object,
    date: String,
    employees: Object,
    selectedEmployee: Number,
  },
  data() {
    return {
      path: Nova.config("path"),
      from: this.date,
      importOil: Nova.config("import"),
      disterbute: Nova.config("disterbute"),
      initialLoading: false,
      departments: null,
      department: this.selectedDepartment,
      employee: this.selectedEmployee,
    };
  },
  components: {
    DatePicker: Vue3PersianDatetimePicker,
  },
  watch: {
    from(newValue, oldValue) {
      Nova.visit(
        this.path +"?page=1&date=" +newValue +"&department=" +this.department +"&employee=" +this.employee,
        {
            onFinish: () => Nova.success(this.__('Filter Applied')),
        }
      );
    },
    department(newValue, oldValue) {
      Nova.visit(
        this.path + "?page=1&date=" + this.from + "&department=" + this.department,
        {
            onFinish: () => Nova.success(this.__('Filter Applied')),
        }
      );
    },
    employee(newValue, oldValue) {
      Nova.visit(
        this.path +
          "?page=1&date=" +
          this.from +
          "&department=" +
          this.department +
          "&employee=" +
          this.employee,
        {
          onFinish: () => Nova.success(this.__('Filter Applied')),
        }
      );
    },
  },
  mounted() {

    Nova.addShortcut("ctrl+shift", (event) => {
      Nova.visit(this.path, {
        onFinish: () => Nova.success(this.__('Page Reloaded')),
      });
    });

    Nova.request()
      .get("/nova-vendor/guest-report/departments")
      .then((response) => {
        this.departments = response.data;
        Nova.success(this.__('Data Recieved'))
      });
  },
  methods: {},
  computed: {},
};
</script>

<style>
/* Scoped Styles */
.grid {
  display: grid;
}
.grid-cols-4 {
  grid-template-columns: repeat(3, minmax(0, 1fr));
}
</style>
