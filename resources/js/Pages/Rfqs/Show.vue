<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { ref, computed, watch } from "vue";
import axios from "axios";
import AppLayout from "@/Layouts/AppLayout.vue";
import utils from "@/utils";

const props = defineProps({
    rfq: Object,
    tagSuppliers: Object,
    rfqStatus: Object,
    suppliers: Array,
    rfqComments: Array,
    histories: Array,
});

const title = "Pengajuan Barang";

const form = useForm({
    _method: props.rfq.id ? "put" : "post",
    user_id: props.rfq?.user_id || "",
    rfq_number: props.rfq?.rfq_number,
    title: props.rfq?.title,
    request_date: formattedDate,
    total_amount: props.rfq?.total_amount || "",
    verified: null,
    status: props.rfq?.status || "",
    comment: props.rfq?.comment || "",
    products: Array.isArray(props.rfq?.products)
        ? props.rfq?.products
        : [],
    rfq_details: props.rfq?.rfq_details || [],
    rfq_suppliers: props.rfq?.rfq_suppliers || [],
    suppliers:
        props.rfq?.suppliers?.map((supplier) => ({
            rfq_id: supplier.rfq_id || "",
            tag: supplier.tag || "",
            supplier_id: supplier.supplier_id || "",
            po_number: supplier.po_number || "",
            discount: supplier.discount || "",
            tax: supplier.tax || "",
            transportation: supplier.transportation || "",
            file_proof: supplier.file_proof || null,
            file_invoice: supplier.file_invoice || null,
            file_receipt: supplier.file_receipt || null,
            file_proof_path: null,
            file_invoice_path: null,
            file_receipt_path: null,
            date_sent: supplier.date_sent || "",
            date_received: supplier.date_received || "",
            received: supplier.received || false,
            paid: supplier.paid || false,
        })) || [],
});

const selectedAddProduct = ref(null);
const selectedAddSupplier = ref(-1);
const selectedSupplier = ref(props.rfq?.suppliers?.[0]?.id || null);

var formattedDate;
if (props.rfq?.request_date == null) {
    const isoDate = new Date().toISOString().split("T")[0]; // YYYY-MM-DD format
    const [year, month, day] = isoDate.split("-");
    formattedDate = `${day}-${month}-${year}`; // dd-mm-YYYY format
} else {
    const [year, month, day] = props.rfq?.request_date.split("-");
    formattedDate = `${day}-${month}-${year}`; // dd-mm-YYYY format
}

let supplierNewId = -1;
const addSupplier = () => {
    const supplier = props.suppliers.find((supplier) => supplier.id == selectedAddSupplier.value);
    form.rfq_suppliers.push({
        id: supplierNewId,
        rfq_id: props.rfq.id,
        tag: supplier?.tag,
        supplier_id: supplier?.id,
        supplier: { supplier_name: supplier?.supplier_name },
        products: [],
    });
    selectedSupplier.value = supplierNewId;
    selectedAddSupplier.value = null;
    supplierNewId -= 1;
}

let productNewId = -1;
const addProduct = () => {
    const product = props.rfq?.rfq_details.find((x) => x.product.id == selectedAddProduct.value);
    const supplier = form.rfq_suppliers.find((x) => x.id == selectedSupplier.value);
    console.log({
        id: productNewId,
        rfq_id: props.rfq.id,
        tag: product?.tag,
        product_id: product?.product_id,
        product: { product_name: product?.product?.product_name },
    });
    supplier.products.push({
        id: productNewId,
        rfq_id: props.rfq.id,
        tag: product?.tag,
        product_id: product?.product_id,
        product: {
            product_name: product?.product?.product_name,
            tag: { tag_name: product?.product?.tag?.tag_name },
        },
        unit: { unit_name: product?.unit?.unit_name },
        quantity: product?.quantity,
    });
    selectedAddProduct.value = null;
    productNewId -= 1;
}
</script>

<template>
    <AppLayout :title="title">
        <Card class="border border-gray-400 dark:border-gray-600">
            <template #title>Pengajuan Barang</template>
            <template #content>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-400">Barang Diajukan</h3>
                <div class="border-2 border-gray-300 dark:border-gray-700 rounded-lg p-1">
                    <DataTable :value="rfq?.rfq_details" size="small">
                        <Column field="product.tag.tag_name" header="Kategori"></Column>
                        <Column field="product.product_name" header="Nama Barang"></Column>
                        <Column field="unit.unit_name" header="Satuan"></Column>
                        <Column field="quantity" header="Quantity"></Column>
                    </DataTable>
                </div>

                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-400 mt-4">Supplier</h3>
                <InputGroup>
                    <Select filter v-model="selectedAddSupplier"
                        :options="[{ id: null, supplier_name: '&nbsp;' }].concat(suppliers)" optionLabel="supplier_name"
                        optionValue="id" size="small" />
                    <InputGroupAddon>
                        <Button icon="pi pi-plus" label="Tambah Supplier" severity="secondary" variant="text"
                            size="small" @click="addSupplier" />
                    </InputGroupAddon>
                </InputGroup>

                <Tabs :value="selectedSupplier">
                    <TabList>
                        <Tab v-for="tab in form.rfq_suppliers" :key="tab.id" :value="tab.id">
                            {{
                                suppliers.find((supplier) => supplier.id == tab.supplier_id)?.supplier_name
                                || '<kosong>'
                            }}
                        </Tab>
                    </TabList>
                    <TabPanels>
                        <TabPanel v-for="tab in form.rfq_suppliers" :key="tab.id" :value="tab.id">
                            <div class="mt-2 flex items-center justify-between">
                                <Select v-model="selectedAddProduct"
                                    :options="rfq?.rfq_details.filter((detail) => !tab.products?.some((product) => product.product_id === detail.product_id))"
                                    optionLabel="product.product_name" optionValue="product.id" size="small"
                                    class="flex-1" />
                                <Button icon="pi pi-plus" label="Tambah Barang" outlined size="small" class="mx-2"
                                    @click="addProduct" />

                                <label class="mx-2">Supplier</label>
                                <Select filter v-model="tab.supplier_id"
                                    :options="[{ id: null, supplier_name: '<kosong>' }].concat(suppliers)"
                                    optionLabel="supplier_name" optionValue="id" size="small" class="flex-1 mx-2" />
                                <Button label="Hapus" class="mx-2" severity="danger" outlined size="small" />
                            </div>

                            <div v-if="tab?.products.length > 0"
                                class="border-2 border-gray-300 dark:border-gray-700 rounded-lg p-1 my-4">
                                <DataTable :value="tab?.products" size="small">
                                    <Column field="product.tag.tag_name" header="Kategori"></Column>
                                    <Column field="product.product_name" header="Nama Barang"></Column>
                                    <Column field="unit.unit_name" header="Satuan"></Column>
                                    <Column field="quantity" header="Quantity"></Column>
                                </DataTable>
                            </div>

                            <!-- {{ tab.products }} -->

                            <p class="mt-4">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                <!-- {{ tab }} -->
                            </p>
                        </TabPanel>
                    </TabPanels>
                </Tabs>
            </template>
            <template #footer>
                <div class="flex gap-4 mt-1">
                    <Button label="Cancel" severity="secondary" outlined class="w-full" />
                    <Button label="Save" class="w-full" />
                </div>
            </template>
        </Card>
    </AppLayout>
</template>
