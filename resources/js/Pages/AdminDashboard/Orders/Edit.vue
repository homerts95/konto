<template>
    <section class="dark:bg-gray-900 h-screen overflow-x-hidden md:overflow-x-visible p-1">
        <div class="mx-auto max-w-screen-xl px-1 lg:px-12 my-11 pb-11">
            <!-- Modal content -->

            <Breadcrump :links="{ orders: 'orders', 'Edit Order': '' }"></Breadcrump>
            <AlertDelete
                v-if="deleteAlertOrder"
                @close="deleteAlertOrder = false"
                @confirm="deleteOrderConfirm()"
                :text="deleteAlertOrderText"
            ></AlertDelete>

            <div
                class="relative p-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 dark:bg-gray-800 sm:p-5"
            >
                <!-- Modal header -->
                <ModalHeader
                    :heading="`Edit Order - #${order.id}`"
                    :url="$page.url"
                ></ModalHeader>
                <!-- Modal body -->
                <form action="#" @submit.prevent="">
                    <div>
                        <div class="grid gap-4 mb-4 grid-col-1 sm:grid-cols-3">
                            <div class="pr-5 border-r col-span-2">
                                <p class="font-medium text-blue-600 dark:text-gray-400 my-4">
                                    {{ useTrans('order.shipping_address') }} :
                                </p>
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <FormInput
                                        :label="useTrans('order.first_name')"
                                        :name="'first_name'"
                                        :type="'text'"
                                        v-model="orderInfoShippingAddress.first_name"
                                    ></FormInput>
                                    <FormInput
                                        :label="useTrans('order.last_name')"
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
                                        :label="useTrans('order.phone_number')"
                                        :name="'phone_number'"
                                        :type="'text'"
                                        v-model="orderInfoShippingAddress.phone_number"
                                    ></FormInput>
                                </div>
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <FormInput
                                        :label="useTrans('order.address1')"
                                        :name="'address_line_1'"
                                        :type="'text'"
                                        v-model="orderInfoShippingAddress.address_line_1"
                                    ></FormInput>
                                    <FormInput
                                        :label="useTrans('order.address2')"
                                        :name="'address_line_2'"
                                        :type="'text'"
                                        v-model="orderInfoShippingAddress.address_line_2"
                                    ></FormInput>
                                </div>
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <FormInput
                                        :label="useTrans('order.city')"
                                        :name="'city'"
                                        :type="'text'"
                                        v-model="orderInfoShippingAddress.city"
                                    ></FormInput>
                                    <FormInput
                                        :label="useTrans('order.postal_code')"
                                        :name="'pin_code'"
                                        :type="'text'"
                                        v-model="orderInfoShippingAddress.pin_code"
                                    ></FormInput>
                                </div>
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <FormInput
                                        :label="useTrans('order.country')"
                                        :name="'country'"
                                        :type="'text'"
                                        v-model="orderInfoShippingAddress.country"
                                    ></FormInput>
                                </div>
                            </div>
                            <div class="">
                                <p class="font-medium text-blue-600 dark:text-gray-400 my-4">
                                    {{ useTrans('order.user_details') }} :
                                </p>
                                <FormInput
                                    :label="useTrans('order.user_id')"
                                    :name="'user_id'"
                                    :type="'text'"
                                    :error="errors.user_id"
                                    v-model="orderInfo.user_id"
                                ></FormInput>
                                <p class="font-medium text-blue-600 dark:text-gray-400 my-4">
                                    Order Status:
                                </p>
                                <FormSelect
                                    :label="useTrans('order.change_order_status')"
                                    :name="'status'"
                                    v-model="orderInfo.status"
                                    :error="errors.status"
                                    :optionsArray="[
                    { value: useTrans('order.unpaid') },
                    { value: useTrans('order.paid') },
                    { value: useTrans('order.shipped') },
                    { value: useTrans('order.delivered') },
                    { value: useTrans('order.cancelled') },
                  ]"
                                    :optionName="'value'"
                                    :optionValue="'value'"
                                >
                                </FormSelect>
                                <p class="font-medium text-blue-600 dark:text-gray-400 my-4">
                                    {{ useTrans('order.payment_details') }} :
                                </p>
                                <FormSelect
                                    :label="useTrans('order.payment_details')"
                                    :name="'payment_method'"
                                    v-model="orderInfo.payment_mode"
                                    :error="errors.payment_mode"
                                    :optionsArray="[{ value: 'cod' }, { value: 'stripe' }]"
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
                                @click.prevent="updateOrder()"
                                :text="useTrans('order.update_order')"
                                :color="'blue'"
                            ></Button>
                            <Button
                                @click.prevent="deleteOrder()"
                                :text="useTrans('order.delete_order')"
                                :disableFlash="true"
                                :color="'red'"
                            ></Button>
                        </div>
                    </div>
                </form>
            </div>

            <div
                class="relative p-4 bg-blue-100 border border-blue-100 rounded-lg shadow dark:border-gray-700 dark:bg-gray-800 sm:p-5 my-6"
            >
                <div class="bg-blue-100 px-3 rounded pb-4">
                    <p class="font-medium text-blue-600 dark:text-gray-400 my-4">{{ useTrans('order.order_details') }}:</p>
                    <div>
                        <label
                            for="description"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{useTrans('order.order_items')}}</label
                        >

                        <div
                            class="text-sm font-medium my-3 text-gray-500"
                            v-if="orderContent.length < 1"
                        >
                            {{useTrans('order.no_order_items')}}
                        </div>

                        <div class="relative overflow-x-auto border rounded-lg my-2" v-else>
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-blue-50 dark:bg-gray-700 dark:text-gray-400"
                                >
                                <tr>
                                    <th scope="col" class="px-6 py-3">{{useTrans('product.product_id')}}</th>
                                    <th scope="col" class="px-6 py-3">{{useTrans('product.product_name')}}</th>
                                    <th scope="col" class="px-6 py-3">{{useTrans('product.product_price')}}</th>
                                    <th scope="col" class="px-6 py-3">{{useTrans('product.product_qty')}}</th>
                                    <th scope="col" class="px-6 py-3"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                    v-for="orderItem in orderContent"
                                    :key="orderItem"
                                >
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    >
                                        {{ orderItem.id }}
                                    </th>
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    >
                                        {{ orderItem.name }}
                                    </th>
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    >
                                        {{ orderItem.price }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ orderItem.quantity }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 35 35"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            @click="deleteOrderItem(orderItem)"
                                            class="w-6 h-6 text-red-400 hover:cursor-pointer hover:text-red-700"
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
                    <div class="grid sm:grid-cols-2">
                        <div class="p-2 bg-blue-50 rounded-lg">
                            <label
                                for="description"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >{{useTrans('product.add_product')}}</label
                            >
                            <div class="grid gap-4 sm:grid-cols-2">
                                <FormInput
                                    :label="'Product ID'"
                                    :name="'product_id'"
                                    :type="'number'"
                                    v-model="newOrderItem.id"
                                ></FormInput>
                                <FormInput
                                    :label="'Product Name'"
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
                                    :disableFlash="true"
                                    :text="useTrans('product.create_product')"
                                    :color="'blue'"
                                ></Button>
                            </div>
                        </div>
                        <div class="p-5 pb-0 flex flex-col justify-between">
                            <div>
                                <label class="text-md font-medium text-gray-900"
                                >{{useTrans('product.total_amount')}}: {{ totalAmount }}</label
                                ><br/>
                                <label class="text-md font-medium text-gray-900"
                                >{{useTrans('product.total_product_count')}}: {{ orderContent.length }}</label
                                ><br/>
                            </div>

                            <div>
                                <Errors :errors="errors ?? false"></Errors>

                                <div class="flex items-center space-x-4">
                                    <Button
                                        @click.prevent="updateOrder()"
                                        :text="useTrans('product.update_order')"
                                        :color="'blue'"
                                    ></Button>
                                    <Button
                                        @click.prevent="deleteOrder()"
                                        :text="useTrans('product.delete_order')"
                                        :disableFlash="true"
                                        :color="'red'"
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
import {router} from "@inertiajs/vue3";
import {useForm} from "@inertiajs/vue3";
import {useTrans} from "../../../composables/trans";

export default {
    props: ["order", "errors"],
    data() {
        return {
            orderInfo: this.order,
            orderInfoShippingAddress: JSON.parse(this.order.shipping_address),
            orderContent: JSON.parse(this.order.cart_content),
            newOrderItem: {},
            form: {},
            deleteAlertOrder: false,
            deleteAlertOrderText: "",
        };
    },
    computed: {
        totalAmount() {
            var total = 0;
            this.orderContent.forEach((element) => {
                total += element.price * element.quantity;
            });
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
        deleteOrder() {
            window.scrollTo(0, 0);
            this.deleteAlertOrder = true;
            this.deleteAlertOrderText = useTrans('product.are_you_sure');
            setTimeout(() => (this.deleteAlertOrder = false), 5000);
        },
        deleteOrderConfirm() {
            router.delete(`/admin-dashboard/orders/${this.order.id}`);
        },
        updateOrder() {
            this.orderInfo.shipping_address = JSON.stringify(this.orderInfoShippingAddress);
            this.orderInfo.cart_content = JSON.stringify(this.orderContent);
            this.form = useForm(this.orderInfo);
            console.log(this.orderInfo);
            this.form.put(`/admin-dashboard/orders/${this.order.id}`, {
                preserveScroll: true,
            });
        },
    },
};
</script>
<script setup>
import {onMounted, onUpdated} from "vue";
import {initFlowbite} from "flowbite";
import Breadcrump from "../../../Shared/AdminDashboardComponents/Breadcrump.vue";
import ModalHeader from "../../../Shared/AdminDashboardComponents/ModalHeader.vue";
import FormInput from "../../../Shared/FormComponents/FormInput.vue";
import FormSelect from "../../../Shared/FormComponents/FormSelect.vue";
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
