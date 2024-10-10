<template>
  <Heading class="mb-6" v-text="__('Attendance Timer Settings')" />

  <Card>
    <div class="grid md:grid-cols-3 sm:grid-cols-1 gap-3">
      <div
        class="space-y-2 md:flex @md/modal:flex md:flex-row @md/modal:flex-row md:space-y-0 @md/modal:space-y-0 py-5"
        index="5"
      >
        <div
          class="w-full px-6 md:mt-2 @md/modal:mt-2 md:px-8 @md/modal:px-8 md:w-1/5 @md/modal:w-1/5"
        >
          <FormLabel label-for="year" class="space-x-1">
            <span>
              {{ __("Start") }}
            </span>
          </FormLabel>
        </div>
        <div
          class="w-full space-y-2 px-6 md:px-8 @md/modal:px-8 md:w-3/5 @md/modal:w-3/5"
        >
          <input
            dir="ltr"
            v-model="start"
            class="w-full form-control form-input form-control-bordered"
          />
        </div>
      </div>

      <div
        class="space-y-2 md:flex @md/modal:flex md:flex-row @md/modal:flex-row md:space-y-0 @md/modal:space-y-0 py-5"
        index="5"
      >
        <div
          class="w-full px-6 md:mt-2 @md/modal:mt-2 md:px-8 @md/modal:px-8 md:w-1/5 @md/modal:w-1/5"
        >
          <FormLabel label-for="year" class="space-x-1">
            <span>
              {{ __("End") }}
            </span>
          </FormLabel>
        </div>
        <div
          class="w-full space-y-2 px-6 md:px-8 @md/modal:px-8 md:w-3/5 @md/modal:w-3/5"
        >
          <input
            dir="ltr"
            v-model="end"
            class="w-full form-control form-input form-control-bordered"
          />
        </div>
      </div>
    </div>
  </Card>
</template>

<script>
export default {
  data() {
    return {
      start: "",
      end: "",
    };
  },
  mounted() {
    this.initailize();
  },
  watch: {
    start(newValue, oldValue) {
      Nova.$progress.start();

      Nova.request().get(`/nova-vendor/app-setting/attendance/save`, {
        params: {
          start: this.start,
          end: this.end,
        },
      });
      Nova.$progress.done();
    },
    end(newValue, oldValue) {
      Nova.$progress.start();

      Nova.request().get(`/nova-vendor/app-setting/attendance/save`, {
        params: {
          start: this.start,
          end: this.end,
        },
      });

      Nova.$progress.done();
    },
  },
  methods: {
    initailize() {
      Nova.request()
        .get(`/nova-vendor/app-setting/attendance/`)
        .then(({ data: { start, end } }) => {
          this.start = start;
          this.end = end;
        })
        .catch((e) => {});
    },
  },
};
</script>
