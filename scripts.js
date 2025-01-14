document.addEventListener("DOMContentLoaded", () => {
    console.log("Website is fully loaded and operational.");
    
    const links = document.querySelectorAll("a");
    links.forEach(link => {
        link.addEventListener("click", (e) => {
            console.log(`Navigating to: ${link.href}`);
        });
    });
});
