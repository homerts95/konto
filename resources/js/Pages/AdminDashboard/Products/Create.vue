<template>
  <section class="dark:bg-gray-900 h-screen overflow-x-hidden md:overflow-x-visible p-1">
    <div class="mx-auto max-w-screen-xl px-1 lg:px-12 my-11 pb-11">
      <!-- Modal content -->

      <Breadcrump :links="{ products: 'products', 'Create Product': '' }"></Breadcrump>

      <div
        class="relative p-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 dark:bg-gray-800 sm:p-5"
      >
        <!-- Modal header -->
        <ModalHeader :heading="'Create Product'" :url="$page.url"></ModalHeader>

        <!-- Modal body -->
        <form action="#" @submit.prevent="">
          <div>
            <div class="mb-4">
              <div class="grid gap-4 mb-4 sm:grid-cols-5">
                <div class="grid sm:col-span-3 pr-4 border-r">
                  <!-- product general details  -->
                  <div>
                    <p class="font-medium text-blue-600 dark:text-gray-400 my-4">
                      Product General Details:
                    </p>
                    <div class="grid gap-4 sm:grid-cols-2">
                      <FormInput
                        :label="'Product Name'"
                        :name="'name'"
                        :type="'text'"
                        v-model="productInfo.name"
                        @change="changeNameToSlug"
                        :error="errors.name"
                      ></FormInput>
                      <FormSelect
                        :label="'Product Category'"
                        :name="'category_id'"
                        v-model="productInfo.category_id"
                        :error="errors.category_id"
                        :optionsArray="categories"
                        :optionName="'name'"
                        :optionValue="'id'"
                      >
                      </FormSelect>
                    </div>
                    <div class="grid gap-4 grid-cols-2 sm:grid-cols-4">
                      <FormInput
                        :label="'Brand'"
                        :name="'brand'"
                        :type="'text'"
                        v-model="productInfo.brand"
                        :error="errors.brand"
                      ></FormInput>
                      <FormSelect
                        :label="'Tag'"
                        :name="'tag'"
                        v-model="productInfo.tag"
                        :error="errors.tag"
                        :optionsArray="[
                          { value: 'best_seller' },
                          { value: 'new_arrival' },
                          { value: 'end_of_season' },
                        ]"
                        :optionName="'value'"
                        :optionValue="'value'"
                      >
                      </FormSelect>
                      <FormInput
                        :label="'Inventory'"
                        :name="'inventory'"
                        :type="'number'"
                        v-model="productInfo.inventory"
                        :error="errors.inventory"
                      ></FormInput>
                      <FormSelect
                        :label="'Availability'"
                        :name="'availability'"
                        v-model="productInfo.availability"
                        :error="errors.availability"
                        :optionsArray="[
                          { value: 'available' },
                          { value: 'out_of_stock' },
                          { value: 'coming_soon' },
                        ]"
                        :optionName="'value'"
                        :optionValue="'value'"
                      ></FormSelect>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                      <FormInput
                        :label="'Offer Text'"
                        :name="'offer'"
                        :type="'text'"
                        :placeholder="'ex: Buy 1 Get One..'"
                        v-model="productInfo.offer"
                        :error="errors.offer_text"
                      ></FormInput>
                      <div class="grid gap-4 grid-col-2 sm:grid-cols-2">
                        <FormInput
                          :label="'Sale price'"
                          :name="'price_sale'"
                          :type="'number'"
                          v-model="productInfo.price_sale"
                          :error="errors.price_sale"
                        ></FormInput>
                        <FormInput
                          :label="'Price'"
                          :name="'price'"
                          :type="'number'"
                          v-model="productInfo.price"
                          :error="errors.price"
                        ></FormInput>
                      </div>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                      <FormInput
                        :label="useTrans('product.product_slug')"
                        :name="useTrans('product.slug')"
                        :type="'text'"
                        v-model="productInfo.slug"
                        @change="changeToSlug()"
                        :error="errors.slug"
                      ></FormInput>
                      <FormInput
                        :label="useTrans('product.product_link')"
                        :name="useTrans('product.link')"
                        :type="'text'"
                        :readOnly="`{domain-name}/products/${productInfo.slug}`"
                        :disabled="true"
                        :error="errors.link"
                      ></FormInput>
                    </div>
                  </div>

                  <!-- product attributes table -->
                  <div>
                    <p class="font-medium text-blue-600 dark:text-gray-400 my-4">
                      {{useTrans('product.product_specifications_or_attributes')}}
                    </p>

                    <div>
                      <div
                        class="text-sm font-medium my-3 text-gray-500"
                        v-if="Object.keys(productAttributes).length < 1"
                      >
                          {{useTrans('product.no_attributes')}}
                      </div>

                      <div class="relative overflow-x-auto border rounded-lg my-2" v-else>
                        <table
                          class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                        >
                          <thead
                            class="text-xs text-gray-700 uppercase bg-blue-50 dark:bg-gray-700 dark:text-gray-400"
                          >
                            <tr>
                              <th scope="col" class="px-6 py-3">{{useTrans('product.attribute_name')}}</th>
                              <th scope="col" class="px-6 py-3">{{useTrans('product.attribute_value')}}</th>
                              <th scope="col" class="px-6 py-3"></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr
                              class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                              v-for="(value, key, index) in productAttributes"
                              :key="index"
                            >
                              <td
                                scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                              >
                                {{ key }}
                              </td>
                              <td
                                scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                              >
                                {{ value }}
                              </td>
                              <td class="px-6 py-4">
                                <svg
                                  xmlns="http://www.w3.org/2000/svg"
                                  fill="none"
                                  viewBox="0 0 35 35"
                                  stroke-width="2.5"
                                  stroke="currentColor"
                                  class="w-6 h-6 text-red-500 hover:cursor-pointer hover:text-red-700"
                                  @click="deleteProductAttribute(key)"
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
                            for="attribute_label"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >{{useTrans('product.attribute_label')}}</label
                          >
                          <input
                            type="text"
                            name="us'"
                            id="attribute_label"
                            v-model="newAttribute.attribute_label"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="ex: Color/Size/.."
                          />
                        </div>
                        <div class="col-span-5">
                          <label
                            for="attribute_value"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Attribute Value</label
                          >
                          <input
                            type="text"
                            name="attribute_value"
                            id="attribute_value"
                            v-model="newAttribute.attribute_value"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Red, Blue,  or XS,S,M,L.."
                          />
                        </div>

                        <div class="self-end col-span-2">
                          <button
                            @click.prevent="addProductAttribute()"
                            class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                          >
                            Add
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- product descriptions  -->
                  <div>
                    <p class="font-medium text-blue-600 dark:text-gray-400 my-4">
                      Product Descriptions:
                    </p>
                    <FormTextArea
                      :label="'Short Description'"
                      :name="'short_description'"
                      v-model="productInfo.short_description"
                      :row="'5'"
                      :placeholder="'Give a short Description'"
                      :error="errors.short_description"
                    >
                    </FormTextArea>
                    <FormTextArea
                      :label="'Long Description'"
                      :name="'description'"
                      v-model="productInfo.description"
                      :row="'5'"
                      :placeholder="'Give a detailed Description'"
                      :error="errors.description"
                    >
                    </FormTextArea>
                  </div>
                </div>

                <div class="grid sm:col-span-2">
                  <div>
                    <p class="font-medium text-blue-600 dark:text-gray-400 my-4">
                      Product Images:
                    </p>

                    <FormFileUploadSingle
                      @fileChange="(file) => (this.productInfo.thumbnail = file[0])"
                      :label="'Thumbnail'"
                      :name="'thumbnail'"
                      :error="errors.thumbnail ?? errors['thumbnail.0']"
                    ></FormFileUploadSingle>

                    <FormFileUploadMultiple
                      @filesChange="(files) => (this.productInfo.more_images = files)"
                      :label="'More Images'"
                      :name="'more_images'"
                      :error="errors.more_images"
                    >
                    </FormFileUploadMultiple>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div>
            <Errors :errors="errors ?? false"></Errors>
            <div class="flex items-center space-x-4">
              <Button
                @click.prevent="createProduct()"
                :text="'Create Product'"
                :color="'blue'"
              ></Button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</template>

<script>
import { useForm } from "@inertiajs/vue3";
export default {
  props: ["errors", "categories"],
  data() {
    return {
      productInfo: {},
      form: {},
      newAttribute: {},
      productAttributes: {},
      addedImages: [],
      addedThumbnail: null,
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
      this.productInfo.slug = this.slugify(this.productInfo.name);
    },
    changeToSlug() {
      if (this.productInfo.slug !== "") {
        this.productInfo.slug = this.slugify(this.productInfo.slug);
      } else {
        this.productInfo.slug = this.slugify(this.productInfo.name);
      }
    },
    addProductAttribute() {
      if (this.newAttribute.attribute_label && this.newAttribute.attribute_value) {
        this.productAttributes[
          this.newAttribute.attribute_label
        ] = this.newAttribute.attribute_value;
        this.newAttribute = {};
      }
      console.log(this.productAttributes);
    },
    deleteProductAttribute(key) {
      delete this.productAttributes[key];
    },
    createProduct() {
      this.productInfo.product_details = JSON.stringify(this.productAttributes);
      console.log(this.productInfo);
      this.form = useForm(this.productInfo);
      this.form.post(`/admin-dashboard/products`, {
        preserveScroll: true,
      });
    },
  },
};
</script>
<script setup>
import { onMounted, onUpdated } from "vue";
import { initFlowbite } from "flowbite";
import Breadcrump from "../../../Shared/AdminDashboardComponents/Breadcrump.vue";
import ModalHeader from "../../../Shared/AdminDashboardComponents/ModalHeader.vue";
import FormInput from "../../../Shared/FormComponents/FormInput.vue";
import FormSelect from "../../../Shared/FormComponents/FormSelect.vue";
import FormTextArea from "../../../Shared/FormComponents/FormTextArea.vue";
import FormFileUploadSingle from "../../../Shared/FormComponents/FormFileUploadSingle.vue";
import FormFileUploadMultiple from "../../../Shared/FormComponents/FormFileUploadMultiple.vue";
import Button from "../../../Shared/FormComponents/Button.vue";
import Errors from "../../../Shared/FormComponents/Errors.vue";
import {useTrans} from "../../../composables/trans";

onMounted(() => {
  initFlowbite();
});
onUpdated(() => {
  initFlowbite();
});
</script>
