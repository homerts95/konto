<template>
  <section class="dark:bg-gray-900 h-screen overflow-x-hidden md:overflow-x-visible p-1">
    <div class="mx-auto max-w-screen-xl px-1 lg:px-12 my-11">
      <Breadcrump :links="{ orders: 'orders', 'Παραγγελίες': '' }"></Breadcrump>
      <AlertDelete
        v-if="deleteAlertOrder"
        @close="deleteAlertOrder = false"
        @confirm="deleteOrderConfirm()"
        :text="deleteAlertOrderText"
      ></AlertDelete>

      <div
        class="w-full block p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"
      >
        <div class="flex justify-between place-content-center">
          <h5
            class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
          >
            {{useTrans('product.order')}} #{{ order.id }}
          </h5>
          <div>
            <button
              id="dropdownMenuIconButton"
              data-dropdown-toggle="dropdownDots"
              class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-700 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
              type="button"
            >
              <svg
                class="w-6 h-6"
                aria-hidden="true"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"
                ></path>
              </svg>
            </button>

            <!-- Dropdown menu -->
            <div
              id="dropdownDots"
              class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600"
            >
              <ul
                class="py-2 text-sm text-gray-700 dark:text-gray-200"
                aria-labelledby="dropdownInformationButton"
              >
                <li>
                  <Link
                    :href="`/admin-dashboard/orders/${order.id}/edit`"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                    >{{useTrans('product.edit')}}</Link
                  >
                </li>
                <li>
                  <a
                    href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                    @click="deleteOrder(order.id)"
                    >{{useTrans('product.delete')}}</a
                  >
                </li>
              </ul>
              <div class="px-4 py-3 bg-blue-100 text-sm text-gray-900 dark:text-white">
                <div class="font-medium truncate">{{useTrans('product.change')}}</div>
                <div class="font-medium truncate">{{useTrans('product.order_status')}}</div>
              </div>
              <ul
                class="py-2 text-sm text-gray-700 dark:text-gray-200"
                aria-labelledby="dropdownInformationButton"
              >
                <li>
                  <Link
                    :href="`/admin-dashboard/orders/${order.id}/edit-status`"
                    method="put"
                    :data="{ status: 'unpaid' }"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                  >
                    <span
                      class="text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300 bg-yellow-100 text-yellow-800"
                    >
                      {{useTrans('product.unpaid')}}</span
                    ></Link
                  >
                </li>
                <li>
                  <Link
                    :href="`/admin-dashboard/orders/${order.id}/edit-status`"
                    method="put"
                    :data="{ status: 'paid' }"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                  >
                    <span
                      class="text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300 bg-green-100 text-green-800"
                    >
                      {{useTrans('product.paid')}}</span
                    ></Link
                  >
                </li>
                <li>
                  <Link
                    :href="`/admin-dashboard/orders/${order.id}/edit-status`"
                    method="put"
                    :data="{ status: 'shipped' }"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                  >
                    <span
                      class="text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300 bg-blue-100 text-blue-800"
                    >
                      {{useTrans('product.shipped')}}</span
                    ></Link
                  >
                </li>
                <li>
                  <Link
                    :href="`/admin-dashboard/orders/${order.id}/edit-status`"
                    method="put"
                    :data="{ status: 'delivered' }"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                  >
                    <span
                      class="text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300 bg-green-900 text-white"
                    >
                      {{useTrans('product.delivered')}}</span
                    ></Link
                  >
                </li>
                <li>
                  <Link
                    :href="`/admin-dashboard/orders/${order.id}/edit-status`"
                    method="put"
                    :data="{ status: 'cancelled' }"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                  >
                    <span
                      class="text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300 bg-red-600 text-white"
                    >
                      {{useTrans('product.cancelled')}}</span
                    ></Link
                  >
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="grid md:grid-cols-2 mt-10 gap-6">
          <div class="space-y-4">
            <p class="font-medium text-blue-600 dark:text-gray-400">{{useTrans('product.shipping_address')}}</p>
            <p>
              <b class="font-semibold text-gray-900 dark:text-white">{{useTrans('product.name')}} : </b
              >{{
                JSON.parse(order.shipping_address)["first_name"] +
                JSON.parse(order.shipping_address)["last_name"]
              }}<br />
              <b class="font-semibold text-gray-900 dark:text-white">Email : </b
              >{{ JSON.parse(order.shipping_address)["email"] }}<br />
              <b class="font-semibold text-gray-900 dark:text-white"> {{useTrans('product.phone_number')}} : </b
              >{{ JSON.parse(order.shipping_address)["phone_number"] }}<br />
              <b class="font-semibold text-gray-900 dark:text-white">{{useTrans('product.address')}} : </b>
              {{ JSON.parse(order.shipping_address)["address_line_1"] }}
              <br />
              {{ JSON.parse(order.shipping_address)["address_line_2"] }}<br />
              {{ JSON.parse(order.shipping_address)["city"] }}<br />
              {{ JSON.parse(order.shipping_address)["pin_code"] }}<br />
              {{ JSON.parse(order.shipping_address)["country"] }}<br />
            </p>

            <p class="font-medium text-blue-600 dark:text-gray-400">{{useTrans('product.user_details')}} :</p>
            <p>
              <b class="font-semibold text-gray-900 dark:text-white">{{useTrans('product.user_id')}} : </b
              >{{ order.user_id }}<br />
              <b class="font-semibold text-gray-900 dark:text-white">{{useTrans('product.user_ name')}} : </b
              >{{ order.user.first_name + " " + order.user.last_name }}<br />
              <b class="font-semibold text-gray-900 dark:text-white">Email : </b
              >{{ order.user.email }}<br />
              <b class="font-semibold text-gray-900 dark:text-white">{{useTrans('product.phone_number')}} : </b
              >{{ order.user.phone_number }}
            </p>
          </div>
          <div class="space-y-4">
            <p class="font-normal text-gray-700 dark:text-gray-400"></p>
            <p class="font-medium text-blue-600 dark:text-gray-400">{{useTrans('product.order_items')}}:</p>

            <div
              class="text-sm font-medium my-3 text-gray-500"
              v-if="JSON.parse(order.cart_content).length < 1"
            >
                {{useTrans('product.no_order_items')}}
            </div>

            <div class="relative overflow-x-auto border rounded-lg my-2" v-else>
              <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead
                  class="text-xs text-gray-700 uppercase bg-blue-50 dark:bg-gray-700 dark:text-gray-400"
                >
                  <tr>
                    <th scope="col" class="px-6 py-3">{{useTrans('product.product_name')}}</th>
                    <th scope="col" class="px-6 py-3">{{useTrans('product.quantity')}}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                    v-for="cartItem in JSON.parse(order.cart_content)"
                    :key="cartItem"
                  >
                    <th
                      scope="row"
                      class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    >
                      {{ cartItem.name }}
                    </th>
                    <td class="px-6 py-4">
                      {{ cartItem.quantity }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <p class="font-normal text-gray-700 dark:text-gray-400"></p>
            <div>
              <p class="font-medium text-blue-600 dark:text-gray-400">{{useTrans('product.order_price')}}:</p>
              <p>{{ order.total_price }}</p>
            </div>

            <div>
              <p class="font-medium text-blue-600 dark:text-gray-400">{{useTrans('product.order_status')}}:</p>
              <p class="my-2">
                <span
                  class="text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300"
                  :class="{
                    'bg-green-100 text-green-800': order.status === 'paid',
                    'bg-yellow-100 text-yellow-800': order.status === 'unpaid',
                    'bg-blue-100 text-blue-800': order.status === 'shipped',
                    'bg-green-600 text-white': order.status === 'delivered',
                    'bg-red-600 text-white': order.status === 'cancelled',
                  }"
                >
                  {{ order.status }}</span
                >
              </p>
            </div>
            <div>
              <p class="font-medium text-blue-600 dark:text-gray-400">{{useTrans('product.payment_method')}}:</p>
              <p class="text-gray-900">{{ order.payment_mode }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
export default {
  props: ["order"],
  data() {
    return {
      deleteAlertOrder: false,
      deleteAlertOrderText: "",
      orderId: null,
    };
  },
  methods: {
    deleteOrder(orderId) {
      window.scrollTo(0, 0);
      this.deleteAlertOrder = true;
      this.orderId = orderId;
      this.deleteAlertOrderText = useTrans('product.are_you_sure');
      setTimeout(() => (this.deleteAlertOrder = false), 5000);
    },
    deleteOrderConfirm() {
      router.delete(`/admin-dashboard/orders/${this.orderId}`, {
        preserveState: false,
      });
    },
  },
};
</script>
<script setup>
import { onMounted, onUpdated } from "vue";
import { initFlowbite } from "flowbite";
import Breadcrump from "../../../Shared/AdminDashboardComponents/Breadcrump.vue";
import AlertDelete from "../../../Shared/AdminDashboardComponents/AlertDelete.vue";
import {useTrans} from "../../../composables/trans";
onMounted(() => {
  initFlowbite();
});
onUpdated(() => {
  initFlowbite();
});
</script>
