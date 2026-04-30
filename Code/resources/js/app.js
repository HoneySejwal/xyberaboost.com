import "./bootstrap";
import Alpine from "alpinejs";
import Vue from "vue";
import ExampleComponent from "./components/ExampleComponent.vue";

window.Alpine = Alpine;
window.Vue = Vue;

Vue.component("example-component", ExampleComponent);

document.addEventListener("DOMContentLoaded", () => {
    Alpine.start();

    const vueRoot = document.getElementById("app");
    const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)");
    const animatedSelector = [
        "[data-page-content] section",
        "[data-page-content] article",
        "[data-page-content] .glass-panel",
        "[data-page-content] .feature-card",
        "[data-page-content] .metric-card",
        "[data-page-content] .accordion-card",
        "[data-page-content] .topup-stat",
        "[data-page-content] .hero-panel",
        "[data-page-content] .tier-table",
    ].join(", ");

    if (vueRoot) {
        new Vue({
            el: "#app",
        });
    }

    if (reduceMotion.matches) {
        document.documentElement.classList.add("reduce-motion");
        return;
    }

    document.documentElement.classList.add("motion-ready");

    const animatedItems = Array.from(document.querySelectorAll(animatedSelector)).filter(
        (element) => !element.closest("header") && !element.closest("footer"),
    );

    animatedItems.forEach((element, index) => {
        element.classList.add("will-reveal");
        element.style.setProperty("--reveal-delay", `${Math.min(index % 6, 5) * 70}ms`);
    });

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                entry.target.classList.add("is-visible");
                observer.unobserve(entry.target);
            });
        },
        {
            threshold: 0.14,
            rootMargin: "0px 0px -8% 0px",
        },
    );

    animatedItems.forEach((element) => observer.observe(element));
});
