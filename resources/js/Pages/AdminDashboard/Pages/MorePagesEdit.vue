<template>
  <EditSectionLayout>
    <Breadcrump :links="{ Pages: null, 'More Pages': null }"></Breadcrump>
    <WebsiteContentsCustomPage
      v-for="customPage in customPages"
      :key="customPage.id"
      :customPageContent="customPage"
      :customPageContentsErrors="errors[`customPagesErrors_${customPage.id}`] ?? {}"
    ></WebsiteContentsCustomPage>
    <Button
      @click.prevent="addNewCustomPage()"
      :text="'+' + useTrans('pages.new_custom_page')"
      :color="'blue'"
      :fullWidth="true"
    ></Button>
  </EditSectionLayout>
  <!-- Modal content -->
</template>

<script>
import { router } from "@inertiajs/vue3";
export default {
  props: ["errors", "customPages"],
  data() {
    return {
      customPagesList: this.customPages,
    };
  },
  methods: {
    addNewCustomPage() {
      var newCustomPage = {};
      var pageId =
        Math.floor(Math.random() * (10000 - this.customPages.length)) +
        this.customPages.length;
      newCustomPage["name"] = " New Page-" + pageId;
      newCustomPage["slug"] = "new-page-" + pageId;
      newCustomPage["title"] = "New Page Title";
      router.post(`/admin-dashboard/pages/more-pages-store`, newCustomPage, {
        preserveState: true,
        preserveScroll: true,
        only: ["customPages", "flash", "errors"],
      });
    },
  },
};
</script>

<script setup>
import { onMounted, onUpdated } from "vue";
import { initFlowbite } from "flowbite";

import Breadcrump from "../../../Shared/AdminDashboardComponents/Breadcrump.vue";
import EditSectionLayout from "../../../Shared/AdminDashboardComponents/EditSectionLayout.vue";
import Button from "../../../Shared/FormComponents/Button.vue";

import WebsiteContentsCustomPage from "../../../Shared/AdminDashboardComponents/WebsiteContentsCustomPage.vue";
import { router } from "@inertiajs/vue3";
import {useTrans} from "../../../composables/trans";

onMounted(() => {
  initFlowbite();
});
onUpdated(() => {
  initFlowbite();
});
</script>
