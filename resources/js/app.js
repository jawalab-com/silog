import "./bootstrap";
import "../css/app.css";
import "/node_modules/flowbite-vue/dist/index.css";
import utils from "./utils";
import { initFlowbite } from "flowbite";

import { createApp, h } from "vue";
import { createInertiaApp, router } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";

window.utils = utils;

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
}).then(() => {
    // on first load
    initFlowbite();
});

router.on("success", (event) => {
    // on each router load
    initFlowbite();
});

router.on("navigate", (event) => {
    initFlowbite();
});
