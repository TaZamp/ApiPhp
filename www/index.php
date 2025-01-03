<!-- index.html -->
<!DOCTYPE html>
<html lang="en">
<head>

    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Menu</title>
    <!-- <link rel="stylesheet" href="assets/css/styles.css"> -->


    <style>

        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #c9df8a;
            padding: 20px;
        }

        .content-wrapper {
            transition: filter 0.3s ease;
        }

        .blur-background {
            filter: blur(5px);
            transition: filter 0.3s ease;
            pointer-events: none;
        }

        h1 {
            color: #f0f7da;
            margin-bottom: 20px;
            font-size: 65px;
            font-weight: bold;
            background-color: #234d20;
            padding-left: 20px;
        }

        h2 {
            color: black;
            font-size: 25px;
            font-weight: bolder;
            text-align: center;
            
            
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            margin: 0 auto;
            margin-top: 20px;
            background-color: white;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #333;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        button:focus {
            outline: none;
        }

        .button1 {
            background-color: #bd2020;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 5px;
            transition: background-color 0.3s ease;
        }

        .button1:hover {
            background-color: #e25412;
        }

        .button1:focus {
            outline: none;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            /* box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5); */
            margin-bottom: 20px;
            width: 40%;
            margin: 0 auto;
            box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;

        }

        form input, form textarea, form select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        form input[type="submit"], form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
        }

        form input[type="submit"]:hover, form button:hover {
            background-color: #45a049;
        }

        /* Edit Form Modal Styling */
        #edit-dish-form {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            /* background-color: white; */
            padding: 20px;
            border-radius: 8px;
            /* box-shadow: 0 2px 5px rgba(0, 0, 0, 1); */
            z-index: 100;
            width: 60%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            backdrop-filter: blur(5px);
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            table {
                font-size: 14px;
            }

            table th, table td {
                padding: 8px;
            }

            form input, form textarea, form select {
                padding: 8px;
            }

            form input[type="submit"], form button {
                padding: 8px 12px;
            }

            #edit-dish-form {
                width: 90%;
            }

            h1 {
                font-size: 40px;
            }
        }

        
    </style>


</head>

<body>
    <div class="content-wrapper">
        <h1>Restaurant Menu</h1>
        
        <div>
            <div>
                <!-- Form to add a new dish -->
                <form id="dishForm" onsubmit="addDish(event)">
                    <h2>Add New Dish</h2>
                    <input type="text" id="dishName" placeholder="Dish Name" required><br>
                    <textarea id="dishDescription" placeholder="Dish Description" required></textarea><br>
                    <input type="number" id="dishPrice" placeholder="Price" step="0.01" required><br>
                    <select id="dishAvailability">
                        <option value="1">Available</option>
                        <option value="0">Not Available</option>
                    </select><br>
                    <input type="text" id="dishCategory" placeholder="Dish Category" required><br>
                    <input type="number" id="discount" placeholder="Discount %" min="0" max="100" required><br>
                    <button type="submit">Add Dish</button>
                </form>
            </div>

            <div style="margin-top: 50px;">
                <!-- Table to display the list of dishes -->
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Availability</th>
                            <th>Category</th>
                            <th>Discount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="dish-list"></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Dish Form -->
    <div id="edit-dish-form">
        <form id="editDishForm" onsubmit="updateDish(event)">
            <h2>Edit Dish</h2>
            <input type="hidden" id="edit-dishId">
            <input type="text" id="edit-dishName" placeholder="Dish Name" required><br>
            <textarea id="edit-dishDescription" placeholder="Dish Description" required></textarea><br>
            <input type="number" id="edit-dishPrice" placeholder="Price" step="0.01" required><br>
            <select id="edit-dishAvailability">
                <option value="1">Available</option>
                <option value="0">Not Available</option>
            </select><br>
            <input type="text" id="edit-dishCategory" placeholder="Dish Category" required><br>
            <input type="number" id="edit-discount" placeholder="Discount %" min="0" max="100" required><br>
            <button type="submit">Update Dish</button>
            <!-- <button type="button" onclick="closeEditForm()">Cancel</button> -->
            
        </form>
    </div>
    <div id="overlay" class="overlay"></div>

    <script src="./assets/js/Adminapp.js"></script>
</body>
</html>