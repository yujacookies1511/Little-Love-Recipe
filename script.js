document.addEventListener("DOMContentLoaded", () => {
    const userId = 1; // Assume user_id is 1 for this example
    const cartItems = [];
    const cartTable = document.getElementById("cart-items");
    const totalPriceElement = document.getElementById("total-price");

    // Fetch items from the server (using GET method)
    function loadCart() {
        fetch(`cart.php?user_id=${userId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    cartItems.length = 0; // Clear current cart
                    data.items.forEach(item => {
                        cartItems.push(item);
                    });
                    updateCart();
                } else {
                    alert('Failed to load cart.');
                }
            });
    }

    // Update cart display
    function updateCart() {
        cartTable.innerHTML = ""; // Clear the cart table
        let total = 0;

        cartItems.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;

            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${item.item_name}</td>
                <td>$${item.price.toFixed(2)}</td>
                <td>
                    <input type="number" min="1" value="${item.quantity}" data-index="${index}" class="quantity-input">
                </td>
                <td>$${itemTotal.toFixed(2)}</td>
                <td>
                    <button class="remove-btn" data-index="${index}">Remove</button>
                </td>
            `;
            cartTable.appendChild(row);
        });

        totalPriceElement.textContent = total.toFixed(2);
    }

    // Add item to cart and save to the database
    document.getElementById("add-item-btn").addEventListener("click", () => {
        const itemName = document.getElementById("item-name").value.trim();
        const itemPrice = parseFloat(document.getElementById("item-price").value);
        const itemQuantity = parseInt(document.getElementById("item-quantity").value);

        if (itemName && !isNaN(itemPrice) && itemPrice > 0 && itemQuantity > 0) {
            // Add the item to the local cart array
            cartItems.push({ item_name: itemName, price: itemPrice, quantity: itemQuantity });

            // Send POST request to the server to save the item to the database
            fetch('cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    user_id: userId,
                    item_name: itemName,
                    quantity: itemQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    updateCart();
                    document.getElementById("item-name").value = "";
                    document.getElementById("item-price").value = "";
                    document.getElementById("item-quantity").value = "";
                } else {
                    alert('Failed to add item to cart.');
                }
            });
        } else {
            alert("Please enter valid item details.");
        }
    });

    // Remove item from the cart and update the database
    cartTable.addEventListener("click", (event) => {
        if (event.target.classList.contains("remove-btn")) {
            const index = event.target.getAttribute("data-index");
            const itemId = cartItems[index].id;

            // Remove the item from the local cart array
            cartItems.splice(index, 1);

            // Send DELETE request to the server to remove the item from the database
            fetch(`cart.php?user_id=${userId}&item_id=${itemId}`, { method: 'DELETE' })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        updateCart();
                    } else {
                        alert('Failed to remove item.');
                    }
                });
        }
    });

    // Update quantity of an item in the cart
    cartTable.addEventListener("input", (event) => {
        if (event.target.classList.contains("quantity-input")) {
            const index = event.target.getAttribute("data-index");
            const newQuantity = parseInt(event.target.value, 10);

            if (newQuantity > 0) {
                cartItems[index].quantity = newQuantity;

                // Send PUT request to update the item quantity in the database
                fetch('cart.php', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        user_id: userId,
                        item_id: cartItems[index].id,
                        quantity: newQuantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        updateCart();
                    } else {
                        alert('Failed to update quantity.');
                    }
                });
            }
        }
    });

    // Load the cart when the page is loaded
    loadCart();
});