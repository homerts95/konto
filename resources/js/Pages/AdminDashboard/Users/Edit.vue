<template>
  <section class="dark:bg-gray-900 h-screen overflow-x-hidden md:overflow-x-visible p-1">
    <div class="mx-auto max-w-screen-xl px-1 lg:px-12 my-11 pb-11">
      <!-- Modal content -->

      <Breadcrump :links="{ users: 'users', 'Επεξεργασία χρήστη': '' }"></Breadcrump>

      <AlertDelete
        v-if="deleteAlertUser"
        @close="deleteAlertUser = false"
        @confirm="deleteUserConfirm()"
        :text="deleteAlertUserText"
      ></AlertDelete>

      <div
        class="relative p-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 dark:bg-gray-800 sm:p-5"
      >
        <!-- Modal header -->
        <ModalHeader :heading="`Επεξεργασία χρήστη - #${user.id}`" :url="$page.url"></ModalHeader>

        <!-- Modal body -->
        <form action="#" @submit.prevent="">
          <div>
            <div class="mb-4">
              <div class="grid gap-4 mb-4 sm:grid-cols-5">
                <div class="grid sm:col-span-3 pr-4 border-r">
                  <!-- product general details  -->
                  <div>
                    <p class="font-medium text-blue-600 dark:text-gray-400 my-4">
                        {{useTrans('user.user_general_details')}}
                    </p>
                    <div class="grid gap-4 sm:grid-cols-2">
                      <FormInput
                        :label="useTrans('user.first_name')"
                        :name="'first_name'"
                        :type="'text'"
                        v-model="userInfo.first_name"
                        :error="errors.first_name"
                      ></FormInput>
                      <FormInput
                        :label="useTrans('user.last_name')"
                        :name="'last_name'"
                        :type="'text'"
                        v-model="userInfo.last_name"
                        :error="errors.last_name"
                      ></FormInput>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                      <FormInput
                        :label="'Email'"
                        :name="'email'"
                        :type="'email'"
                        v-model="userInfo.email"
                        :error="errors.email"
                      ></FormInput>
                      <FormInput
                        :label="useTrans('user.phone_number')"
                        :name="'phone_number'"
                        :type="'number'"
                        v-model="userInfo.phone_number"
                        :error="errors.phone_number"
                      ></FormInput>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                      <FormInput
                        :label="useTrans('user.dob')"
                        :name="'birthday'"
                        :type="'date'"
                        v-model="userInfo.birthday"
                        :error="errors.birthday"
                      ></FormInput>
                      <FormInput
                        :label="useTrans('user.gender')"
                        :name="'gender'"
                        :type="'text'"
                        v-model="userInfo.gender"
                        :error="errors.gender"
                      ></FormInput>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                      <FormInput
                        :label="useTrans('user.change_password')"
                        :name="'password'"
                        :type="'password'"
                        v-model="userInfo.password"
                        :error="errors.password"
                      ></FormInput>
                      <FormInput
                        :label="useTrans('user.confirm_password')"
                        :name="'confirm_password'"
                        :type="'password'"
                        v-model="userInfo.password_confirmation"
                        :error="errors.password_confirmation"
                      ></FormInput>
                    </div>
                  </div>
                </div>

                <div class="grid sm:col-span-2">
                  <div>
                    <p class="font-medium text-blue-600 dark:text-gray-400 my-4">
                        {{ useTrans('user.profile_image') }}
                    </p>

                    <FormFileUploadSingle
                      @fileChange="(file) => (avatar = file[0])"
                      :label="useTrans('user.profile_image')"
                      :oldImageLink="oldAvatarImage"
                      :name="'avatar'"
                      :error="errors.avatar"
                    ></FormFileUploadSingle>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div>
            <Errors :errors="errors ?? false"></Errors>
            <div class="flex items-center space-x-4">
              <Button
                @click.prevent="updateUser()"
                :text="useTrans('user.update_user')"
                :color="'blue'"
              ></Button>
              <Button
                @click.prevent="deleteUser()"
                :text="useTrans('user.delete_user')"
                :disableFlash="true"
                :color="'red'"
              ></Button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</template>

<script>
import { router } from "@inertiajs/vue3";
export default {
  props: ["errors", "user"],
  data() {
    return {
      userInfo: this.user,
      form: {},
      avatar: false,
      deleteAlertUser: false,
      deleteAlertUserText: "",
      oldAvatarImage: this.user.avatar ?? null,
    };
  },
  methods: {
    deleteUser() {
      window.scrollTo(0, 0);
      this.deleteAlertUser = true;
      this.deleteAlertUserText = useTrans('are_you_sure');
      setTimeout(() => (this.deleteAlertUser = false), 5000);
    },
    deleteUserConfirm() {
      router.delete(`/admin-dashboard/users/${this.user.id}`);
    },
    updateUser() {
      if (this.avatar) {
        this.userInfo.avatar = this.avatar;
        this.oldAvatarImage = URL.createObjectURL(this.avatar);
      } else {
        delete this.userInfo.avatar;
      }
      console.log(this.userInfo);
      this.userInfo._method = "put";
      router.post(`/admin-dashboard/users/${this.user.id}`, this.userInfo, {
        preserveState: false,
        preserveScroll: true,
        only: ["user", "errors", "flash"],
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
import FormFileUploadSingle from "../../../Shared/FormComponents/FormFileUploadSingle.vue";
import Button from "../../../Shared/FormComponents/Button.vue";
import Errors from "../../../Shared/FormComponents/Errors.vue";
import AlertDelete from "../../../Shared/AdminDashboardComponents/AlertDelete.vue";
import {useTrans} from "../../../composables/trans";

onMounted(() => {
  initFlowbite();
});
onUpdated(() => {
  initFlowbite();
});
</script>
