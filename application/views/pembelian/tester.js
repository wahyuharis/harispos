var list = document.getElementById("ko_binded");

var MutationObserver = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver;

var observer = new MutationObserver(function (mutations) {
    mutations.forEach(function (mutation) {
        if (mutation.type === 'childList') {
            console.log("mutation!", mutation);
        }
    });
});

observer.observe(list, {
    attributes: true,
    childList: true,
    characterData: true,
    subtree: true
});

