<template>
  <div class="bg-white px-4 py-8" v-if="guests">
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
            v-html="__('Name')"
          />
          <th
            style="border: 1px solid #18a2f3; color: black"
            class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2"
            v-html="__('Last Name')"
          />

          <th
            style="border: 1px solid #18a2f3; color: black"
            class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2"
            v-html="__('Job')"
          />

          <th
            style="border: 1px solid #18a2f3; color: black"
            class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2"
            v-html="__('Address')"
          />
          <th
            style="border: 1px solid #18a2f3; color: black"
            class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2"
            v-html="__('Host')"
          />

          <th
            style="border: 1px   solid #18a2f3; color: black"
            class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2"
            v-html="__('Department')"
          />
          <th
            style="border: 1px solid #18a2f3; color: black"
            class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2"
            v-html="__('Job')"
          />
          <th
            style="border: 1px solid #18a2f3; color: black"
            class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2"
            v-html="__('Address')"
          />
          <th
            style="border: 1px solid #18a2f3; color: black"
            class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2"
            v-html="__('Phone')"
          />
          <th
            style="border: 1px solid #18a2f3; color: black"
            class="w-[1%] white-space-nowrap uppercase text-xxs tracking-wide pl-5 pr-2 py-2"
            v-html="__('Enter')"
          />
          </tr>
      </thead>

      <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
        <tr class="group" v-for="guest in guests.data">
          <td
            style="border: 1px solid #18a2f3; color: black"
            class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
          >
            <div class="items-center justify-center flex text-center">
              <p class="text-center" v-text="guest.id" />
            </div>
          </td>
          <td
            style="border: 1px solid #18a2f3; color: black"
            class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
          >
            <div class="items-center justify-center flex text-center">
              <p class="text-center" v-text="guest.name" />
            </div>
          </td>
          <td
            style="border: 1px solid #18a2f3; color: black"
            class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
          >
            <div class="items-center justify-center flex text-center">
              <p class="text-center" v-text="guest.last_name" />
            </div>
          </td>
          <td
            style="border: 1px solid #18a2f3; color: black"
            class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
          >
            <div class="items-center justify-center flex text-center">
              <p class="text-center" v-text="guest.career" />
            </div>
          </td>
          <td
            style="border: 1px solid #18a2f3; color: black"
            class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
          >
            <div class="items-center justify-center flex text-center">
              <p class="text-center" v-text="guest.address" />
            </div>
          </td>
          <td
            style="border: 1px solid #18a2f3; color: black"
            class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
          >
            <div class="items-center justify-center flex text-center">
              <p class="text-center" v-text="guest.host.head_name" />
            </div>
          </td>
          <td
            style="border: 1px solid #18a2f3; color: black"
            class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
          >
            <div class="items-center justify-center flex text-center">
              <p class="text-center" v-text="guest.host.department" />
            </div>
          </td>
          <td
            style="border: 1px solid #18a2f3; color: black"
            class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
          >
            <div class="items-center justify-center flex text-center">
              <p class="text-center" v-text="guest.host.job" />
            </div>
          </td>
          <td
            style="border: 1px solid #18a2f3; color: black"
            class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
          >
            <div class="items-center justify-center flex text-center">
              <p class="text-center" v-text="guest.host.address" />
            </div>
          </td>

          <td
            style="border: 1px solid #18a2f3; color: black"
            class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
          >
            <div class="items-center justify-center flex text-center">
              <p class="text-center" v-text="guest.host.phone" />
            </div>
          </td>
          <td
            style="border: 1px solid #18a2f3; color: black"
            class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
          >
            <div class="items-center justify-center flex text-center">
              <p class="text-center" v-text="guest.registered_at" />
            </div>
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
            :href="guests.links.next"
          >
            <span class="fa fa-forward"></span>
          </Link>
          <!-- Back -->
          <Link
            id="pervious"
            class="border-r border-gray-200 dark:border-gray-700 text-xl h-9 min-w-9 px-2 rounded-bl-lg focus:outline-none focus:bg-gray-50 hover:bg-gray-50 dark:hover:bg-gray-700"
            :href="guests.links.prev"
          >
            <span class="fa fa-backward"></span>
          </Link>
        </div>
      </nav>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    guests: Object,
  },
};
</script>
