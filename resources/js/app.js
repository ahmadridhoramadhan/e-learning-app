import './bootstrap';

import Alpine from 'alpinejs';
import 'flowbite';

window.Alpine = Alpine;
Alpine.start();

// sript.js

window.alert = function (message) {
    // Create modal container
    let modal = document.createElement("div");
    modal.className = "alert-modal-container";
    modal.id = "alert";
    modal.setAttribute("class",
        "fixed top-0 bottom-0 left-0 right-0 bg-black/40 z-50 flex justify-center items-center");

    // Create modal content
    let modalContent = document.createElement("div");
    modalContent.className = "alert-modal-content";
    modalContent.setAttribute("class", "w-full max-w-sm dark: bg-slate-800 p-4 rounded-md pb-14 relative");

    // Create message element
    let messageElement = document.createElement("div");
    messageElement.id = "alert-content";
    messageElement.innerHTML = message;

    // Create close button inside modal content
    let closeButtonElement = document.createElement("button");
    closeButtonElement.textContent = "Ok";
    closeButtonElement.setAttribute("class", "absolute bottom-2 right-2 dark:bg-cyan-950 dark:border-cyan-700 border rounded px-4 py-1");
    closeButtonElement.onclick = function () {
        modal.remove();
    };

    // Append elements to modal content
    modalContent.appendChild(messageElement);
    modalContent.appendChild(closeButtonElement);

    // Append modal content to modal container
    modal.appendChild(modalContent);

    // Append modal to document body
    document.body.appendChild(modal);
};
window.confirm = function (message, event = null, callback = null) {
    if (event) event.preventDefault();

    // Create modal container
    let modal = document.createElement("div");
    modal.className = "alert-modal-container";
    modal.id = "alert";
    modal.setAttribute("class",
        "fixed top-0 bottom-0 left-0 right-0 bg-black/40 z-50 flex justify-center items-center");

    // Create modal content
    let modalContent = document.createElement("div");
    modalContent.className = "alert-modal-content";
    modalContent.setAttribute("class", "w-full max-w-sm dark: bg-slate-800 p-4 rounded-md pb-14 relative");

    // Create message element
    let messageElement = document.createElement("div");
    messageElement.id = "alert-content";
    messageElement.innerHTML = message;

    let containerButtonElement = document.createElement("div");
    containerButtonElement.setAttribute("class", "absolute bottom-2 right-2 flex gap-2");

    // Create close button inside modal content
    let yesButtonElement = document.createElement("button");
    yesButtonElement.textContent = "yes";
    yesButtonElement.setAttribute("class", "dark:bg-cyan-950 dark:border-cyan-700 border rounded px-4 py-1");
    yesButtonElement.onclick = function () {
        modal.remove();
        if (event) event.target.submit();
        if (callback) callback(true);
    };
    let notButtonElement = document.createElement("button");
    notButtonElement.textContent = "no";
    notButtonElement.setAttribute("class", "border rounded px-4 py-1");
    notButtonElement.onclick = function () {
        modal.remove();
        if (callback) callback(false);
    };

    // append buttons to container
    containerButtonElement.appendChild(yesButtonElement);
    containerButtonElement.appendChild(notButtonElement);

    // Append elements to modal content
    modalContent.appendChild(messageElement);
    modalContent.appendChild(containerButtonElement);

    // Append modal content to modal container
    modal.appendChild(modalContent);

    // Append modal to document body
    document.body.appendChild(modal);

}
