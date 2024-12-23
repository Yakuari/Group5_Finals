document.addEventListener("DOMContentLoaded", function () {
    // Popups
    const showLoginBtn = document.querySelector("#show-login");
    const showSignupBtn = document.querySelector("#show-signup");
    const loginPopup = document.querySelector(".popup.login-popup");
    const signupPopup = document.querySelector(".popup.signup-popup");
    const closeBtns = document.querySelectorAll(".popup .close-btn");
    const buyButtons = document.querySelectorAll('.subscription form button');

    // Sidebar
    const sidebar = document.querySelector('.sidebar');
    const menuButton = document.querySelector('.menu-button');
    const closeButton = document.querySelector('.sidebar-close-btn');

    // Form popup
    const openFormBtn = document.querySelector("#openFormBtn");
    const formPopup = document.querySelector("#formPopup");
    const formCloseBtn = document.querySelector(".popup-form .close-btn");

    // Function to close all popups
    function closeAllPopups() {
        loginPopup?.classList.remove("active");
        signupPopup?.classList.remove("active");
        formPopup?.classList.remove("active");
    }

    // Toggle popup visibility
    function togglePopup(popup) {
        if (popup.classList.contains("active")) {
            popup.classList.remove("active"); // Close the popup if already active
        } else {
            closeAllPopups(); // Close any other active popups
            popup.classList.add("active"); // Open the designated popup
        }
    }

    // Event listeners for opening login/signup popups
    if (showLoginBtn) {
        showLoginBtn.addEventListener("click", function () {
            togglePopup(loginPopup);
        });
    }

    if (showSignupBtn) {
        showSignupBtn.addEventListener("click", function () {
            togglePopup(signupPopup);
        });
    }

    // Alert message for buy buttons
    buyButtons.forEach((button) => {
        button.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent form submission
            alert("You need to login first!");
        });
    });

    // Sidebar toggle functionality
    if (menuButton && closeButton) {
        menuButton.addEventListener("click", () => {
            sidebar.classList.add("active");
        });

        closeButton.addEventListener("click", () => {
            sidebar.classList.remove("active");
        });
    }

    // Open and close form popup
    if (openFormBtn) {
        openFormBtn.addEventListener("click", () => {
            formPopup.classList.add("active");
        });
    }

    if (formCloseBtn) {
        formCloseBtn.addEventListener("click", () => {
            formPopup.classList.remove("active");
        });
    }

    // Close popups when clicking outside
    document.addEventListener("click", function (event) {
        if (
            !event.target.closest(".popup") &&
            !event.target.matches("#show-login") &&
            !event.target.matches("#show-signup")
        ) {
            closeAllPopups();
        }
    });
});
