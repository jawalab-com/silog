<script setup>
import { ref, computed, onMounted } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import ApexCharts from 'apexcharts';

const props = defineProps({
    pengeluaran: Array,
    sumHutang: Number,
    countBelumSelesai: Number,
    countSelesai: Number,
    countPengajuan: Number,
    kategori_pengeluaran_terbanyak: Array,
    supplier_terbanyak: Array,
    brand_terbanyak: Array,
    stok_keluar_terbanyak: Array,
    stok_keluar_terkecil: Array,
});

const options = {
    chart: {
        height: "100%",
        maxWidth: "100%",
        type: "line",
        fontFamily: "Inter, sans-serif",
        dropShadow: {
            enabled: false,
        },
        toolbar: {
            show: false,
        },
        zoom: {
            enabled: false,
        }
    },
    tooltip: {
        enabled: true,
        x: {
            show: false,
        },
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        width: 6,
    },
    title: {
        text: "Total pengeluaran tiap bulan",
        align: "center"
    },
    grid: {
        show: true,
        strokeDashArray: 4,
        padding: {
            left: 2,
            right: 2,
            top: -26
        },
    },
    series: [
        {
            name: "sudah selesai + sudah lunas",
            data: props.pengeluaran.paid,
            color: "#1A56DB",
        },
        {
            name: "belum lunas",
            data: props.pengeluaran.not_paid,
            color: "#7E3AF2",
        },
    ],
    legend: {
        show: true
    },
    stroke: {
        curve: 'smooth'
    },
    xaxis: {
        categories: props.pengeluaran.labels,
        labels: {
            show: true,
            style: {
                fontFamily: "Inter, sans-serif",
                cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
            }
        },
        axisBorder: {
            show: false,
        },
        axisTicks: {
            show: false,
        },
    },
    yaxis: {
        show: false,
    },
}

const getPieChartOptionsA = () => {
    return {
        series: props.kategori_pengeluaran_terbanyak.series,
        colors: ["#1C64F2", "#16BDCA", "#9061F9", "#AF4500", "#6BAF24"],
        chart: {
            height: 420,
            width: "100%",
            type: "pie",
        },
        stroke: {
            colors: ["white"],
            lineCap: "",
        },
        title: {
            text: "Kategori dengan pengeluaran terbanyak",
            align: "center"
        },
        plotOptions: {
            pie: {
                labels: {
                    show: true,
                },
                size: "100%",
                dataLabels: {
                    offset: -25
                }
            },
        },
        labels: props.kategori_pengeluaran_terbanyak.labels,
        dataLabels: {
            enabled: true,
            style: {
                fontFamily: "Inter, sans-serif",
            },
        },
        legend: {
            position: "bottom",
            fontFamily: "Inter, sans-serif",
        },
        yaxis: {
            labels: {
                formatter: function (value) {
                    return value + "%"
                },
            },
        },
        xaxis: {
            labels: {
                formatter: function (value) {
                    return value + "%"
                },
            },
            axisTicks: {
                show: false,
            },
            axisBorder: {
                show: false,
            },
        },
    }
}

const getPieChartOptionsB = () => {
    return {
        series: props.supplier_terbanyak.series,
        colors: ["#1C64F2", "#16BDCA", "#9061F9", "#AF4500", "#6BAF24"],
        chart: {
            height: 420,
            width: "100%",
            type: "pie",
        },
        stroke: {
            colors: ["white"],
            lineCap: "",
        },
        title: {
            text: "Supplier Paling banyak digunakan",
            align: "center"
        },
        plotOptions: {
            pie: {
                labels: {
                    show: true,
                },
                size: "100%",
                dataLabels: {
                    offset: -25
                }
            },
        },
        labels: props.supplier_terbanyak.labels,
        dataLabels: {
            enabled: true,
            style: {
                fontFamily: "Inter, sans-serif",
            },
        },
        legend: {
            position: "bottom",
            fontFamily: "Inter, sans-serif",
        },
        yaxis: {
            labels: {
                formatter: function (value) {
                    return value + "%"
                },
            },
        },
        xaxis: {
            labels: {
                formatter: function (value) {
                    return value + "%"
                },
            },
            axisTicks: {
                show: false,
            },
            axisBorder: {
                show: false,
            },
        },
    }
}

const getPieChartOptionsC = () => {
    return {
        series: props.brand_terbanyak.series,
        colors: ["#1C64F2", "#16BDCA", "#9061F9", "#AF4500", "#6BAF24"],
        chart: {
            height: 420,
            width: "100%",
            type: "pie",
        },
        stroke: {
            colors: ["white"],
            lineCap: "",
        },
        title: {
            text: "Merk paling banyak dibeli",
            align: "center"
        },
        plotOptions: {
            pie: {
                labels: {
                    show: true,
                },
                size: "100%",
                dataLabels: {
                    offset: -25
                }
            },
        },
        labels: props.brand_terbanyak.labels,
        dataLabels: {
            enabled: true,
            style: {
                fontFamily: "Inter, sans-serif",
            },
        },
        legend: {
            position: "bottom",
            fontFamily: "Inter, sans-serif",
        },
        yaxis: {
            labels: {
                formatter: function (value) {
                    return value + "%"
                },
            },
        },
        xaxis: {
            labels: {
                formatter: function (value) {
                    return value + "%"
                },
            },
            axisTicks: {
                show: false,
            },
            axisBorder: {
                show: false,
            },
        },
    }
}

const optionsColumnA = {
    colors: ["#1A56DB", "#FDBA8C"],
    series: [
        {
            name: "Social media",
            color: "#77DD77",
            data: props.stok_keluar_terbanyak,
        },
    ],
    chart: {
        type: "bar",
        height: "320px",
        fontFamily: "Inter, sans-serif",
        toolbar: {
            show: false,
        },
    },
    plotOptions: {
        bar: {
            horizontal: true,
            columnWidth: "70%",
            borderRadiusApplication: "end",
            borderRadius: 8,
        },
    },
    tooltip: {
        shared: true,
        intersect: false,
        style: {
            fontFamily: "Inter, sans-serif",
        },
    },
    states: {
        hover: {
            filter: {
                type: "darken",
                value: 1,
            },
        },
    },
    stroke: {
        show: true,
        width: 0,
        colors: ["transparent"],
    },
    title: {
        text: "Stok barang paling banyak keluar bulan ini",
        align: "center"
    },
    grid: {
        show: false,
        strokeDashArray: 4,
        padding: {
            left: 2,
            right: 2,
            top: -14
        },
    },
    dataLabels: {
        enabled: false,
    },
    legend: {
        show: false,
    },
    xaxis: {
        floating: false,
        labels: {
            show: true,
            style: {
                fontFamily: "Inter, sans-serif",
                cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
            }
        },
        axisBorder: {
            show: false,
        },
        axisTicks: {
            show: false,
        },
    },
    yaxis: {
        show: true,
    },
    fill: {
        opacity: 1,
    },
}

const optionsColumnB = {
    colors: ["#1A56DB", "#FDBA8C"],
    series: [
        {
            name: "Social media",
            color: "#FF6961",
            data: props.stok_keluar_terkecil,
        },
    ],
    chart: {
        type: "bar",
        height: "320px",
        fontFamily: "Inter, sans-serif",
        toolbar: {
            show: false,
        },
    },
    plotOptions: {
        bar: {
            horizontal: true,
            columnWidth: "70%",
            borderRadiusApplication: "end",
            borderRadius: 8,
        },
    },
    tooltip: {
        shared: true,
        intersect: false,
        style: {
            fontFamily: "Inter, sans-serif",
        },
    },
    states: {
        hover: {
            filter: {
                type: "darken",
                value: 1,
            },
        },
    },
    stroke: {
        show: true,
        width: 0,
        colors: ["transparent"],
    },
    title: {
        text: "Stok barang paling jarang keluar bulan ini",
        align: "center"
    },
    grid: {
        show: false,
        strokeDashArray: 4,
        padding: {
            left: 2,
            right: 2,
            top: -14
        },
    },
    dataLabels: {
        enabled: false,
    },
    legend: {
        show: false,
    },
    xaxis: {
        floating: false,
        labels: {
            show: true,
            style: {
                fontFamily: "Inter, sans-serif",
                cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
            }
        },
        axisBorder: {
            show: false,
        },
        axisTicks: {
            show: false,
        },
    },
    yaxis: {
        show: true,
    },
    fill: {
        opacity: 1,
    },
}

if (document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
    const chart = new ApexCharts(document.getElementById("column-chart"), options);
    chart.render();
}

if (document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
    const chart = new ApexCharts(document.getElementById("column-chart"), options);
    chart.render();
}


onMounted(() => {
    if (document.getElementById("line-chart") && typeof ApexCharts !== 'undefined') {
        console.log(document.getElementById("line-chart"));
        const chart = new ApexCharts(document.getElementById("line-chart"), options);
        chart.render();
    }
    if (document.getElementById("pie-chart-a") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("pie-chart-a"), getPieChartOptionsA());
        chart.render();
    }
    if (document.getElementById("pie-chart-b") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("pie-chart-b"), getPieChartOptionsB());
        chart.render();
    }
    if (document.getElementById("pie-chart-c") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("pie-chart-c"), getPieChartOptionsC());
        chart.render();
    }
    if (document.getElementById("column-chart-a") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("column-chart-a"), optionsColumnA);
        chart.render();
    }
    if (document.getElementById("column-chart-b") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("column-chart-b"), optionsColumnB);
        chart.render();
    }
});

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <!-- <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard
            </h2> -->
        </template>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <div
                class="border-2 border-gray-300 rounded-lg dark:border-gray-600 h-16 md:h-32 bg-blue-200 dark:bg-blue-800">
                <div class="flex flex-col justify-between h-full px-4 py-2">
                    <dt class="text-3xl md:text-3xl font-extrabold">
                        {{
                            new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(sumHutang)
                        }}
                    </dt>
                    <dd class="font-light text-gray-700 dark:text-gray-300 text-lg">Total hutang (belum lunas)</dd>
                </div>
            </div>
            <div
                class="border-2 border-gray-300 rounded-lg dark:border-gray-600 h-16 md:h-32 bg-blue-200 dark:bg-blue-800">
                <div class="flex flex-col justify-between h-full px-4 py-2">
                    <dt class="text-3xl md:text-4xl font-extrabold">{{ countBelumSelesai }}</dt>
                    <dd class="font-light text-gray-700 dark:text-gray-300 text-lg">Total pengajuan belum selesai</dd>
                </div>
            </div>
            <div
                class="border-2 border-gray-300 rounded-lg dark:border-gray-600 h-16 md:h-32 bg-blue-200 dark:bg-blue-800">
                <div class="flex flex-col justify-between h-full px-4 py-2">
                    <dt class="text-3xl md:text-4xl font-extrabold">{{ countSelesai }}</dt>
                    <dd class="font-light text-gray-700 dark:text-gray-300 text-lg">Total pengajuan yang sudah selesai
                    </dd>
                </div>
            </div>
            <div
                class="border-2 border-gray-300 rounded-lg dark:border-gray-600 h-16 md:h-32 bg-blue-200 dark:bg-blue-800">
                <div class="flex flex-col justify-between h-full px-4 py-2">
                    <dt class="text-3xl md:text-4xl font-extrabold">{{ countPengajuan }}</dt>
                    <dd class="font-light text-gray-700 dark:text-gray-300 text-lg">Total Pengajuan bulan ini</dd>
                </div>
            </div>
        </div>
        <div class="border-2 rounded-lg border-gray-300 dark:border-gray-600 h-96 mb-4 p-4 bg-gray-100 dark:bg-black">
            <div id="line-chart"></div>
        </div>
        <div class="grid lg:grid-cols-3 grid-cols-2 gap-4 mb-4">
            <div class="border-2 rounded-lg border-gray-300 dark:border-gray-600 p-4 bg-gray-100 dark:bg-black">
                <div id="pie-chart-a"></div>
            </div>
            <div class="border-2 rounded-lg border-gray-300 dark:border-gray-600 p-4 bg-gray-100 dark:bg-black">
                <div id="pie-chart-b"></div>
            </div>
            <div class="border-2 rounded-lg border-gray-300 dark:border-gray-600 p-4 bg-gray-100 dark:bg-black">
                <div id="pie-chart-c"></div>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div class="border-2 rounded-lg border-gray-300 dark:border-gray-600 p-4 bg-gray-100 dark:bg-black">
                <div id="column-chart-a"></div>
            </div>
            <div class="border-2 rounded-lg border-gray-300 dark:border-gray-600 p-4 bg-gray-100 dark:bg-black">
                <div id="column-chart-b"></div>
            </div>
        </div>
        <div class="h-80"></div>
    </AppLayout>
</template>
