import Swal from "sweetalert2";

const utils = {
    formatDateTime: function (
        date,
        options = { locale: "id-ID", dateStyle: "medium", timeStyle: "short" }
    ) {
        return new Date(date).toLocaleString(options.locale, options);
    },

    formatCurrency: function (
        amount,
        options = { locale: "id-ID", currency: "IDR" }
    ) {
        return new Intl.NumberFormat(options.locale, {
            ...options,
            style: "currency",
        }).format(amount);
    },

    formatDecimal: function (
        amount,
        options = { locale: "id-ID", minimumFractionDigits: 2 }
    ) {
        return new Intl.NumberFormat(options.locale, options).format(amount);
    },

    image: {
        // Returns a random placeholder image URL
        placeholder: function (width = 300, height = 300) {
            return `https://via.placeholder.com/${width}x${height}`;
        },

        // Validates if a URL is a valid image
        isValidImageUrl: function (url) {
            return /\.(jpg|jpeg|png|webp|avif|gif|svg)$/.test(url);
        },

        // Preloads an image
        preloadImage: function (url, callback) {
            const img = new Image();
            img.src = url;
            img.onload = callback;
        },
    },

    confirm: function (options = {}) {
        return Swal.fire({
            title:
                options.title || "Apakah Anda yakin ingin menghapus data ini?",
            text:
                options.text ||
                "Tindakan ini tidak dapat dibatalkan, dan data yang dihapus tidak akan bisa dikembalikan!",
            icon: options.icon || "warning",
            width: options.width || "32em",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Delete Data",
            customClass: {
                popup: "bg-white dark:bg-gray-800",
                title: "text-gray-900 dark:text-gray-100",
                htmlContainer: "!text-gray-700 dark:!text-gray-200",
                confirmButton:
                    "bg-blue-600 hover:bg-blue-700 text-white dark:bg-blue-500 dark:hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800 rounded-full",
                cancelButton:
                    "bg-gray-600 hover:bg-gray-700 text-white dark:bg-gray-500 dark:hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-800 rounded-full",
            },
        });
    },

    isLog: false,
};

export default utils;
