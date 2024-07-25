<template>

  <div class="mt-6 bg-white px-3 py-4 rounded-2xl">
    <div v-html="__(title)"></div>
    <div class="grid grid-cols-4 gap-3">
      <div>
        <div
          class="space-y-2 md:flex @md/modal:flex md:flex-row @md/modal:flex-row md:space-y-0 @md/modal:space-y-0 py-5"
          index="5"
        >
          <div class="w-full md:mt-2 md:w-1/5 @md/modal:w-1/5">
            <label class="inline-block leading-tight space-x-1" v-html="__('Year')" />
          </div>
          <div class="w-full space-y-2 md:w-3/5 @md/modal:w-3/5">
            <!-- Search Input --><!-- Select Input Field -->
            <div class="flex relative w-full">
              <select

              @change="$emit('year',$event)"
                id="enter_gate"
                dusk="enter_gate"
                class="w-full block form-control form-control-bordered form-input"
              >
                <option disabled="" value="" selected >یک گزینه را انتخاب کنید</option>

                <option v-for="year in years" v-html="year" v-bind:value="year" />
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
      <month-field @change="$emit('month',$event)"/>
      <div>
        <div
          class="space-y-2 md:flex @md/modal:flex md:flex-row @md/modal:flex-row md:space-y-0 @md/modal:space-y-0 py-5"
          index="5"
        >
          <div class="w-full md:mt-2 md:w-1/5 @md/modal:w-1/5">
            <label class="inline-block leading-tight space-x-1" v-html="__('Day')" />
          </div>
          <div class="w-full space-y-2 md:w-3/5 @md/modal:w-3/5">
            <!-- Search Input --><!-- Select Input Field -->
            <div class="flex relative w-full">
              <select
                @change="$emit('day',$event)"
                id="enter_gate"
                dusk="enter_gate"
                class="w-full block form-control form-control-bordered form-input"
              >
                <option disabled="" value="" selected >یک گزینه را انتخاب کنید</option>

                <option v-for="day in days" v-html="day" v-bind:value="day" />
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
    </div>
  </div>
</template>
<script>

export default {

  emits: ['month','year','day'],
  props: {
    title: String,
    years: Object,
    days: Object,
  },
  mounted() {
    this.$parent.$emit('get_date')
  },
  methods: {
    li(value){
        console.log(value)

    }
  },
};
</script>
