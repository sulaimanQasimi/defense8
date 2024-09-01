<template>
  <div>
    <Head :title="__('App Setting')" />

    <Heading class="mb-6" v-text="__('Login Settings')" />

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
                {{ __("Department") }}
              </span>
            </FormLabel>
          </div>
          <div
            class="w-full space-y-2 px-6 md:px-8 @md/modal:px-8 md:w-3/5 @md/modal:w-3/5"
          >
            <input
              v-model="title"
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
                {{ __("Title") }}
              </span>
            </FormLabel>
          </div>
          <div
            class="w-full space-y-2 px-6 md:px-8 @md/modal:px-8 md:w-3/5 @md/modal:w-3/5"
          >
            <input
              v-model="subtitle"
              class="w-full form-control form-input form-control-bordered"
            />
          </div>
        </div>
      </div>
    </Card>
  </div>
</template>

<script>
export default {
  data() {
    return {
      title: "",
      subtitle: "",
    };
  },
  mounted() {
    this.initailize();

  },
  watch: {
    title(newValue, oldValue) {
      Nova.$progress.start();

      Nova.request().get(`/nova-vendor/app-setting/setter/`, {
        params: {
          title: this.title,
          subtitle: this.subtitle,
        },
      });

      Nova.$progress.done();
    },
    subtitle(newValue, oldValue) {
      Nova.$progress.start();

      Nova.request().get(`/nova-vendor/app-setting/setter/`, {
        params: {
          title: this.title,
          subtitle: this.subtitle,
        },
      });

      Nova.$progress.done();
    },
  },
  methods: {
    initailize() {
      Nova.request()
        .get(`/nova-vendor/app-setting/requirement`)
        .then(({ data: { title, subtitle } }) => {
          this.title = title;
          this.subtitle = subtitle;
        })
        .catch((e) => {});
    },
  },
};
</script>

<style>
/* Scoped Styles */
</style>
