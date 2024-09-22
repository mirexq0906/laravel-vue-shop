<template>
    <silder :items="items">
        <template #item>
            <div class="overflow-hidden rounded-lg" style="height: 367px">
                <img
                    class="h-full object-cover"
                    src="https://via.placeholder.com/2000X500/24f355"
                />
            </div>
        </template>
    </silder>
</template>
<script>
import Silder from "@/components/common/Silder.vue";
export default {
    components: {
        Silder,
    },
    data() {
        return {
            items: [{}, {}, {}, {}, {}, {}, {}],
        };
    },
};
</script>

<style></style>
