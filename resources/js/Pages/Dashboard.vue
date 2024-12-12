<script setup>
import { ref, computed, onMounted } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import ApexCharts from 'apexcharts';

const page = usePage();
const role = (page.props.auth.user.all_teams.find(team => team.id === page.props.auth.user.current_team_id)).membership?.role || 'owner';

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

const quotes = [
    "Pekerjaan besar tidak hanya tentang keterampilan teknis, tetapi juga kolaborasi dan komunikasi yang baik.",
    "Kesalahan adalah bagian dari belajar. Jangan takut untuk mencoba sesuatu yang baru.",
    "Ketelitian dalam pekerjaan adalah kunci untuk membangun sistem yang andal.",
    "Sistem yang baik tidak hanya bekerja, tetapi juga mudah digunakan.",
    "Ketika menghadapi masalah, fokuslah pada solusi, bukan hambatan.",
    "Belajar dari pengalaman adalah cara terbaik untuk menjadi ahli.",
    "Setiap baris kode adalah kontribusi kecil menuju perubahan besar.",
    "Inovasi adalah hasil dari kombinasi ide-ide sederhana yang dieksekusi dengan baik.",
    "Kegagalan adalah kesempatan untuk memulai lagi dengan lebih cerdas.",
    "Dalam tim, setiap individu adalah bagian penting dari kesuksesan.",
    "Kerja keras akan selalu mengalahkan bakat ketika bakat tidak bekerja keras.",
    "Sistem yang kompleks dimulai dari pemahaman sederhana.",
    "Jangan pernah berhenti belajar. Teknologi terus berkembang, dan begitu juga kita.",
    "Sistem yang baik adalah yang terus diperbaiki dan disempurnakan.",
    "Efisiensi adalah seni menyelesaikan pekerjaan dengan cara yang paling sederhana.",
    "Bekerja dengan hati akan menghasilkan sistem yang berarti.",
    "Jangan takut dengan tantangan baru. Mereka adalah peluang untuk tumbuh.",
    "Kolaborasi adalah kunci untuk menyelesaikan proyek besar.",
    "Waktu yang dihabiskan untuk merencanakan akan menghemat waktu yang dihabiskan untuk memperbaiki.",
    "Sistem terbaik adalah yang memenuhi kebutuhan pengguna dengan cara paling sederhana.",
    "Teknologi dibuat untuk membantu manusia, bukan sebaliknya.",
    "Keamanan adalah prioritas utama dalam setiap sistem informasi.",
    "Perubahan adalah hal yang pasti dalam dunia teknologi. Beradaptasilah.",
    "Setiap masalah memiliki solusi, hanya butuh waktu untuk menemukannya.",
    "Jangan mengabaikan umpan balik dari pengguna. Mereka adalah kunci untuk perbaikan.",
    "Kualitas adalah hasil dari perhatian pada detail.",
    "Sistem yang baik adalah sistem yang bisa berkembang sesuai kebutuhan.",
    "Jangan pernah meremehkan pentingnya dokumentasi yang baik.",
    "Pengguna adalah pusat dari setiap sistem yang sukses.",
    "Bekerja cerdas lebih baik daripada bekerja keras tanpa arah.",
    "Teknologi adalah alat, manusia adalah inovator.",
    "Setiap hari adalah kesempatan untuk menjadi lebih baik dari sebelumnya.",
    "Fokuslah pada solusi, bukan masalah.",
    "Komunikasi yang jelas adalah fondasi dari proyek yang sukses.",
    "Sistem yang tidak aman adalah sistem yang tidak bisa dipercaya.",
    "Berani mencoba adalah langkah pertama menuju kesuksesan.",
    "Belajar dari kesalahan adalah cara terbaik untuk tumbuh.",
    "Kolaborasi adalah kekuatan yang mempercepat kesuksesan.",
    "Kegigihan adalah kunci untuk menyelesaikan proyek besar.",
    "Keberhasilan datang dari kombinasi kerja keras dan kesabaran.",
    "Jadilah fleksibel, tetapi tetap fokus pada tujuan.",
    "Teknologi diciptakan untuk menyederhanakan hidup, bukan membuatnya lebih rumit.",
    "Setiap bug adalah peluang untuk belajar.",
    "Sistem yang sukses adalah sistem yang terus diperbarui dan disesuaikan.",
    "Percayalah pada proses, tetapi tetap siap untuk beradaptasi.",
    "Pemahaman yang baik tentang kebutuhan pengguna adalah setengah dari pekerjaan.",
    "Kesuksesan adalah hasil dari kerja keras yang konsisten.",
    "Selalu ada cara untuk membuat sesuatu menjadi lebih baik.",
    "Integritas adalah fondasi dari sistem yang dapat dipercaya.",
    "Perencanaan yang baik adalah awal dari pekerjaan yang sukses.",
    "Jangan takut bertanya. Pertanyaan adalah awal dari pengetahuan.",
    "Kreativitas adalah kunci untuk memecahkan masalah yang sulit.",
    "Fokus pada kualitas, bukan hanya kuantitas.",
    "Sistem yang sederhana sering kali adalah sistem yang paling efektif.",
    "Kerja tim membuat pekerjaan berat terasa lebih ringan.",
    "Semangat inovasi adalah apa yang mendorong teknologi maju.",
    "Beradaptasi dengan perubahan adalah keterampilan yang sangat berharga.",
    "Komitmen untuk belajar adalah investasi terbaik dalam diri Anda.",
    "Kesabaran dan ketekunan adalah kunci keberhasilan.",
    "Sistem yang baik adalah yang bisa diandalkan kapan saja.",
    "Setiap proyek adalah peluang untuk menciptakan sesuatu yang luar biasa.",
    "Komunikasi yang baik adalah setengah dari keberhasilan dalam tim.",
    "Keberhasilan datang kepada mereka yang tidak takut untuk mencoba.",
    "Pemahaman mendalam tentang masalah adalah kunci untuk solusi yang baik.",
    "Kerja keras hari ini adalah kesuksesan esok.",
    "Kolaborasi lintas fungsi adalah kunci untuk membangun sistem yang kuat.",
    "Setiap baris kode memiliki cerita di baliknya.",
    "Kegagalan hanyalah bagian dari proses pembelajaran.",
    "Sistem yang baik adalah sistem yang berkembang bersama kebutuhan penggunanya.",
    "Jangan pernah berhenti belajar. Dunia teknologi tidak pernah berhenti berubah.",
    "Ketelitian adalah tanda dari seorang profesional sejati.",
    "Bekerja dengan visi adalah cara terbaik untuk menciptakan inovasi.",
    "Jangan pernah mengabaikan pentingnya pengujian.",
    "Setiap solusi dimulai dengan pemahaman yang jelas tentang masalahnya.",
    "Inovasi datang dari keberanian untuk berpikir di luar kotak.",
    "Komunikasi yang jelas adalah jembatan menuju keberhasilan.",
    "Perencanaan yang baik mengurangi risiko kegagalan.",
    "Setiap masalah adalah peluang untuk tumbuh dan belajar.",
    "Sistem terbaik adalah sistem yang membantu orang, bukan membingungkan mereka.",
    "Setiap baris kode adalah investasi untuk masa depan.",
    "Teknologi adalah alat untuk mempermudah hidup, bukan sebaliknya.",
    "Keberhasilan datang kepada mereka yang gigih.",
    "Jangan pernah takut untuk memulai sesuatu yang baru.",
    "Inovasi adalah kombinasi antara imajinasi dan eksekusi.",
    "Bekerja dengan tim adalah cara terbaik untuk mencapai tujuan besar.",
    "Jangan pernah meremehkan kekuatan umpan balik yang jujur.",
    "Setiap proyek adalah kesempatan untuk meninggalkan jejak positif.",
    "Kerja keras adalah kunci menuju kesuksesan.",
    "Selalu ada cara untuk menyederhanakan hal yang rumit.",
    "Sistem yang aman adalah sistem yang sukses.",
    "Teknologi yang baik adalah teknologi yang mudah digunakan.",
    "Kesabaran adalah kunci untuk menyelesaikan masalah yang kompleks.",
    "Belajar dari kesalahan adalah tanda dari seorang profesional sejati.",
    "Jangan takut untuk berpikir di luar kotak.",
    "Setiap hari adalah kesempatan untuk membuat sesuatu yang lebih baik.",
    "Kerja tim adalah rahasia di balik setiap proyek besar.",
    "Keamanan adalah prioritas utama dalam setiap sistem.",
    "Fokus pada kualitas adalah kunci untuk membangun sesuatu yang tahan lama."
];

// Function to get a random quote
function getRandomQuote() {
    return quotes[Math.floor(Math.random() * quotes.length)];
}

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <!-- <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard
            </h2> -->
        </template>

        <div v-if="role === 'pengaju'">
            <div
                class="border-2 rounded-lg border-gray-300 dark:border-gray-600 h-36 mb-4 p-4 bg-gray-200 dark:bg-gray-800">
                <h1 class="text-4xl">Selamat datang, {{ $page.props.auth.user.name }}</h1>
                <p class="text-md text-gray-600 dark:text-gray-400 mt-4"><i>"{{ getRandomQuote() }}"</i></p>
            </div>
        </div>
        <div v-else>
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
                        <dd class="font-light text-gray-700 dark:text-gray-300 text-lg">Total pengajuan belum selesai
                        </dd>
                    </div>
                </div>
                <div
                    class="border-2 border-gray-300 rounded-lg dark:border-gray-600 h-16 md:h-32 bg-blue-200 dark:bg-blue-800">
                    <div class="flex flex-col justify-between h-full px-4 py-2">
                        <dt class="text-3xl md:text-4xl font-extrabold">{{ countSelesai }}</dt>
                        <dd class="font-light text-gray-700 dark:text-gray-300 text-lg">Total pengajuan yang sudah
                            selesai
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
            <div
                class="border-2 rounded-lg border-gray-300 dark:border-gray-600 h-96 mb-4 p-4 bg-gray-100 dark:bg-black">
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
        </div>
        <div class="h-80"></div>
    </AppLayout>
</template>
