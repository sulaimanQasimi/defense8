<template>
  <div>
    <div
      class="space-y-2 md:flex @md/modal:flex md:flex-row @md/modal:flex-row md:space-y-0 @md/modal:space-y-0 py-5"
      index="5"
    >
      <div class="w-full md:mt-2 md:w-1/5 @md/modal:w-1/5">
        <label class="inline-block leading-tight space-x-1" v-html="__('Month')" />
      </div>
      <div class="w-full space-y-2 md:w-3/5 @md/modal:w-3/5">
        <!-- Search Input --><!-- Select Input Field -->
        <div class="flex relative w-full">
          <select
            @change="handleChange"
            class="w-full block form-control form-control-bordered form-input"
          >
            <option disabled="" value="" selected >یک گزینه را انتخاب کنید</option>

            <option value="1" v-html="__('Hamal')"></option>
            <option value="2" v-html="__('Thour')"></option>
            <option value="3" v-html="__('Jawza')"></option>
            <option value="4" v-html="__('Sarathan')"></option>
            <option value="5" v-html="__('Asad')"></option>
            <option value="6" v-html="__('Sunbulah')"></option>
            <option value="7" v-html="__('Mizan')"></option>
            <option value="8" v-html="__('Aqrab')"></option>
            <option value="9" v-html="__('Qous')"></option>
            <option value="10" v-html="__('Jadi')"></option>
            <option value="11" v-html="__('Dalwa')"></option>
            <option value="12" v-html="__('Hod')"></option>
          </select>
          <svg
            class="shrink-0 text-gray-700 pointer-events-none absolute right-[11px] top-[15px]"
            xmlns="http://www.w3.org/2000/svg"
            width="10"
            height="6"
            viewBox="0 0 10 6"
          >
            <path
              class="fill-current"
              d="M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z"
            ></path>
          </svg>
        </div>
        <!--v-if--><!--v-if-->
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  checked: { type: Boolean, default: false },
  disabled: { type: Boolean, default: false },
})

const emit = defineEmits(['input'])

const handleChange = e => emit('input', e)
</script>
