<template>
    <section class="py-5">
        <div class="container">
            <h1 class="mb-3 text-3xl">Профиль</h1>
            <DataTable
                :value="data"
                showGridlines
                tableStyle="min-width: 50rem"
            >
                <Column header="Параметр" field="name" />
                <Column header="Значение" field="value" />
            </DataTable>
        </div>
    </section>
</template>
<script setup>
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { ref, computed } from "vue";
import { useStore } from "vuex";

const store = useStore();
const name = computed(() => store.state.userData.name);
const email = computed(() => store.state.userData.email);
const created_at = computed(() => store.state.userData.created_at);
const updated_at = computed(() => store.state.userData.updated_at);

const data = ref([
    { name: "Наименование", value: name },
    { name: "Email", value: email },
    { name: "Дата создания", value: created_at },
    { name: "Дата редактирования", value: updated_at },
]);
</script>
