<template>
  <div
    class="relative p-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 dark:bg-gray-800 sm:p-5 my-10"
  >
    <!-- Modal header -->
    <ModalHeader :heading="'Site Identity'" :url="$page.url"></ModalHeader>
    <!-- Modal body -->
    <form action="#" @submit.prevent="">
      <div>
        <div class="grid gap-4 mb-4 grid-cols-1 md:grid-cols-3">
          <div class="pr-5 md:border-r">
            <p class="font-medium text-blue-600 dark:text-gray-400 my-4">{{useTrans('siteId.info')}}</p>
            <div class="grid gap-4">
              <FormInput
                :label="useTrans('siteId.site_name')"
                :name="'site_name'"
                :type="'text'"
                :placeholder="'Lara Commerce'"
                v-model="siteIdentityInfo.siteName"
                :error="siteIdentityErrors.siteName"
              ></FormInput>
              <FormInput
                :label="useTrans('siteId.domain')"
                :name="'site_domain'"
                :type="'text'"
                :placeholder="'joeDoe.com'"
                v-model="siteIdentityInfo.siteDomain"
                :error="siteIdentityErrors.siteDomain"
              ></FormInput>
              <FormInput
                :label="useTrans('siteId.site_email')"
                :name="'site_email'"
                :type="'text'"
                :placeholder="'panos@gmail.com'"
                v-model="siteIdentityInfo.siteEmail"
                :error="siteIdentityErrors.siteEmail"
              ></FormInput>
            </div>
          </div>
          <div class="pr-5 md:border-r">
            <p class="font-medium text-blue-600 dark:text-gray-400 my-4">
              {{useTrans('siteId.site_owner_info')}}
            </p>

            <div class="grid gap-4">
              <FormInput
                :label="useTrans('siteId.site_owner_name')"
                :name="'site_owner_name'"
                :type="'text'"
                v-model="siteIdentityInfo.siteOwnerName"
                :error="siteIdentityErrors.siteOwnerName"
              ></FormInput>
              <FormInput
                :label="useTrans('siteId.site_owner_email')"
                :name="'site_owner_email'"
                :type="'email'"
                :placeholder="'joe@doe.com'"
                v-model="siteIdentityInfo.siteOwnerEmail"
                :error="siteIdentityErrors.siteOwnerEmail"
              ></FormInput>
            </div>
            <p class="font-medium text-blue-600 dark:text-gray-400 my-4">
              E-Commerce Config
            </p>

            <div class="grid gap-4">
              <FormCheckBox
                :label="useTrans('siteId.enable_or_edit_stripe_payment')"
                :name="'enable_stripe'"
                :checked="siteIdentityInfo.enable_stripe"
                v-model="siteIdentityInfo.enable_stripe"
                :error="siteIdentityErrors.enable_stripe"
              >
              </FormCheckBox>
              <FormInput
                :label="'Stripe Secret Key'"
                :name="'stripe_secrete_key'"
                :type="'text'"
                :disabled="!siteIdentityInfo.enable_stripe"
                v-model="siteIdentityInfo.stripe_secret_key"
                :error="siteIdentityErrors.stripe_secret_key"
              ></FormInput>
              <FormSelectVue
                :label="useTrans('siteId.choose_currency')"
                :name="'currency'"
                v-model="siteIdentityInfo.currency"
                :selected="siteIdentityInfo.currency"
                :optionsArray="currenciesArray"
                :optionName="'name'"
                :optionValue="'value'"
              >
              </FormSelectVue>
            </div>
          </div>
          <div class="grid">
            <div>
              <FormFileUploadSingle
                @fileChange="(file) => (logoImage = file)"
                :label=useTrans('siteId.logo_image')
                :oldImageLink="oldLogoImage"
                :name="'logoImage'"
                :error="siteIdentityErrors.logoImage"
              ></FormFileUploadSingle>
            </div>
          </div>
        </div>
      </div>

      <div>
        <Errors :errors="siteIdentityErrors ?? false"></Errors>
        <div class="flex items-center space-x-4">
          <Button
            @click.prevent="updateSiteIdentity()"
            :text="useTrans('siteId.update')"
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
  components: { FormCheckBox },
  props: ["siteIdentityErrors", "siteIdentity"],
  data() {
    return {
      siteIdentityInfo: this.siteIdentity,
      logoImage: false,
      oldLogoImage: this.siteIdentity.logo_image_url,
    };
  },
  computed: {
    currenciesArray() {
      var currenciesArray = [];
      var inputArray = JSON.parse(this.siteIdentityInfo.available_currencies);
      console.log(inputArray);
      Object.keys(inputArray).forEach(function (key, index) {
        currenciesArray.push({
          value: key,
          name: inputArray[key],
        });
      });
      console.log(this.currenciesArray);
      return currenciesArray;
    },
  },
  methods: {
    updateSiteIdentity() {
      if (this.logoImage) {
        this.siteIdentityInfo.logoImage = this.logoImage[0];
        this.oldLogoImage = URL.createObjectURL(this.logoImage[0]);
      } else {
        delete this.siteIdentityInfo.logoImage;
      }
      this.siteIdentityInfo._method = "put";
      router.post(`/admin-dashboard/site-identity/1`, this.siteIdentityInfo, {
        preserveState: true,
        preserveScroll: true,
        only: ["siteIdentity", "flash", "errors"],
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

import Button from "../FormComponents/Button.vue";
import Errors from "../FormComponents/Errors.vue";
import FormCheckBox from "../FormComponents/FormCheckBox.vue";

import FormSelectVue from "../FormComponents/FormSelect.vue";
import {useTrans} from "../../composables/trans";

onMounted(() => {
  initFlowbite();
});
onUpdated(() => {
  initFlowbite();
});
</script>
