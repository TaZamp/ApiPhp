const apiUrl = "localhost/api/dish.php"; // Ensure this matches your local setup



// Fetch all dishes and display them in the table
async function fetchDishes() {
    try {
        const response = await fetch(apiUrl);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.text(); // Get response as plain text
        const dishes = data ? JSON.parse(data) : []; // Parse JSON only if data is not empty

        const tableBody = document.getElementById("dish-list");
        tableBody.innerHTML = dishes.map(dish => 
            `<tr>
                <td>${dish.dishId}</td>
                <td>${dish.dishName}</td>
                <td>${dish.dishDescription}</td>
                <td>${dish.dishPrice}</td>
                <td>${dish.dishAvailability == 1 ? "Available" : "Not Available"}</td>
                <td>${dish.dishCategory}</td>
                <td>${dish.discount}%</td>
                <td>
                    <button onclick="editDish(${dish.dishId}, '${dish.dishName}', '${dish.dishDescription}', ${dish.dishPrice}, ${dish.dishAvailability}, '${dish.dishCategory}', ${dish.discount})">Edit</button>
                    <button class="button1" onclick="deleteDish(${dish.dishId})">Delete</button>
                </td>
            </tr>`
        ).join('');
    } catch (error) {
        console.error('Failed to fetch dishes:', error);
        alert("Failed to load dishes. Please try again later.");
    }
}


// Add a new dish
async function addDish(event) {
    event.preventDefault();

    
    const dishName = document.getElementById("dishName").value;
    const dishDescription = document.getElementById("dishDescription").value;
    const dishPrice = document.getElementById("dishPrice").value;
    const dishAvailability = document.getElementById("dishAvailability").value;
    const dishCategory = document.getElementById("dishCategory").value;
    const discount = document.getElementById("discount").value;
    
    await fetch(apiUrl, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ dishName, dishDescription, dishPrice, dishAvailability, dishCategory, discount })
    });
    
    fetchDishes();
    event.target.reset();
    
}

// Delete a dish by ID
async function deleteDish(dishId) {
    
        await fetch(apiUrl, {
            method: "DELETE",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ dishId })
        });

        fetchDishes();
    
}


// Initialize and fetch data on page load
document.addEventListener("DOMContentLoaded", fetchDishes);

// Populate the edit form with existing dish details
function editDish(dishId, dishName, dishDescription, dishPrice, dishAvailability, dishCategory, discount) {
    document.getElementById('edit-dishId').value = dishId;
    document.getElementById('edit-dishName').value = dishName;
    document.getElementById('edit-dishDescription').value = dishDescription;
    document.getElementById('edit-dishPrice').value = dishPrice;
    document.getElementById('edit-dishAvailability').value = dishAvailability;
    document.getElementById('edit-dishCategory').value = dishCategory;
    document.getElementById('edit-discount').value = discount;
    document.getElementById('edit-dish-form').style.display = 'block';
}

// Update an existing dish
async function updateDish(event) {
    event.preventDefault();

    const dishData = {
        dishId: document.getElementById("edit-dishId").value,
        dishName: document.getElementById("edit-dishName").value,
        dishDescription: document.getElementById("edit-dishDescription").value,
        dishPrice: document.getElementById("edit-dishPrice").value,
        dishAvailability: document.getElementById("edit-dishAvailability").value,
        dishCategory: document.getElementById("edit-dishCategory").value,
        discount: document.getElementById("edit-discount").value,
    };

    try {
        const response = await fetch(apiUrl, {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(dishData)
        });

        if (!response.ok) throw new Error("Failed to update dish.");
        alert("Dish updated successfully!");
        document.getElementById('edit-dish-form').style.display = 'none';
        fetchDishes();
    } catch (error) {
        console.error(error);
        alert("Failed to update dish.");
    }
}


// Add event listener for the update form submission
document.getElementById("editDishForm").addEventListener("submit", updateDish);


