<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});

</script>

<template>

    <Head title="Selamat Datang" />

    <!-- Header -->
    <header>
        <nav
            class="bg-white dark:bg-black fixed w-full z-30 top-0 start-0 border-b border-gray-600 dark:border-gray-200">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4 rounded-lg">
                <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <span class="self-center text-2xl font-semibold whitespace-nowrap text-black dark:text-white">
                        Kisah Nabi Muhammad
                    </span>
                </a>
                <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                    <button data-collapse-toggle="navbar-sticky" type="button"
                        class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        aria-controls="navbar-sticky" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 17 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 1h15M1 7h15M1 13h15" />
                        </svg>
                    </button>
                </div>
                <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                    <ul
                        class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 dark:border-gray-700">
                        <li>
                            <a href="#beranda"
                                class="block py-2 px-3 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-300 md:p-0 md:dark:hover:text-blue-300 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">
                                Beranda
                            </a>
                        </li>
                        <li>
                            <a href="#tentang-buku"
                                class="block py-2 px-3 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-300 md:p-0 md:dark:hover:text-blue-300 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">
                                Tentang Buku
                            </a>
                        </li>
                        <li>
                            <a href="#keunggulan"
                                class="block py-2 px-3 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-300 md:p-0 md:dark:hover:text-blue-300 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">
                                Keunggulan
                            </a>
                        </li>
                        <li>
                            <a href="#testimoni"
                                class="block py-2 px-3 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-300 md:p-0 md:dark:hover:text-blue-300 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">
                                Testimoni
                            </a>
                        </li>
                        <li>
                            <a href="#kontak"
                                class="block py-2 px-3 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-300 md:p-0 md:dark:hover:text-blue-300 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">
                                Kontak
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="bg-blue-900 dark:bg-blue-100">
        <div
            class="bg-blue-900 dark:bg-blue-100 rounded-lg grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
            <div class="mr-auto place-self-center lg:col-span-7 mt-14">
                <h1
                    class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-5xl text-white dark:text-black sm:pt-10">
                    Selami Kisah Inspiratif Nabi Muhammad SAW
                </h1>
                <p class="max-w-2xl mb-6 font-light text-gray-300 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-700">
                    Temukan perjalanan hidup Rasulullah yang penuh hikmah dan teladan dalam buku istimewa ini.
                </p>
                <a href="#pesan"
                    class="inline-flex font-semibold items-center justify-center px-5 py-3 text-base font-medium text-blue-900 rounded-full bg-yellow-300 hover:bg-yellow-400 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900">
                    Pesan Sekarang
                    <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
            <div class="mt-10 lg:col-span-5 flex justify-center">
                <img class="rounded-lg h-[40rem]"
                    src="https://inc.mizanstore.com/aassets/img/com_cart/produk/seri-buku-bersuara-kisah-nabi-musa-as.jpg"
                    alt="Sampul Buku Kisah Nabi Muhammad">
            </div>
        </div>
    </section>

    <!-- Pengantar Section -->
    <section id="pengantar" class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-4">
                Mengapa Buku Ini Wajib Dimiliki?
            </h2>
            <p class="text-lg text-gray-600">
                Ingin lebih dekat dengan sosok Nabi Muhammad SAW dan memetik pelajaran berharga dari setiap episode
                kehidupannya? Buku <strong>"Kisah Nabi Muhammad"</strong> hadir untuk membawa Anda menyelami kehidupan
                Rasulullah dengan penyajian yang menyentuh hati dan mudah dipahami.
            </p>
        </div>
    </section>

    <!-- Tentang Buku Section -->
    <section id="tentang-buku" class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-6">
                        Tentang Buku
                    </h2>
                    <p class="text-lg text-gray-600 mb-4">
                        Buku ini mengisahkan secara lengkap perjalanan hidup Nabi Muhammad SAW, dari kelahiran hingga
                        wafatnya. Dilengkapi dengan ilustrasi menarik dan disusun berdasarkan sumber-sumber terpercaya,
                        buku ini menjadi referensi sempurna bagi Anda yang ingin mengenal lebih dekat sosok teladan umat
                        Islam.
                    </p>
                    <p class="text-lg text-gray-600">
                        Tidak hanya menyajikan kronologi peristiwa, buku ini juga menggali nilai-nilai moral dan ajaran
                        mulia yang dapat kita terapkan dalam kehidupan sehari-hari.
                    </p>
                </div>
                <div class="mt-8 lg:mt-0 lg:flex justify-center">
                    <img class="h-80 rounded-lg shadow-lg"
                        src="https://inc.mizanstore.com/aassets/img/com_cart/produk/seri-buku-bersuara-kisah-nabi-musa-as.jpg"
                        alt="Sampul Buku Kisah Nabi Muhammad">
                </div>
            </div>
        </div>
    </section>

    <!-- Keunggulan Section -->
    <section id="keunggulan" class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-12">
                Keunggulan Buku
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Keunggulan 1 -->
                <div class="p-6 bg-gray-100 rounded-lg shadow-md">
                    <div class="text-4xl text-blue-900 mb-4">
                        <i class="fas fa-book"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                        Sumber Terpercaya
                    </h3>
                    <p class="text-gray-600">
                        Berdasarkan hadis dan riwayat sahih dari berbagai ulama yang terpercaya.
                    </p>
                </div>
                <!-- Keunggulan 2 -->
                <div class="p-6 bg-gray-100 rounded-lg shadow-md">
                    <div class="text-4xl text-blue-900 mb-4">
                        <i class="fas fa-language"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                        Bahasa Mudah Dipahami
                    </h3>
                    <p class="text-gray-600">
                        Disusun dengan bahasa yang ringan, cocok untuk semua kalangan, termasuk remaja.
                    </p>
                </div>
                <!-- Keunggulan 3 -->
                <div class="p-6 bg-gray-100 rounded-lg shadow-md">
                    <div class="text-4xl text-blue-900 mb-4">
                        <i class="fas fa-images"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                        Ilustrasi Menarik
                    </h3>
                    <p class="text-gray-600">
                        Dilengkapi dengan ilustrasi menarik untuk memudahkan visualisasi kisah.
                    </p>
                </div>
                <!-- Keunggulan 4 -->
                <div class="p-6 bg-gray-100 rounded-lg shadow-md">
                    <div class="text-4xl text-blue-900 mb-4">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                        Penuh Hikmah
                    </h3>
                    <p class="text-gray-600">
                        Setiap bab mengandung hikmah dan nilai moral yang bisa diterapkan dalam kehidupan sehari-hari.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimoni Section -->
    <section id="testimoni" class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-12">
                Testimoni Pembaca
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimoni 1 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <blockquote class="text-gray-600">
                        "Buku ini membuka mata saya tentang betapa agungnya akhlak Nabi Muhammad SAW. Sangat
                        inspiratif!"
                    </blockquote>
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold text-gray-900">Aisyah</h3>
                        <p class="text-sm text-gray-500">Guru</p>
                    </div>
                </div>
                <!-- Testimoni 2 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <blockquote class="text-gray-600">
                        "Penyajiannya ringan namun mendalam. Cocok untuk bahan ajar di sekolah."
                    </blockquote>
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold text-gray-900">Ustadz Ahmad</h3>
                        <p class="text-sm text-gray-500">Pengajar</p>
                    </div>
                </div>
                <!-- Testimoni 3 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <blockquote class="text-gray-600">
                        "Setelah membaca buku ini, saya merasa lebih dekat dengan Nabi Muhammad SAW. Penulisannya sangat
                        mudah dipahami."
                    </blockquote>
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold text-gray-900">Hasan</h3>
                        <p class="text-sm text-gray-500">Mahasiswa</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bonus Section -->
    <section id="bonus" class="bg-blue-900 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h2 class="text-3xl font-extrabold mb-6">
                Bonus Spesial untuk Anda!
            </h2>
            <p class="text-lg mb-6">
                Dapatkan <strong>Ebook "99 Nama Allah dan Maknanya"</strong> secara gratis dengan setiap pembelian buku
                ini.
            </p>
            <p class="text-lg">
                Ebook ini akan membantu Anda lebih mendalami makna setiap nama indah Allah SWT.
            </p>
        </div>
    </section>

    <!-- Harga Section -->
    <section id="harga" class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6">
                Harga Spesial untuk Anda!
            </h2>
            <p class="text-lg text-gray-600 mb-4">
                Harga normal: <span class="line-through">Rp119.000,-</span>
            </p>
            <p class="text-4xl font-bold text-red-600 mb-6">
                Hanya Rp89.000,-
            </p>
            <p class="text-lg text-gray-600 mb-8">
                Hemat Rp30.000,- jika Anda memesan sekarang! Stok terbatas.
            </p>
            <a href="#pesan"
                class="inline-flex font-semibold items-center justify-center px-5 py-3 text-base font-medium text-blue-900 rounded-full bg-yellow-300 hover:bg-yellow-400 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900">
                Pesan Sekarang
            </a>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="cta" class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6">
                Jangan Lewatkan Kesempatan Ini!
            </h2>
            <p class="text-lg text-gray-600">
                Ambil kesempatan emas ini untuk memperkaya iman dan pengetahuan Anda. Pesan sekarang dan jadilah bagian
                dari mereka yang meneladani kehidupan Rasulullah!
            </p>
        </div>
    </section>

    <section id="cara-pemesanan" class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6">
                Cara Pemesanan
            </h2>
            <p class="text-lg text-gray-600 mb-12">
                Pesan buku ini dengan mudah dalam beberapa langkah singkat.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Langkah 1 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="text-4xl text-blue-900 mb-4">
                        <i class="fas fa-mouse-pointer"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Langkah 1</h3>
                    <p class="text-gray-600">
                        Klik tombol "Pesan Sekarang".
                    </p>
                </div>
                <!-- Langkah 2 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="text-4xl text-blue-900 mb-4">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Langkah 2</h3>
                    <p class="text-gray-600">
                        Isi formulir pemesanan dengan data lengkap Anda.
                    </p>
                </div>
                <!-- Langkah 3 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="text-4xl text-blue-900 mb-4">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Langkah 3</h3>
                    <p class="text-gray-600">
                        Lakukan pembayaran melalui transfer bank atau e-wallet.
                    </p>
                </div>
                <!-- Langkah 4 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="text-4xl text-blue-900 mb-4">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Langkah 4</h3>
                    <p class="text-gray-600">
                        Buku akan segera dikirim ke alamat Anda setelah konfirmasi pembayaran.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="kontak" class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6">
                Hubungi Kami
            </h2>
            <p class="text-lg text-gray-600 mb-6">
                Jika ada pertanyaan atau kendala terkait pemesanan, jangan ragu untuk menghubungi kami.
            </p>
            <div class="flex flex-col items-center space-y-4">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-phone-alt text-blue-900 text-2xl"></i>
                    <a href="https://wa.me/62823-2496-0636" class="text-lg text-gray-900">WA: 0823-2496-0636</a>
                </div>
                <div class="flex items-center space-x-4">
                    <i class="fas fa-envelope text-blue-900 text-2xl"></i>
                    <p class="text-lg text-gray-900">✉️ contact@ancelot.in</p>
                </div>
                <div class="flex items-center space-x-4">
                    <i class="fas fa-clock text-blue-900 text-2xl"></i>
                    <p class="text-lg text-gray-900">Layanan 24/7</p>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-12">
                Pertanyaan yang Sering Diajukan (FAQ)
            </h2>
            <div class="space-y-8">
                <!-- FAQ 1 -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                        Berapa lama waktu pengiriman buku?
                    </h3>
                    <p class="text-gray-600">
                        Waktu pengiriman berkisar antara 2-5 hari kerja, tergantung lokasi pengiriman.
                    </p>
                </div>
                <!-- FAQ 2 -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                        Apa saja metode pembayaran yang diterima?
                    </h3>
                    <p class="text-gray-600">
                        Kami menerima transfer bank dan e-wallet seperti OVO, GoPay, dan lainnya.
                    </p>
                </div>
                <!-- FAQ 3 -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                        Apakah ada garansi untuk buku ini?
                    </h3>
                    <p class="text-gray-600">
                        Ya, kami memberikan garansi uang kembali 100% jika Anda tidak puas dengan buku ini.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-blue-900 shadow dark:bg-blue-100">
        <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <a href="#" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                    <span class="self-center text-2xl font-semibold whitespace-nowrap text-white dark:text-black">
                        Kisah Nabi Muhammad
                    </span>
                </a>
                <ul
                    class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-300 sm:mb-0 dark:text-gray-700">
                    <li>
                        <a href="#" class="hover:underline me-4 md:me-6">About</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline me-4 md:me-6">Licensing</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline">Contact</a>
                    </li>
                </ul>
            </div>
            <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
            <span class="block text-sm text-gray-300 sm:text-center dark:text-gray-700">
                © {{ new Date().getFullYear() }}
                <a href="#" class="hover:underline">PT ANCELOT DIGITAL SERVICES</a>.
            </span>
        </div>
    </footer>

</template>

<style>
.text-shadow {
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.9)
}
</style>
