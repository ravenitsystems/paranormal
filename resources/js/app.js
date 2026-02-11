import './bootstrap';
import router from "./router";
import { createApp } from "vue";

import App from "./App.vue";

// Font Awesome
import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import {
    faHome,
    faSearch,
    faBars,
    faTimes,
    faGhost,
} from "@fortawesome/free-solid-svg-icons";

library.add(faHome, faSearch, faBars, faTimes, faGhost);

const app = createApp(App);
app.component("FontAwesomeIcon", FontAwesomeIcon);
app.use(router);
app.mount("#app");
