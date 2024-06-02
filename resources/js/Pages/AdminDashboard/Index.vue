<template>
    <h1 class="text-xl font-medium text-gray-600">{{useTrans('welcome')}} {{ $page.props.auth.firstName }}</h1>
</template>
<script>
import {useTrans} from "../../composables/trans";
import {defineComponent} from "vue";

export default defineComponent({
    methods: {useTrans}
})

</script>
