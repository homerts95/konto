<template>
  <div
    class="relative p-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 dark:bg-gray-800 sm:p-5 my-10"
  >
    <AlertDelete
      v-if="deleteAlertPage"
      @close="deleteAlertPage = false"
      @confirm="deletePageConfirm"
      :text="deleteAlertPageText"
    ></AlertDelete>

    <!-- Modal header -->
    <ModalHeader
      :heading="`Custom Page - ${customPageContentInfo.name}`"
      :url="$page.url"
    ></ModalHeader>
    <!-- Modal body -->
    <form action="#" @submit.prevent="">
      <div>
        <div class="grid gap-4 mb-4 grid-cols-1 md:grid-cols-2">
          <div class="pr-5 md:border-r">
            <p class="font-medium text-blue-600 dark:text-gray-400 my-4">{{useTrans('customPage.phone_number')}}</p>
            <div class="grid gap-4">
              <FormInput
                :label="useTrans('customPage.page_name')"
                :name="'name'"
                :type="'text'"
                :placeholder="useTrans('customPage.page_name')"
                v-model="customPageContentInfo.name"
                @change="changeNameToSlug()"
                :error="customPageContentsErrors.name"
              ></FormInput>
              <FormInput
                :label="useTrans('customPage.page_slug')"
                :name="'slug'"
                :type="'text'"
                @change="changeToSlug()"
                :placeholder="useTrans('customPage.page_slug')"
                v-model="customPageContentInfo.slug"
                :error="customPageContentsErrors.slug"
              ></FormInput>
              <FormInput
                :label="useTrans('customPage.page_link')"
                :name="'link'"
                :type="'text'"
                :placeholder="useTrans('customPage.page_link')"
                :readOnly="`{domain-name}/products/${customPageContentInfo.slug}`"
                :disabled="true"
              ></FormInput>
              <FormInput
                :label="useTrans('customPage.page_title')"
                :name="'title'"
                :type="'text'"
                :placeholder="useTrans('customPage.page_title')"
                v-model="customPageContentInfo.title"
                :error="customPageContentsErrors.title"
              ></FormInput>
              <FormTextArea
                :label="useTrans('customPage.page_subheading')"
                :name="'sub_title'"
                v-model="customPageContentInfo.sub_title"
                :row="'3'"
                :placeholder="useTrans('customPage.page_subheading')"
                :error="customPageContentsErrors.sub_title"
              >
              </FormTextArea>
            </div>
          </div>
          <div class="grid">
            <div>
              <p class="font-medium text-blue-600 dark:text-gray-400 my-4">
                custom Page:
              </p>
              <FormFileUploadSingle
                @fileChange="(file) => (image = file[0])"
                :label="useTrans('customPage.image')"
                :oldImageLink="oldImage"
                :name="'image'"
                :error="customPageContentsErrors.image"
              ></FormFileUploadSingle>
            </div>
            <FormTextEditor
              v-model="customPageContentInfo.content"
              :label="useTrans('customPage.main_content')"
              :name="'main_content'"
              :error="customPageContentsErrors.content"
            ></FormTextEditor>
          </div>
        </div>
      </div>

      <div>
        <Errors :errors="customPageContentsErrors ?? false"></Errors>
        <div class="flex items-center space-x-4">
          <Button
            @click.prevent="updateCustomPageContent()"
            :text="useTrans('customPage.update_page')"
            :disableFlash="false"
            :color="'blue'"
          ></Button>
          <Button
            @click.prevent="visitPage()"
            :text="useTrans('customPage.visit_page')"
            :color="'blue'"
            :disableFlash="true"
          ></Button>
          <Button
            @click.prevent="deletePage(customPageContentInfo.id)"
            :text="useTrans('customPage.delete_page')"
            :color="'red'"
            :disableFlash="true"
          ></Button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { router } from "@inertiajs/vue3";
export default {
  props: ["customPageContentsErrors", "customPageContent"],
  data() {
    return {
      customPageContentInfo: this.customPageContent,
      image: false,
      oldImage: this.customPageContent.image_url,
      errors: this.customPageContentsErrors ?? {},
      deleteAlertPage: false,
      deleteAlertPageText: "",
      deleteAlertPageId: null,
    };
  },
  methods: {
    slugify(str) {
      return str
        .toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, "")
        .replace(/[\s_-]+/g, "-")
        .replace(/^-+|-+$/g, "");
    },
    changeNameToSlug() {
      this.customPageContentInfo.slug = this.slugify(this.customPageContentInfo.name);
    },
    changeToSlug() {
      if (this.customPageContentInfo.slug !== "") {
        this.customPageContentInfo.slug = this.slugify(this.customPageContentInfo.slug);
      } else {
        this.customPageContentInfo.slug = this.slugify(this.customPageContentInfo.name);
      }
    },
    deletePage(id) {
      window.scrollTo(0, 0);
      this.deleteAlertPage = true;
      this.deleteAlertPageId = id;
      this.deleteAlertPageText = useTrans('are_you_sure');
      setTimeout(() => (this.deleteAlertPage = false), 5000);
    },
    deletePageConfirm() {
      router.delete(
        `/admin-dashboard/pages/custom-page-content/${this.deleteAlertPageId}`
      );
    },
    visitPage() {
      router.get(
        window.location.protocol +
          "//" +
          window.location.host +
          "/pages/" +
          this.customPageContentInfo.slug
      );
    },
    updateCustomPageContent() {
      if (this.image) {
        this.customPageContentInfo.image = this.image;
        this.oldImage = URL.createObjectURL(this.image);
      } else {
        delete this.customPageContentInfo.image;
      }
      this.customPageContentInfo._method = "put";
      router.post(
        `/admin-dashboard/pages/custom-page-content/${this.customPageContentInfo.id}`,
        this.customPageContentInfo,
        {
          preserveState: true,
          preserveScroll: true,
          only: ["customPageContent", "flash", "errors"],
        }
      );
    },
  },
};
</script>

<script setup>
import { onMounted, onUpdated } from "vue";
import { initFlowbite } from "flowbite";
import ModalHeader from "./ModalHeader.vue";
import FormTextArea from "../FormComponents/FormTextArea.vue";

import FormInput from "../FormComponents/FormInput.vue";
import FormFileUploadSingle from "../FormComponents/FormFileUploadSingle.vue";
import FormTextEditor from "../FormComponents/FormTextEditor.vue";

import Button from "../FormComponents/Button.vue";
import Errors from "../FormComponents/Errors.vue";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import AlertDelete from "./AlertDelete.vue";
import {useTrans} from "../../composables/trans";

onMounted(() => {
  initFlowbite();
});
onUpdated(() => {
  initFlowbite();
});
</script>
