import "./bootstrap";
import $ from "jquery";
window._ = require("lodash");

window.$ = window.jQuery = $;

import * as bootstrap from "bootstrap";

window.bootstrap = bootstrap;

try {
    window.Popper = require("@popperjs/core").default;

    require("datatables.net-bs5");
    require("select2");
} catch (e) {}
