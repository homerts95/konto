<template>
<!--    <HeroSliderNewVue-->
<!--        :hero_carousel="JSON.parse(homePageContent.hero_carousel_url)"-->
<!--    ></HeroSliderNewVue>-->
    <CategoryList :categories="categories"></CategoryList>
    <ProductsIndex
        :products="productBestSellers"
        :title="useTrans( 'home.best_sellers')"
        :cols="4"
        class="mb-10"
    ></ProductsIndex>
</template>
<script>
export default {
    props: ["homePageContent", "categories", "productBestSellers"],
};
</script>
<script setup>
import CategoryList from "../../Shared/HomePageComponents/CategoryList.vue";
import HeroSliderNewVue from "../../Shared/HomePageComponents/HeroSliderNew.vue";
import ProductsIndex from "./Products/ProductsIndex.vue";
import { useTrans } from "../../composables/trans";
</script>
