<template>
  <div
    class="relative p-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 dark:bg-gray-800 sm:p-5 my-10"
  >
    <!-- Modal header -->
    <ModalHeader :heading="'About Page'" :url="$page.url"></ModalHeader>
    <!-- Modal body -->
    <form action="#" @submit.prevent="">
      <div>
        <div class="grid gap-4 mb-4 grid-cols-1 md:grid-cols-2">
          <div class="pr-5 md:border-r">
            <p class="font-medium text-blue-600 dark:text-gray-400 my-4">Text Contents</p>
            <div class="grid gap-4">
              <FormInput
                  :placeholder="useTrans('about.page_heading')"
                :name="'heading'"
                :type="'text'"
                :placeholder="useTrans('about.page_heading')"
                v-model="aboutPageContentInfo.aboutHeading"
                :error="this.aboutPageContentsErrors.aboutHeading"
              ></FormInput>
              <FormTextArea
                  :placeholder="useTrans('about.sub_heading')"
                :name="'sub_heading'"
                v-model="aboutPageContentInfo.aboutSubHeading"
                :row="'3'"
                :placeholder="useTrans('about.page_sub_heading_context')"
                :error="this.aboutPageContentsErrors.aboutSubHeading"
              >
              </FormTextArea>

              <FormTextEditor
                v-model="aboutPageContentInfo.aboutText"
                :label= "useTrans('about.main_paragraph')"
                :name="'text'"
                :error="this.aboutPageContentsErrors.aboutText"
              ></FormTextEditor>
              <!-- <QuillEditor
                  theme="snow"
                  v-model:content="aboutPageContentInfo.aboutText"
                  content-type="html"
                /> -->
              <!-- <FormTextArea
                :label="'Main Paragraph'"
                :name="'text'"
                v-model="aboutPageContentInfo.aboutText"
                :row="'5'"
                :placeholder="'About page text content'"
                :error="this.aboutPageContentsErrors.aboutText"Editor
              >
              </FormTextArea> -->
            </div>
          </div>
          <div class="grid">
            <div>
              <p class="font-medium text-blue-600 dark:text-gray-400 my-4">{{useTrans('about.about_page')}}:</p>
              <FormFileUploadSingle
                @fileChange="(file) => (aboutImage = file)"
                :label="useTrans('about.image')"
                :oldImageLink="oldAboutImage"
                :name="'aboutImage'"
                :error="this.aboutPageContentsErrors.aboutImage"
              ></FormFileUploadSingle>

              <!-- Status table -->
              <div>
                <p class="font-medium text-blue-600 dark:text-gray-400 my-4">{{useTrans('about.statuses')}}:</p>

                <div>
                  <div
                    class="text-sm font-medium my-3 text-gray-500"
                    v-if="aboutStatuses.length < 1"
                  >
                      {{useTrans('about.no_status')}}
                  </div>

                  <div class="relative overflow-x-auto border rounded-lg my-2" v-else>
                    <table
                      class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                    >
                      <thead
                        class="text-xs text-gray-700 uppercase bg-blue-50 dark:bg-gray-700 dark:text-gray-400"
                      >
                        <tr>
                          <th scope="col" class="px-6 py-3">{{useTrans('about.status_name')}}</th>
                          <th scope="col" class="px-6 py-3">{{useTrans('about.status_value')}}</th>
                          <th scope="col" class="px-6 py-3"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr
                          class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                          v-for="(status, index) in aboutStatuses"
                          :key="index"
                        >
                          <td
                            scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                          >
                            {{ status.name }}
                          </td>
                          <td
                            scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                          >
                            {{ status.value }}
                          </td>
                          <td class="px-6 py-4">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              fill="none"
                              viewBox="0 0 35 35"
                              stroke-width="2.5"
                              stroke="currentColor"
                              class="w-6 h-6 text-red-500 hover:cursor-pointer hover:text-red-700"
                              @click="deleteStatus(index)"
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                              />
                            </svg>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <!-- add product attributes  -->
              <div>
                <div class="p-2 bg-blue-50 rounded-lg">
                  <div class="grid sm:grid-cols-12 gap-2">
                    <div class="col-span-5">
                      <label
                        for="status_name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{useTrans('about.status_name')}}</label
                      >
                      <input
                        type="text"
                        name="status_name"
                        id="status_name"
                        v-model="statusName"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="useTrans('about.years')"
                      />
                    </div>
                    <div class="col-span-5">
                      <label
                        for="status_value"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{useTrans('about.status_value')}}</label
                      >
                      <input
                        type="text"
                        name="status_value"
                        id="status_value"
                        v-model="statusValue"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder=""
                      />
                    </div>

                    <div class="self-end col-span-2">
                      <button
                        @click.prevent="addStatus()"
                        class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                      >
                        Add
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div>
        <Errors :errors="aboutPageContentsErrors ?? false"></Errors>
        <div class="flex items-center space-x-4">
          <Button
            @click.prevent="updateAboutPageContent()"
            :text="useTrans('about.update')"
            :color="'blue'"
          ></Button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { router } from "@inertiajs/vue3";
export default {
  props: ["aboutPageContentsErrors", "aboutPageContent"],
  data() {
    return {
      demo: "aaa",
      aboutPageContentInfo: this.aboutPageContent,
      aboutImage: false,
      oldAboutImage: this.aboutPageContent.about_image_url,
      aboutStatuses: JSON.parse(this.aboutPageContent.aboutStatuses),
      statusName: "",
      statusValue: "",
      newStatus: {},
      errors: this.aboutPageContentsErrors ?? {},
    };
  },
  methods: {
    addStatus() {
      if (this.statusName && this.statusValue) {
        let newStatus = {};
        newStatus.name = this.statusName;
        newStatus.value = this.statusValue;
        this.aboutStatuses.push(newStatus);
        this.statusName = this.statusValue = "";
        newStatus = {};
      }
    },
    deleteStatus(index) {
      if (index > -1) {
        this.aboutStatuses.splice(index, 1);
      }
    },
    updateAboutPageContent() {
      this.aboutPageContentInfo.aboutStatuses = JSON.stringify(this.aboutStatuses);
      if (this.aboutImage) {
        this.aboutPageContentInfo.aboutImage = this.aboutImage;
        this.oldAboutImage = URL.createObjectURL(this.aboutImage[0]);
      } else {
        delete this.aboutPageContentInfo.aboutImage;
      }
      this.aboutPageContentInfo._method = "put";
      router.post(`/admin-dashboard/about-page-contents/1`, this.aboutPageContentInfo, {
        preserveState: true,
        preserveScroll: true,
        only: ["aboutPageContent", "flash", "errors"],
      });
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
import {useTrans} from "../../composables/trans";

onMounted(() => {
  initFlowbite();
});
onUpdated(() => {
  initFlowbite();
});
</script>
