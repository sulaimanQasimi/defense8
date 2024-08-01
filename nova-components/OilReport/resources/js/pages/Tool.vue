<template>
  <LoadingView :loading="initialLoading">
    <div>
      <Head :title="__('Oil Report')" />
      <report-header />

      <date-picker range clearable color="#e91e63" v-model="from" />
    </div>
    <div class="mb-2">
      <a
        class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center shadow h-9 px-3 bg-primary-500 border-primary-500 hover:[&:not(:disabled)]:bg-primary-400 hover:[&:not(:disabled)]:border-primary-400 text-white dark:text-gray-900 mt-2 mx-2"
        v-bind:href="disterbute + '?file=excel&date=' + from"
        href="#"
        target="_blank"
      >
        <span class="fas fa-file-excel mx-2"></span>
        {{ __("Create Disterbuted Oil Report") }}
      </a>
      <a
        class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center shadow h-9 px-3 bg-primary-500 border-primary-500 hover:[&:not(:disabled)]:bg-primary-400 hover:[&:not(:disabled)]:border-primary-400 text-white dark:text-gray-900 mt-2 mx-2"
        v-bind:href="importOil + '?file=excel&date=' + from"
        href="#"
        target="_blank"
      >
        <span class="fas fa-file-excel mx-2"></span>
        {{ __("Create Imported Oil Report") }}
      </a>
      <a
        class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center shadow h-9 px-3 bg-primary-500 border-primary-500 hover:[&:not(:disabled)]:bg-primary-400 hover:[&:not(:disabled)]:border-primary-400 text-white dark:text-gray-900 mt-2 mx-2"
        v-bind:href="disterbute + '?&date=' + from"
        href="#"
        target="_blank"
      >
        <span class="fas fa-file-pdf mx-2"></span>
        {{ __("Create Disterbuted Oil Report") }}
      </a>
      <a
        class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center shadow h-9 px-3 bg-primary-500 border-primary-500 hover:[&:not(:disabled)]:bg-primary-400 hover:[&:not(:disabled)]:border-primary-400 text-white dark:text-gray-900 mt-2 mx-2"
        v-bind:href="importOil + '?&date=' + from"
        href="#"
        target="_blank"
      >
        <span class="fas fa-file-pdf mx-2"></span>
        {{ __("Create Imported Oil Report") }}
      </a>
    </div>
    <div class="bg-white px-4 py-8">
      <table class="w-full divide-y divide-gray-100 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-800">
          <tr>
            <th
              style="border: 1px solid #18a2f3; color: black"
              class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2"
            >
              #
            </th>

            <th
              style="border: 1px solid #18a2f3; color: black"
              class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2"
              v-html="__('Register No')"
            />
            <th
              style="border: 1px solid #18a2f3; color: black"
              class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2"
              v-html="__('Name')"
            />
            <th
              style="border: 1px solid #18a2f3; color: black"
              class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2"
              v-html="__('Father Name')"
            />
            <th
              style="border: 1px solid #18a2f3; color: black"
              class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2"
              v-html="__('Oil Type')"
            />
            <th
              style="border: 1px solid #18a2f3; color: black"
              class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2"
              v-html="__('Monthly Rate')"
            />
            <th
              style="border: 1px solid #18a2f3; color: black"
              class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2"
              v-html="__('Oil Amount')"
            />
            <th
              style="border: 1px solid #18a2f3; color: black"
              class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2"
              v-html="__('Date')"
            />
            <th
              style="border: 1px solid #18a2f3; color: black"
              class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2"
            ></th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
          <tr class="group" v-for="oil in disterbutes.data">
            <td
              style="border: 1px solid #18a2f3; color: black"
              class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              <div class="items-center justify-center flex text-center">
                <p class="text-center" v-text="oil.id" />
              </div>
            </td>
            <td
              style="border: 1px solid #18a2f3; color: black"
              class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              <div class="items-center justify-center flex text-center">
                <p class="text-center" v-text="oil.registare_no" />
              </div>
            </td>
            <td
              style="border: 1px solid #18a2f3; color: black"
              class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              <div class="items-center justify-center flex text-center">
                <p class="text-center" v-text="oil.full_name" />
              </div>
            </td>
            <td
              style="border: 1px solid #18a2f3; color: black"
              class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              <div class="items-center justify-center flex text-center">
                <p class="text-center" v-text="oil.father_name" />
              </div>
            </td>
            <td
              style="border: 1px solid #18a2f3; color: black"
              class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              <div class="items-center justify-center flex text-center">
                <p class="text-center" v-text="oil.oil_type" />
              </div>
            </td>
            <td
              style="border: 1px solid #18a2f3; color: black"
              class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              <div class="items-center justify-center flex text-center">
                <p class="text-center" v-text="oil.monthly_rate" />
              </div>
            </td>
            <td
              style="border: 1px solid #18a2f3; color: black"
              class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              <div class="items-center justify-center flex text-center">
                <p class="text-center" v-text="oil.oil_amount" />
              </div>
            </td>
            <td
              style="border: 1px solid #18a2f3; color: black"
              class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              <div class="items-center justify-center flex text-center">
                <p class="text-center" v-text="oil.date" />
              </div>
            </td>
            <td
              style="border: 1px solid #18a2f3; color: black"
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
    disterbutes: Object,
    date: String,
  },
  data() {
    return {
      path: Nova.config("path"),
      from: this.date,
      importOil: Nova.config("import"),
      disterbute: Nova.config("disterbute"),
      initialLoading: false,
    };
  },
  components: {
    DatePicker: Vue3PersianDatetimePicker,
  },
  watch: {
    from(newValue, oldValue) {
      Nova.visit(this.path + "?page=1&date=" + newValue);
    },
  },
  mounted() {},
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
