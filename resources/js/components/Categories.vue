<template>
    <div>
        <h1 class="title">All categories</h1>

        <div class="box" v-if="categories.length > 0">
            <category
                v-for="category in categories"
                :category="category"
                :key="'category-' + category.id"
            ></category>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['categories'],
        created() {
            console.log(this.categories);
        }
    };
</script>
