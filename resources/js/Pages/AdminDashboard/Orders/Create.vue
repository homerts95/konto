<template>
  <section class="dark:bg-gray-900 h-screen overflow-x-hidden md:overflow-x-visible p-1">
    <div class="mx-auto max-w-screen-xl px-1 lg:px-12 my-11 pb-11">
      <!-- Modal content -->

      <Breadcrump :links="{ orders: 'orders', 'Create Order': '' }"></Breadcrump>

      <div
        class="relative p-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 dark:bg-gray-800 sm:p-5"
      >
        <!-- Modal header -->
        <ModalHeader :heading="'Create Order'" :url="$page.url"></ModalHeader>
        <!-- Modal body -->
        <form action="#" @submit.prevent="">
          <div>
            <div class="grid gap-4 mb-4 grid-col-1 sm:grid-cols-3">
              <div class="pr-5 border-r col-span-2">
                <p class="font-medium text-blue-600 dark:text-gray-400 my-4">
                  {{useTrans('product.shipping_address')}}:
                </p>
                <div class="grid gap-4 sm:grid-cols-2">
                  <FormInput
                    :label="useTrans('product.first_name')"
                    :name="'first_name'"
                    :type="'text'"
                    v-model="orderInfoShippingAddress.first_name"
                  ></FormInput>
                  <FormInput
                    :label="useTrans('product.last_name')"
                    :name="'last_name'"
                    :type="'text'"
                    v-model="orderInfoShippingAddress.last_name"
                  ></FormInput>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                  <FormInput
                    :label="'Email'"
                    :name="'email'"
                    :type="'email'"
                    v-model="orderInfoShippingAddress.email"
                  ></FormInput>
                  <FormInput
                    :label="useTrans('product.phone_number')"
                    :name="'phone_number'"
                    :type="'text'"
                    v-model="orderInfoShippingAddress.phone_number"
                  ></FormInput>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                  <FormInput
                    :label="useTrans('product.address1')"
                    :name="'address_line_1'"
                    :type="'text'"
                    v-model="orderInfoShippingAddress.address_line_1"
                  ></FormInput>
                  <FormInput
                    :label="useTrans('product.address2')"
                    :name="'address_line_2'"
                    :type="'text'"
                    v-model="orderInfoShippingAddress.address_line_2"
                  ></FormInput>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                  <FormInput
                    :label="useTrans('product.city')"
                    :name="'city'"
                    :type="'text'"
                    v-model="orderInfoShippingAddress.city"
                  ></FormInput>
                  <FormInput
                    :label="useTrans('product.post_code')"
                    :name="'pin_code'"
                    :type="'text'"
                    v-model="orderInfoShippingAddress.pin_code"
                  ></FormInput>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                  <FormInput
                    :label="useTrans('product.country')"
                    :name="'country'"
                    :type="'text'"
                    v-model="orderInfoShippingAddress.country"
                  ></FormInput>
                </div>
              </div>
              <div class="">
                <p class="font-medium text-blue-600 dark:text-gray-400 my-4">
                  {{useTrans('product.user_details')}}:
                </p>
                <FormInput
                  :label="useTrans('product.user_id')"
                  :name="'user_id'"
                  :type="'text'"
                  :error="errors.user_id"
                  v-model="orderInfo.user_id"
                ></FormInput>
                <p class="font-medium text-blue-600 dark:text-gray-400 my-4">
                  Order Status:
                </p>
                <FormSelect
                  :label="useTrans('product.change_order_status')"
                  :name="'status'"
                  v-model="orderInfo.status"
                  :error="errors.status"
                  :optionsArray="[
                    { value: 'unpaid' },
                    { value: 'paid' },
                    { value: 'shipped' },
                    { value: 'delivered' },
                    { value: 'cancelled' },
                  ]"
                  :optionName="'value'"
                  :optionValue="'value'"
                >
                </FormSelect>
                <p class="font-medium text-blue-600 dark:text-gray-400 my-4">
                  {{useTrans('product.payment_method')}}
                </p>
                <FormSelect
                  :label="useTrans('product.payment_method')"
                  :name="'payment_method'"
                  v-model="orderInfo.payment_mode"
                  :error="errors.payment_mode"
                  :optionsArray="[{ value: useTrans('product.cod') }, { value: useTrans('product.stripe') }]"
                  :optionName="'value'"
                  :optionValue="'value'"
                ></FormSelect>
              </div>
            </div>
          </div>

          <div>
            <Errors :errors="errors ?? false"></Errors>
            <div class="flex items-center space-x-4">
              <Button
                @click.prevent="createOrder()"
                :text="useTrans('product.create_order')"
                :color="'blue'"
              ></Button>
            </div>
          </div>
        </form>
      </div>

      <div
        class="relative p-4 bg-blue-100 border border-blue-100 rounded-lg shadow dark:border-gray-700 dark:bg-gray-800 sm:p-5 my-6"
      >
        <div class="bg-blue-100 px-3 rounded pb-4">
          <p class="font-medium text-blue-600 dark:text-gray-400 my-4">{{useTrans('product.order_details')}}:</p>
          <div>
            <label
              for="description"
              class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
              >{{useTrans('order_details')}}</label
            >
            <TableOrderContent :orderContent="orderContent"></TableOrderContent>
          </div>
          <div class="grid sm:grid-cols-2">
            <div class="p-2 bg-blue-50 rounded-lg">
              <label
                for="description"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Add item</label
              >
              <div class="grid gap-4 sm:grid-cols-2">
                <FormInput
                  :label="useTrans('product.product_id')"
                  :name="'product_id'"
                  :type="'number'"
                  v-model="newOrderItem.id"
                ></FormInput>
                <FormInput
                  :label="useTrans('product.product_name')"
                  :name="'product_name'"
                  :type="'text'"
                  v-model="newOrderItem.name"
                ></FormInput>
              </div>
              <div class="grid gap-4 sm:grid-cols-2">
                <FormInput
                  :label="useTrans('product.product_price')"
                  :name="'product_price'"
                  :type="'number'"
                  v-model="newOrderItem.price"
                ></FormInput>
                <FormInput
                  :label="useTrans('product.qty')"
                  :name="'product_quantity'"
                  :type="'number'"
                  v-model="newOrderItem.quantity"
                ></FormInput>
              </div>
              <div class="justify-self-stretch col-span-2">
                <Button
                  @click.prevent="addOrderItem()"
                  :text="useTrans('product.add_order_item')"
                  :color="'blue'"
                ></Button>
              </div>
            </div>
            <div class="p-5 pb-0 flex flex-col justify-between">
              <div>
                <label class="text-md font-medium text-gray-900"
                  >{{useTrans('product.total_amount')}}: {{ totalAmount }}</label
                ><br />
                <label class="text-md font-medium text-gray-900"
                  >{{useTrans('product.total_no_products')}}: {{ orderContent.length }}</label
                ><br />
              </div>

              <div>
                <Errors :errors="errors ?? false"></Errors>
                <div class="flex items-center space-x-4">
                  <Button
                    @click.prevent="createOrder()"
                    :text="useTrans('product.create_product')"
                    :color="'blue'"
                  ></Button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { router } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
export default {
  props: ["errors"],
  data() {
    return {
      orderInfo: {},
      orderInfoShippingAddress: {},
      orderContent: [],
      newOrderItem: {},
      form: {},
    };
  },
  computed: {
    totalAmount() {
      var total = 0;
      if (this.orderContent.length > 0) {
        this.orderContent.forEach((element) => {
          total += element.price * element.quantity;
        });
      }
      return total;
    },
  },
  methods: {
    addOrderItem() {
      if (
        this.newOrderItem.id > 0 &&
        this.newOrderItem.name !== "" &&
        this.newOrderItem.price > 0 &&
        this.newOrderItem.quantity > 0
      )
        var item = {};
      item["id"] = this.newOrderItem.id;
      item["name"] = this.newOrderItem.name;
      item["price"] = this.newOrderItem.price;
      item["quantity"] = this.newOrderItem.quantity;
      this.orderContent.push(item);
      item = {};
      this.newOrderItem = {};
    },
    deleteOrderItem(item) {
      var index = this.orderContent.indexOf(item);
      if (index !== -1) {
        this.orderContent.splice(index, 1);
      }
    },
    reloadPage() {
      router.visit(`/admin-dashboard/orders/${this.order.id}/edit`);
    },
    createOrder() {
      this.orderInfo.shipping_address = JSON.stringify(this.orderInfoShippingAddress);
      this.orderInfo.cart_content = JSON.stringify(this.orderContent);
      this.orderInfo.total_price = this.totalAmount;
      this.orderInfo.session_id = useTrans('product.manually_created_order');
      this.form = useForm(this.orderInfo);
      console.log(this.orderInfo);
      this.form.post(`/admin-dashboard/orders`, {
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
import Button from "../../../Shared/FormComponents/Button.vue";
import Errors from "../../../Shared/FormComponents/Errors.vue";

import TableOrderContent from "../../../Shared/Tables/TableOrderContent.vue";
import {useTrans} from "../../../composables/trans";
onMounted(() => {
  initFlowbite();
});
onUpdated(() => {
  initFlowbite();
});
</script>
