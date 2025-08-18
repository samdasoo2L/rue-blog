document.addEventListener("DOMContentLoaded", function () {
    console.log("Profile dropdown script loaded!"); // 디버깅용

    const profileButton = document.querySelector(".profile-button");
    const dropdownMenu = document.querySelector(".profile-dropdown");

    console.log("Profile button:", profileButton); // 디버깅용
    console.log("Dropdown menu:", dropdownMenu); // 디버깅용

    let timeoutId;

    if (profileButton && dropdownMenu) {
        profileButton.addEventListener("mouseenter", function () {
            console.log("Mouse enter!"); // 디버깅용
            clearTimeout(timeoutId);
            dropdownMenu.classList.remove("opacity-0", "invisible", "scale-95");
            dropdownMenu.classList.add("opacity-100", "visible", "scale-100");
        });

        profileButton.addEventListener("mouseleave", function () {
            console.log("Mouse leave!"); // 디버깅용
            timeoutId = setTimeout(() => {
                dropdownMenu.classList.remove(
                    "opacity-100",
                    "visible",
                    "scale-100"
                );
                dropdownMenu.classList.add(
                    "opacity-0",
                    "invisible",
                    "scale-95"
                );
            }, 300);
        });

        dropdownMenu.addEventListener("mouseenter", function () {
            clearTimeout(timeoutId);
        });

        dropdownMenu.addEventListener("mouseleave", function () {
            timeoutId = setTimeout(() => {
                dropdownMenu.classList.remove(
                    "opacity-100",
                    "visible",
                    "scale-100"
                );
                dropdownMenu.classList.add(
                    "opacity-0",
                    "invisible",
                    "scale-95"
                );
            }, 300);
        });
    }
});
