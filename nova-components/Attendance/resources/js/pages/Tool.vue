<template>
  <div>
    <Head title="Attendance" />

    <Heading class="mb-6">Attendance</Heading>

    <Card class="flex flex-col items-center justify-center" style="min-height: 300px">
      <table
        class="w-full divide-y divide-gray-100 dark:divide-gray-700"
        dusk="resource-table"
      >
        <thead class="bg-gray-50 dark:bg-gray-800">
          <tr>
            <th
              class="px-6 text-center border-r border-gray-200 dark:border-gray-600 uppercase text-gray-500 text-xxs py-2"
              v-text="__('Registre No')"
            />
            <th
              class="px-6 text-center border-r border-gray-200 dark:border-gray-600 uppercase text-gray-500 text-xxs py-2"
              v-text="__('Name')"
            />
            <th
              class="px-6 text-center border-r border-gray-200 dark:border-gray-600 uppercase text-gray-500 text-xxs py-2"
              v-text="__('Last Name')"
            />
            <th
              class="px-6 text-center border-r border-gray-200 dark:border-gray-600 uppercase text-gray-500 text-xxs py-2"
              v-text="__('Father Name')"
            />
            <th
              class="px-6 text-center border-r border-gray-200 dark:border-gray-600 uppercase text-gray-500 text-xxs py-2"
              v-text="__('Grand Father Name')"
            />
            <th
              class="px-6 text-center border-r border-gray-200 dark:border-gray-600 uppercase text-gray-500 text-xxs py-2"
              v-text="__('Date')"
            />
            <th
              class="px-6 text-center border-r border-gray-200 dark:border-gray-600 uppercase text-gray-500 text-xxs py-2"
              v-text="__('Enter')"
            />
            <th
              class="px-6 text-center border-r border-gray-200 dark:border-gray-600 uppercase text-gray-500 text-xxs py-2"
              v-text="__('Exit')"
            />         <th
              class="px-6 text-center border-r border-gray-200 dark:border-gray-600 uppercase text-gray-500 text-xxs py-2"
              v-text="__('State')"
            />
            <th
              class="px-6 text-center border-r border-gray-200 dark:border-gray-600 uppercase text-gray-500 text-xxs py-2"
            />
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
          <tr v-for="employee in employees">
            <td
              class="px-6 text-center px-2 py-2 whitespace-nowrap dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              {{ employee.registare_no }}
            </td>
            <td
              class="px-6 text-center px-2 py-2 whitespace-nowrap dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              {{ employee.name }}
            </td>
            <td
              class="px-6 text-center px-2 py-2 whitespace-nowrap dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              {{ employee.last_name }}
            </td>
            <td
              class="px-6 text-center px-2 py-2 whitespace-nowrap dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              {{ employee.father_name }}
            </td>
            <td
              class="px-6 text-center px-2 py-2 whitespace-nowrap dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              {{ employee.grand_father_name }}
            </td>
            <td
              class="px-6 text-center px-2 py-2 whitespace-nowrap dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              {{ employee.date }}
            </td>
            <td
              class="px-6 text-center px-2 py-2 whitespace-nowrap dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              {{ employee.enter }}
            </td>
            <td
              class="px-6 text-center px-2 py-2 whitespace-nowrap dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              {{ employee.exit }}
            </td>
            <td
              class="px-6 text-center px-2 py-2 whitespace-nowrap dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              {{ employee.stateLabel }}
            </td>
            <td
              class="px-6 text-center px-2 py-2 whitespace-nowrap dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            >
              <BasicButton
                v-if="!employee.state"
                @click="checker('p', employee.id)"
                class="font-bold text-white hover:text-gray-300 hover:bg-green-300 bg-green-500"
                >{{ __("Present") }}</BasicButton
              >
              <BasicButton
                v-if="!employee.state"
                @click="checker('u', employee.id)"
                class="font-bold text-white hover:text-gray-300 hover:bg-red-300 bg-red-500"
                >{{ __("Upsent") }}</BasicButton
              >
              <BasicButton
                v-if="employee.state == 'P' && !employee.exit"
                @click="checker('e', employee.id)"
                class="font-bold text-white hover:text-gray-300 hover:bg-red-300 bg-red-500"
                >{{ __("Exit") }}</BasicButton
              >

            </td>
          </tr>
        </tbody>
      </table>
    </Card>
  </div>
</template>

<script>
export default {
  data() {
    return {
      employees: [],
    };
  },
  mounted() {
    this.initailized();
    //
  },
  methods: {
    initailized() {
      Nova.request()
        .get(`/nova-vendor/attendance/`)
        .then(({ data: { employees, department } }) => {
          console.log(employees);
          this.employees = employees;
        })
        .catch((e) => {});
    },
    checker(state, id) {
      console.log(state, id);
    },
  },
};
</script>

<style>
/* Scoped Styles */
</style>
