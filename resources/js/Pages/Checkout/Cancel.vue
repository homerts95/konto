<template>
  <div class="relative isolate overflow-hidden bg-gray-900 py-48 sm:py-56">
    <img
      src="https://images.pexels.com/photos/4439425/pexels-photo-4439425.jpeg?auto=compress"
      alt=""
      class="absolute inset-0 -z-10 h-full w-full object-cover object-left md:object-top opacity-20"
    />
    <div
      class="hidden sm:absolute sm:-top-10 sm:right-1/2 sm:-z-10 sm:mr-10 sm:block sm:transform-gpu sm:blur-3xl"
      aria-hidden="true"
    >
      <div
        class="aspect-[1097/845] w-[100.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20"
        style="
          clip-path: polygon(
            74.1% 44.1%,
            100% 61.6%,
            97.5% 26.9%,
            85.5% 0.1%,
            80.7% 2%,
            72.5% 32.5%,
            60.2% 62.4%,
            52.4% 68.1%,
            47.5% 58.3%,
            45.2% 34.5%,
            27.5% 76.7%,
            0.1% 64.9%,
            17.9% 100%,
            27.6% 76.8%,
            76.1% 97.7%,
            74.1% 44.1%
          );
        "
      />
    </div>
    <div
      class="absolute -top-52 left-1/2 -z-10 -translate-x-1/2 transform-gpu blur-3xl sm:top-[-28rem] sm:ml-16 sm:translate-x-0 sm:transform-gpu"
      aria-hidden="true"
    >
      <div
        class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20"
        style="
          clip-path: polygon(
            74.1% 44.1%,
            100% 61.6%,
            97.5% 26.9%,
            85.5% 0.1%,
            80.7% 2%,
            72.5% 32.5%,
            60.2% 62.4%,
            52.4% 68.1%,
            47.5% 58.3%,
            45.2% 34.5%,
            27.5% 76.7%,
            0.1% 64.9%,
            17.9% 100%,
            27.6% 76.8%,
            76.1% 97.7%,
            74.1% 44.1%
          );
        "
      />
    </div>
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <div class="mx-auto max-w-2xl lg:mx-0">
        <h2 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">
          Oops.! Something went wrong
        </h2>
        <p class="mt-6 text-lg leading-8 text-gray-300">
          Order complete & Payment Unsuccessful
        </p>
      </div>
    </div>
  </div>
  <div class="mx-auto max-w-5xl px-6 lg:px-8 my-20">
    <div class="mx-auto max-w-2xl lg:mx-0">
      <div class="text-gray-600 tracking-wide">
        <p>
          Your order is complete. Order status :
          <span
            class="text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300 bg-yellow-100 text-yellow-800"
          >
            Unpaid</span
          >
        </p>
        <p class="my-4">
          <Link
            href="/dashboard/orders"
            class="hover:underline font-medium text-indigo-600"
            >Visit Orders Dashboard</Link
          >
          or
          <Link href="/" class="hover:underline font-medium text-indigo-600"
            v-text="useTrans('cancel.continue_shopping_with_us')"></Link
          >
        </p>
      </div>
    </div>
  </div>
</template>
<script>
import {useTrans} from "../../composables/trans";

export default {
    methods: {useTrans},
  props: ["aboutPageContent"],
};
</script>
