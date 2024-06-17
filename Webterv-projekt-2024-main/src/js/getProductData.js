document.addEventListener("DOMContentLoaded", function() {
    const removeProductForm = document.querySelector(".product-management form[action='../src/actions/RemoveProduct.php']");
    const removeProductInput = removeProductForm.querySelector("#item_id");
    const removeProductResultDiv = document.createElement("div");
    removeProductForm.appendChild(removeProductResultDiv);

    removeProductInput.addEventListener("keyup", function(event) {
        const productId = parseInt(removeProductInput.value.trim());
        if (isNaN(productId)) {
            removeProductResultDiv.textContent = "";
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../src/actions/InspectProduct.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                const response = xhr.responseText;
                removeProductResultDiv.innerHTML = response !== "" ? "<p>A megadott ID-hoz tartozó termék neve:</p><p>" + response + "</p>" : "<p>Nincs ilyen termék.</p>";

            }
        };

        xhr.send("product_id=" + encodeURIComponent(productId));
    });
});
