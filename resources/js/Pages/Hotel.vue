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
    laravelVersion: {
        type: String,
        requigreen: true,
    },
    phpVersion: {
        type: String,
        requigreen: true,
    },
});

</script>

<template>

    <Head title="Welcome" />
    <!-- Header -->
    <header>
        <nav
            class="backdrop-blur bg-white/30 dark:bg-gray-900/70 fixed w-full z-50 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <!-- <ApplicationLogo /> -->
                    <span class="self-center text-2xl font-semibold whitespace-nowrap text-green-600">
                        Suri Hotel
                    </span>
                </a>
                <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                    <ul
                        class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 dark:border-gray-700">
                        <li>
                            <a href="#"
                                class="block py-2 px-3 text-white bg-green-700 rounded md:bg-transparent md:text-green-700 md:p-0 md:dark:text-green-300"
                                aria-current="page">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#about"
                                class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-green-700 md:p-0 md:dark:hover:text-green-300 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">
                                About
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-green-700 md:p-0 md:dark:hover:text-green-300 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">
                                Services
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-green-700 md:p-0 md:dark:hover:text-green-300 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">
                                Contact
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero -->
    <section id="hero" class="relative mt-16 py-2">
        <!-- Carousel -->
        <div id="default-carousel" class="relative w-full max-w-7xl mx-auto" data-carousel="slide">
            <!-- Carousel wrapper -->
            <div class="relative h-56 overflow-hidden rounded-lg md:h-[700px]">
                <!-- Item 1 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="https://images.oyoroomscdn.com/uploads/hotel_image/114829/large/ca1522b4a5733e95.JPG"
                        class="absolute block w-full h-full object-cover" alt="...">
                </div>
                <!-- Item 2 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="https://images.oyoroomscdn.com/uploads/hotel_image/114829/large/8fe928b96b1a212e.JPG"
                        class="absolute block w-full h-full object-cover" alt="...">
                </div>
                <!-- Item 3 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="https://images.oyoroomscdn.com/uploads/hotel_image/114829/large/c7ccb63f8b895467.JPG"
                        class="absolute block w-full h-full object-cover" alt="...">
                </div>
                <!-- Item 4 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="https://images.oyoroomscdn.com/uploads/hotel_image/114829/large/cb870548fd62fbf4.JPG"
                        class="absolute block w-full h-full object-cover" alt="...">
                </div>
                <!-- Item 5 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="https://images.oyoroomscdn.com/uploads/hotel_image/114829/large/9e29a5b2a877f957.JPG"
                        class="absolute block w-full h-full object-cover" alt="...">
                </div>
            </div>
            <!-- Slider indicators -->
            <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1"
                    data-carousel-slide-to="0"></button>
                <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2"
                    data-carousel-slide-to="1"></button>
                <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3"
                    data-carousel-slide-to="2"></button>
                <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4"
                    data-carousel-slide-to="3"></button>
                <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5"
                    data-carousel-slide-to="4"></button>
            </div>
            <!-- Slider controls -->
            <button type="button"
                class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-prev>
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 1 1 5l4 4" />
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button"
                class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-next>
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>
    </section>

    <!-- Booking -->
    <section id="booking" class="relative py-2">
        <form
            class="block w-full max-w-7xl mx-auto px-6 py-4 bg-white border-2 border-green-600 rounded-lg dark:bg-gray-800 dark:border-green-700">
            <div class="grid gap-6 mb-6 md:grid-cols-2 lg:grid-cols-5">
                <div class="w-full sm:col-span-4 md:col-span-1 lg:mt-3">
                    <h2 class="font-bold text-xl">BOOK ONLINE</h2>
                    <p class="text-gray-600">Guaranteed accommodation</p>
                </div>
                <div class="w-full col-span-2">

                    <div id="date-range-picker" date-rangepicker class="flex items-center">
                        <div class="relative">
                            <label for="last_name"
                                class="block mb-1 text-md font-medium text-green-900 dark:text-white">
                                Check-in
                            </label>
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pt-6 pointer-events-none">
                                <svg class="w-4 h-4 text-green-500 dark:text-green-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="datepicker-range-start" name="start" type="text"
                                class="bg-gray-50 border border-gray-300 text-green-900 text-md rounded-lg focus:ring-green-500 focus:border-green-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                placeholder="Select date start">
                        </div>
                        <span class="mx-4 text-green-500">&nbsp;</span>
                        <div class="relative">
                            <label for="last_name"
                                class="block mb-1 text-md font-medium text-green-900 dark:text-white">
                                Check-out
                            </label>
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pt-6 pointer-events-none">
                                <svg class="w-4 h-4 text-green-500 dark:text-green-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="datepicker-range-end" name="end" type="text"
                                class="bg-gray-50 border border-gray-300 text-green-900 text-md rounded-lg focus:ring-green-500 focus:border-green-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                placeholder="Select date end">
                        </div>
                    </div>

                </div>
                <div class="w-full">
                    <label for="company"
                        class="block mb-1 text-md font-medium text-green-900 dark:text-white">Guests</label>
                    <button id="dateRangeButton" data-dropdown-toggle="dropdownGuests"
                        class="w-full rounded-lg z-10 inline-flex justify-center items-center py-2.5 px-4 text-md font-medium text-green-500 bg-gray-100 border border-gray-300 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
                        type="button">
                        <svg class="w-5 h-5 text-green-800 dark:text-green-500 mr-2" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                                clip-rule="evenodd" />
                        </svg>
                        3 Adult(s), 0 Child
                        <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <div id="dropdownGuests"
                        class="z-10 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="p-3 space-y-3 text-sm text-green-700 dark:text-gray-200"
                            aria-labelledby="dropdownCheckboxButton">
                            <li>
                                <div class="flex items-center">
                                    <input id="checkbox-item-1" type="checkbox" value=""
                                        class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="checkbox-item-1"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Default
                                        checkbox</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <input checked id="checkbox-item-2" type="checkbox" value=""
                                        class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="checkbox-item-2"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Checked
                                        state</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <input id="checkbox-item-3" type="checkbox" value=""
                                        class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="checkbox-item-3"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Default
                                        checkbox</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div>
                    <label for="visitors"
                        class="block mb-1 text-md font-medium text-gray-900 dark:text-white">&nbsp;</label>
                    <button type="button"
                        class="w-full text-white bg-green-600 hover:bg-green-600/90 focus:ring-4 focus:ring-green-600/50 focus:outline-none font-medium rounded-lg text-md px-5 py-2.5 text-center inline-flex justify-center items-center dark:focus:ring-green-600/50">
                        <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        Cari Kamar
                    </button>
                </div>
            </div>
        </form>
    </section>

    <!-- About -->
    <section id="about" class="bg-white dark:bg-gray-900">
        <div class="py-4 px-4 mx-auto max-w-screen-xl text-center lg:py-10">
            <h2 class="mb-4 text-2xl tracking-tight font-extrabold text-green-800 dark:text-white">
                Tentang Suri Hotel
            </h2>
            <p class="mb-8 text-lg font-normal lg:text-4xl sm:px-16 lg:px-48 dark:text-gray-400">
                Suri Hotel adalah hotel keluarga dan bisnis, menawarkan keramahtamahan dan layanan yang luar biasa untuk
                memastikan pengalaman yang tak terlupakan bagi setiap tamu.
            </p>
        </div>
    </section>

    <section class="bg-white dark:bg-gray-900">
        <div class="max-w-screen-xl px-2 py-4 mx-auto text-center lg:py-4 lg:px-6">
            <dl class="grid max-w-screen-md gap-8 mx-auto text-gray-900 sm:grid-cols-3 dark:text-white">
                <div class="flex flex-col items-center justify-center">
                    <dt class="mb-2 text-3xl md:text-4xl font-extrabold">25</dt>
                    <dd class="font-light text-green-800 dark:text-green-600">Kamar</dd>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <dt class="mb-2 text-3xl md:text-4xl font-extrabold">50</dt>
                    <dd class="font-light text-green-800 dark:text-green-600">Kapasitas orang</dd>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <dt class="mb-2 text-3xl md:text-4xl font-extrabold">10</dt>
                    <dd class="font-light text-green-800 dark:text-green-600">Menit dari Bandara</dd>
                </div>
            </dl>
        </div>
    </section>

    <section class="bg-white dark:bg-gray-900">
        <div
            class="gap-8 items-center py-8 px-4 mx-auto max-w-screen-xl xl:gap-16 md:grid md:grid-cols-2 sm:py-16 lg:px-6">
            <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                <h2 class="mb-10 text-2xl tracking-tight font-extrabold text-green-800 dark:text-white">
                    Hubungi Kami
                </h2>
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Alamat</dt>
                    <dd class="text-lg font-semibold">
                        Jl. Belibis No.19 Blok D, Air Tawar Bar., Kec. Padang Utara, Kota
                        Padang, Sumatera Barat
                    </dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Whatsapp</dt>
                    <dd class="text-lg font-semibold">
                        <a href="https://wa.me/6285640636357">+6285640636357</a>
                    </dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Email</dt>
                    <dd class="text-lg font-semibold">ancelotdigital@gmail.com</dd>
                </div>
            </dl>
            <div class="mt-4 md:mt-0">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15957.3135754579!2d100.3456968!3d-0.8979062!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4bf53b5162591%3A0xd08b6c6a446c4162!2sSUPER%20OYO%2090643%20Suri%20Guest%20House%20Syariah!5e0!3m2!1sen!2sid!4v1725571543711!5m2!1sen!2sid"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <section class="bg-green-100 dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
            <div class="max-w-screen-md">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">
                    Suri Hotel Kota Padang
                </h2>
                <p class="mb-8 font-light text-gray-500 sm:text-xl dark:text-gray-400">
                    Nikmati pengalaman tak terlupakan menjelajahi pesona kota Padang sambil beristirahat nyaman di Suri
                    Hotel, tempat sempurna yang menggabungkan kemewahan, kenyamanan, dan akses mudah ke berbagai
                    destinasi menarik di sekitar kota. Rasakan keramahan khas Padang dan fasilitas modern yang akan
                    membuat setiap momen Anda semakin berkesan di Suri Hotel!
                </p>
            </div>
        </div>
    </section>

    <footer class="bg-white shadow dark:bg-gray-900">
        <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <a href="#" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                    <ApplicationLogo />
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Demo App</span>
                </a>
                <ul
                    class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                    <li>
                        <a href="#about" class="hover:underline me-4 md:me-6">About</a>
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
            <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">
                © {{ new Date().getFullYear() }}
                <a href="#" class="hover:underline">Demo App™</a>.
                All Rights Reserved.<br />
                Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
            </span>
        </div>
    </footer>

</template>
