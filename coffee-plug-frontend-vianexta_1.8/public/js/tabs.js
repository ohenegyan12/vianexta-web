const tabs = Array.from(document.querySelectorAll(".tab-link"));
const content = Array.from(document.querySelectorAll(".content"));
let activeTab = 0;

tabs.map((tab, index) => {
    tab.addEventListener("click", (e) => {
        e.preventDefault();
        activeTab = index;

        showContent(activeTab);
    });
});

function showContent(i) {
    tabs.map((t, index) => {
        if (index != i) {
            t.classList.remove("active");
        } else {
            t.classList.add("active");
        }
    });
    content.map((c, index) => {
        if (index != i) {
            c.classList.remove("content-active");
        } else {
            c.classList.add("content-active");
        }
    });
}
