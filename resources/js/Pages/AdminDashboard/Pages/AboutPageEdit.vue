<template>
  <EditSectionLayout>
    <Breadcrump :links="{ Pages: null, 'Edit About Page': null }"></Breadcrump>

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
              <p class="font-medium text-blue-600 dark:text-gray-400 my-4">
                  {{useTrans('page.text_contents')}}
              </p>
              <div class="grid gap-4">
                <FormInput
                  :label="useTrans('page.heading')"
                  :name="'heading'"
                  :type="'text'"
                  :placeholder="useTrans('page.heading')"
                  v-model="aboutPageContentInfo.about_heading"
                  :error="$page.props.errors.about_heading ?? ''"
                ></FormInput>
                <FormTextArea
                  :label="useTrans('page.sub_heading')"
                  :name="'sub_heading'"
                  v-model="aboutPageContentInfo.about_sub_heading"
                  :row="'3'"
                  :placeholder="useTrans('page.sub_heading')"
                  :error="$page.props.errors.about_sub_heading ?? ''"
                >
                </FormTextArea>

                <FormTextEditor
                  v-model="aboutPageContentInfo.about_text"
                  :label="useTrans('page.main_paragraph')"
                  :name="'text'"
                  :error="$page.props.errors.about_text ?? ''"
                ></FormTextEditor>
              </div>
            </div>
            <div class="grid">
              <div>
                <p class="font-medium text-blue-600 dark:text-gray-400 my-4">
                    {{ useTrans('page.about_page')  }} :
                </p>
                <FormFileUploadSingle
                  @fileChange="(file) => (about_image = file[0])"
                  :label="useTrans('page.image')"
                  :oldImageLink="oldAboutImage"
                  :name="'aboutImage'"
                  :error="$page.props.errors.about_image ?? ''"
                ></FormFileUploadSingle>

                <!-- Status table -->
                <div>
                  <p class="font-medium text-blue-600 dark:text-gray-400 my-4">
                    {{useTrans('pages.statuses')}}:
                  </p>

                  <div>
                    <div
                      class="text-sm font-medium my-3 text-gray-500"
                      v-if="about_statuses.length < 1"
                    >
                        {{useTrans('pages.no_status_available')}}
                    </div>

                    <div class="relative overflow-x-auto border rounded-lg my-2" v-else>
                      <table
                        class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                      >
                        <thead
                          class="text-xs text-gray-700 uppercase bg-blue-50 dark:bg-gray-700 dark:text-gray-400"
                        >
                          <tr>
                            <th scope="col" class="px-6 py-3">{{useTrans('pages.status_name')}}</th>
                            <th scope="col" class="px-6 py-3">{{useTrans('pages.status_value')}}</th>
                            <th scope="col" class="px-6 py-3"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                            v-for="(status, index) in about_statuses"
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
                          >{{useTrans('pages.status_name')}}</label
                        >
                        <input
                          type="text"
                          name="status_name"
                          id="status_name"
                          v-model="statusName"
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                          placeholder=""
                        />
                      </div>
                      <div class="col-span-5">
                        <label
                          for="status_value"
                          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                          >{{useTrans('pages.status_value')}}</label
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
          <Errors :errors="$page.props.errors ?? false"></Errors>
          <div class="flex items-center space-x-4">
            <Button
              @click.prevent="updateAboutPageContent()"
              :text="useTrans('pages.update_about_page')"
              :color="'blue'"
            ></Button>
          </div>
        </div>
      </form>
    </div>
  </EditSectionLayout>
  <!-- Modal content -->
</template>

<script>
import { router } from "@inertiajs/vue3";
export default {
  props: ["aboutPageContent"],
  data() {
    return {
      demo: "aaa",
      aboutPageContentInfo: this.aboutPageContent,
      about_image: false,
      oldAboutImage: this.aboutPageContent.about_image_url,
      about_statuses: JSON.parse(this.aboutPageContent.about_statuses),
      statusName: "",
      statusValue: "",
      newStatus: {},
    };
  },
  methods: {
    addStatus() {
      if (this.statusName && this.statusValue) {
        let newStatus = {};
        newStatus.name = this.statusName;
        newStatus.value = this.statusValue;
        this.about_statuses.push(newStatus);
        this.statusName = this.statusValue = "";
        newStatus = {};
      }
    },
    deleteStatus(index) {
      if (index > -1) {
        this.about_statuses.splice(index, 1);
      }
    },
    updateAboutPageContent() {
      this.aboutPageContentInfo.about_statuses = JSON.stringify(this.about_statuses);
      if (this.about_image) {
        this.aboutPageContentInfo.about_image = this.about_image;
        this.oldAboutImage = URL.createObjectURL(this.about_image);
      } else {
        delete this.aboutPageContentInfo.about_image;
      }
      this.aboutPageContentInfo._method = "put";
      router.post(
        `/admin-dashboard/pages/about-page-content`,
        this.aboutPageContentInfo,
        {
          preserveState: true,
          preserveScroll: true,
          only: ["aboutPageContent", "flash", "errors"],
        }
      );
    },
  },
};
</script>

<script setup>
import { onMounted, onUpdated } from "vue";
import { initFlowbite } from "flowbite";

import ModalHeader from "../../../Shared/AdminDashboardComponents/ModalHeader.vue";
import Button from "../../../Shared/FormComponents/Button.vue";
import Errors from "../../../Shared/FormComponents/Errors.vue";
import Breadcrump from "../../../Shared/AdminDashboardComponents/Breadcrump.vue";
import EditSectionLayout from "../../../Shared/AdminDashboardComponents/EditSectionLayout.vue";
import FormFileUploadSingle from "../../../Shared/FormComponents/FormFileUploadSingle.vue";
import FormTextArea from "../../../Shared/FormComponents/FormTextArea.vue";
import FormInput from "../../../Shared/FormComponents/FormInput.vue";
import FormTextEditor from "../../../Shared/FormComponents/FormTextEditor.vue";
import {useTrans} from "../../../composables/trans";

onMounted(() => {
  initFlowbite();
});
onUpdated(() => {
  initFlowbite();
});
</script>
