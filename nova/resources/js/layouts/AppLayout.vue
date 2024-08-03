<template>
  <div id="nova">
    <MainHeader />

    <!-- Content -->
    <div dusk="content">
      <div
        class="hidden lg:block lg:absolute left-0 bottom-0 lg:top-[56px] lg:bottom-auto w-60 px-3 mx-2 my-6 py-8 h-auto dark:bg-gray-900 bg-white  ltr:border-r rtl:border-l rounded-md border-blue-300"
      >
        <!-- The Main Menu on desktop gets extra padding to keep the bottom of the sidebar from feeling crowded -->
        <MainMenu class="pb-24" data-screen="desktop" />
      </div>
      <div class="p-4 md:py-8 md:px-12 lg:ml-60 space-y-8">
        <Breadcrumbs v-if="breadcrumbsEnabled" />
        <FadeTransition>
          <slot />
        </FadeTransition>
      </div>
    </div>
  </div>
</template>

<script>
import MainHeader from "@/layouts/MainHeader";
import Footer from "@/layouts/Footer";

export default {
  components: {
    MainHeader,
    Footer,
  },

  mounted() {
    Nova.$on("error", this.handleError);
    Nova.$on("token-expired", this.handleTokenExpired);
  },

  beforeUnmount() {
    Nova.$off("error", this.handleError);
    Nova.$off("token-expired", this.handleTokenExpired);
  },

  methods: {
    handleError(message) {
      Nova.error(message);
    },

    handleTokenExpired() {
      // @TODO require Nova._createToast() to support action with link.
      Nova.$toasted.show(this.__("Sorry, your session has expired."), {
        action: {
          onClick: () => Nova.redirectToLogin(),
          text: this.__("Reload"),
        },
        duration: null,
        type: "error",
      });

      setTimeout(() => {
        Nova.redirectToLogin();
      }, 5000);
    },
  },

  computed: {
    breadcrumbsEnabled() {
      return Nova.config("breadcrumbsEnabled");
    },
  },
};
</script>
