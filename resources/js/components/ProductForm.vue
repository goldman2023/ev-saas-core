<template>
<form class="laraform-bs4" @submit.prevent="submit">
    <!-- General Information Card -->
    <div class="card">
        <!-- Header -->
        <div class="card-header">
            <h5 class="card-header-title">{{ schema.general_information_title.defaultValue }}</h5>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                        <TextElement
                            name="name"
                            :schema="schema.name"
                            v-ref:elements$
                        />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <SelectElement
                            name="unit"
                            :schema="schema.unit"
                            v-ref:elements$
                        />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                        <SelectElement
                            name="category_id"
                            :schema="schema.category_id"
                            v-ref:elements$
                        />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <SelectElement
                            name="brand_id"
                            :schema="schema.brand_id"
                            v-ref:elements$
                        />
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <TagsElement
                            name="tags"
                            :schema="schema.tags"
                            v-ref:elements$
                        />
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- END General Information Card -->
</form>
</template>

<script>
export default {
    name: "ProductForm",
    mixins: [Laraform],
    data() {
        return {
            schema: {

            }
        }
    }
}
</script>

<style scoped>

</style>
