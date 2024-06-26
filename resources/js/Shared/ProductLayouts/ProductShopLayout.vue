<template>
  <div class="bg-white">
    <div>
      <!-- Mobile filter dialog -->
      <TransitionRoot as="template" :show="mobileFiltersOpen">
        <Dialog
          as="div"
          class="relative z-40 lg:hidden"
          @close="mobileFiltersOpen = false"
        >
          <TransitionChild
            as="template"
            enter="transition-opacity ease-linear duration-300"
            enter-from="opacity-0"
            enter-to="opacity-100"
            leave="transition-opacity ease-linear duration-300"
            leave-from="opacity-100"
            leave-to="opacity-0"
          >
            <div class="fixed inset-0 bg-black bg-opacity-25" />
          </TransitionChild>

          <div class="fixed inset-0 z-40 flex">
            <TransitionChild
              as="template"
              enter="transition ease-in-out duration-300 transform"
              enter-from="translate-x-full"
              enter-to="translate-x-0"
              leave="transition ease-in-out duration-300 transform"
              leave-from="translate-x-0"
              leave-to="translate-x-full"
            >
              <DialogPanel
                class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl"
              >
                <div class="flex items-center justify-between px-4">
                  <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                  <button
                    type="button"
                    class="-mr-2 flex h-10 w-10 items-center justify-center rounded-md bg-white p-2 text-gray-400"
                    @click="mobileFiltersOpen = false"
                  >
                    <span class="sr-only">Close menu</span>
                    <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                  </button>
                </div>

                <!-- Filters -->
                <form class="mt-4 border-t border-gray-200">
                  <h3 class="sr-only">Categories</h3>
                  <ul role="list" class="px-2 py-3 font-medium text-gray-900">
                    <li v-for="option in tagOptions" :key="option.name">
                      <p
                        class="block px-2 py-3"
                        @click="tagValue = option.value"
                        :class="{
                          'text-blue-700': $page.props.filters.tag
                            ? JSON.parse($page.props.filters.tag).includes(option.value)
                            : false,
                        }"
                      >
                        {{ option.name }}
                      </p>
                    </li>
                  </ul>

                  <Disclosure
                    as="div"
                    v-for="section in filters"
                    :key="section.id"
                    :defaultOpen="$page.props.filters.category"
                    class="border-t border-gray-200 px-4 py-6"
                    v-slot="{ open }"
                  >
                    <h3 class="-mx-2 -my-3 flow-root">
                      <DisclosureButton
                        class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500"
                      >
                        <span class="font-medium text-gray-900">{{ section.name }}</span>
                        <span class="ml-6 flex items-center">
                          <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
                          <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                        </span>
                      </DisclosureButton>
                    </h3>
                    <DisclosurePanel class="pt-6">
                      <div class="space-y-6">
                        <div
                          v-for="(option, optionIdx) in section.options"
                          :key="option.value"
                          class="flex items-center"
                        >
                          <input
                            :id="`filter-mobile-${section.id}-${optionIdx}`"
                            :name="`${section.id}[]`"
                            :value="option.value"
                            type="checkbox"
                            :checked="option.checked"
                            v-model="option.checked"
                            @change="createQuery"
                            class="h-4 w-4 rounded border-gray-300 text-blue-700 focus:ring-blue-500"
                          />
                          <label
                            :for="`filter-mobile-${section.id}-${optionIdx}`"
                            class="ml-3 min-w-0 flex-1 text-gray-500"
                            >{{ option.name }}</label
                          >
                        </div>
                      </div>
                    </DisclosurePanel>
                  </Disclosure>
                </form>
              </DialogPanel>
            </TransitionChild>
          </div>
        </Dialog>
      </TransitionRoot>

      <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div
          class="flex items-baseline justify-between border-b border-gray-200 pb-6 pt-14"
        >
          <h1 class="text-4xl font-bold tracking-tight text-gray-900">{{ title }}</h1>

          <div class="flex items-center">
            <Menu as="div" class="relative inline-block text-left">
              <div>
                <MenuButton
                  class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900"
                v-text="useTrans('shop.sort')">


                </MenuButton>
              </div>

              <transition
                enter-active-class="transition ease-out duration-100"
                enter-from-class="transform opacity-0 scale-95"
                enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75"
                leave-from-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95"
              >
                <MenuItems
                  class="absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none"
                >
                  <div class="py-1">
                    <MenuItem
                      v-for="option in sortByOptions"
                      :key="option.name"
                      v-slot="{ active }"
                    >
                      <p
                        :class="[
                          option.value === sortByValue
                            ? 'font-medium text-gray-900'
                            : 'text-gray-500',
                          active ? 'bg-gray-100' : '',
                          'block px-4 py-2 text-sm',
                        ]"
                        @click="sortByValue = option.value"
                      >
                        {{ option.name }}
                      </p>
                    </MenuItem>
                  </div>
                </MenuItems>
              </transition>
            </Menu>

            <!-- <button
              type="button"
              class="-m-2 ml-5 p-2 text-gray-400 hover:text-gray-500 sm:ml-7"
            >
              <span class="sr-only">View grid</span>
              <Squares2X2Icon class="h-5 w-5" aria-hidden="true" />
            </button> -->
            <button
              type="button"
              class="-m-2 ml-4 p-2 text-gray-400 hover:text-gray-500 sm:ml-6 lg:hidden"
              @click="mobileFiltersOpen = true"
            >
              <span class="sr-only">Filters</span>
              <FunnelIcon class="h-5 w-5" aria-hidden="true" />
            </button>
          </div>
        </div>

        <section aria-labelledby="products-heading" class="pb-24 pt-6">
          <h2 id="products-heading" class="sr-only">Products</h2>

          <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
            <!-- Filters -->
            <form class="hidden lg:block">
              <h3 class="sr-only">Categories</h3>
              <ul
                role="list"
                class="space-y-4 border-b border-gray-200 pb-6 text-sm font-medium text-gray-900"
              >
                <li v-for="option in tagOptions" :key="option.name">
                  <p
                    @click="tagValue = option.value"
                    class="cursor-pointer"
                    :class="{
                      'text-blue-700': $page.props.filters.tag
                        ? JSON.parse($page.props.filters.tag).includes(option.value)
                        : false,
                    }"
                  >
                    {{ option.name }}
                  </p>
                </li>
              </ul>

              <Disclosure
                as="div"
                v-for="section in filters"
                :key="section.id"
                :defaultOpen="$page.props.filters.category"
                class="border-b border-gray-200 py-6"
                v-slot="{ open }"
              >
                <h3 class="-my-3 flow-root">
                  <DisclosureButton
                    class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500"
                  >
                    <span class="font-medium text-gray-900">{{ section.name }}</span>
                    <span class="ml-6 flex items-center">
                      <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
                      <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                    </span>
                  </DisclosureButton>
                </h3>
                <DisclosurePanel class="pt-6">
                  <div class="space-y-4">
                    <div
                      v-for="(option, optionIdx) in section.options"
                      :key="option.value"
                      class="flex items-center"
                    >
                      <input
                        :id="`filter-${section.id}-${optionIdx}`"
                        :name="`${section.id}[]`"
                        :value="option.value"
                        type="checkbox"
                        :checked="option.checked"
                        v-model="option.checked"
                        @change="createQuery()"
                        class="h-4 w-4 rounded border-gray-300 text-blue-700 focus:ring-blue-500"
                      />
                      <label
                        :for="`filter-${section.id}-${optionIdx}`"
                        class="ml-3 text-sm text-gray-600"
                        >{{ option.name }}</label
                      >
                    </div>
                  </div>
                </DisclosurePanel>
              </Disclosure>
            </form>

            <!-- Product grid -->
            <div class="lg:col-span-3">
              <!-- Your content -->
              <slot></slot>
            </div>
          </div>
        </section>
      </main>
    </div>
  </div>
</template>

<script>
import {useTrans} from "../../composables/trans";

export default {
  props: ["title"],
  computed: {
    filters() {
      return [{ id: "categories", name: useTrans('shop.categories'), options: this.defaultCategories }];
    },
    defaultCategories() {
      return this.categories.map((item) => ({
        ...item,
        checked: JSON.parse(this.defaultFilters.category ?? "[]").includes(item.slug),
      }));
    },
  },
  watch: {
    sortByValue() {
      this.createQuery();
    },
    tagValue() {
      this.createQuery();
    },
    filters() {},
  },
  methods: {
    createQuery() {
      var selectedCategories = [];
      this.filters[0].options.map(function (option) {
        if (option.checked) {
          return selectedCategories.push(option.slug);
        }
      });
      selectedCategories.length
        ? (this.searchQuery.category = JSON.stringify(selectedCategories))
        : delete this.searchQuery.category;
      this.searchQuery.sortBy = this.sortByValue;
      this.tagValue
        ? (this.searchQuery.tag = JSON.stringify([this.tagValue]))
        : delete this.searchQuery.tag;
      this.sendRequest();
    },
    sendRequest() {
      router.get("/shop", this.searchQuery, {
        preserveState: true,
      });
    },
  },
  data() {
    return {
      categories: this.$page.props.categories,
      defaultFilters: this.$page.props.filters ?? [],
      searchQuery: {},
      sortByValue: this.$page.props.filters.sortBy ?? "date-dsc",
      sortByOptions: [
        { name: useTrans('shop.all'), value: "date-dsc" },
        { name: useTrans('shop.price_lower_to_higher'), value: "price-asc" },
        { name: useTrans('shop.price_higher_to_lower'), value: "price-dsc" },
      ],
      tagValue: this.$page.props.filters.tag ?? "",
      tagOptions: [
        { name: useTrans('shop.all'), value: "" },
        { name: useTrans('shop.beer'), value: "best_seller" },
        { name: useTrans('shop.gin'), value: "new_arrival" },
      ],
    };
  },
};
</script>

<script setup>
import { ref } from "vue";
import {
  Dialog,
  DialogPanel,
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { XMarkIcon } from "@heroicons/vue/24/outline";
import {
  ChevronDownIcon,
  FunnelIcon,
  MinusIcon,
  PlusIcon,
  Squares2X2Icon,
} from "@heroicons/vue/20/solid";
import { router } from "@inertiajs/core";

const mobileFiltersOpen = ref(false);
</script>
