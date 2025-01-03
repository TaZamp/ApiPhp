<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once 'db.php'; // Include the database connection file

$method = $_SERVER['REQUEST_METHOD']; // Get HTTP method

try {
    if ($method == 'GET') {
        // Fetch all dishes or a specific dish by dishId
        if (isset($_GET['id'])) {
            $stmt = $conn->prepare("SELECT * FROM dish WHERE dishId = :id");
            $stmt->bindParam(':id', $_GET['id']);
            $stmt->execute();
            $dish = $stmt->fetch(PDO::FETCH_ASSOC);
            echo $dish ? json_encode($dish) : json_encode(["message" => "Dish not found."]);
        } else {
            $stmt = $conn->prepare("SELECT * FROM dish");
            $stmt->execute();
            $dishes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($dishes);
        }
    } elseif ($method == 'POST') {
        // Insert new dish
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['dishName']) || !isset($data['dishDescription']) || !isset($data['dishPrice'])) {
            echo json_encode(["message" => "Missing required fields."]);
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO dish (dishName, dishDescription, dishPrice, dishAvailability, dishCategory, discount) 
                                VALUES (:dishName, :dishDescription, :dishPrice, :dishAvailability, :dishCategory, :discount)");
        $stmt->bindParam(':dishName', $data['dishName']);
        $stmt->bindParam(':dishDescription', $data['dishDescription']);
        $stmt->bindParam(':dishPrice', $data['dishPrice']);
        $stmt->bindParam(':dishAvailability', $data['dishAvailability']);
        $stmt->bindParam(':dishCategory', $data['dishCategory']);
        $stmt->bindParam(':discount', $data['discount']);
        $stmt->execute();
        echo json_encode(["message" => "Dish added successfully."]);
    } elseif ($method == 'PUT') {
        // Update existing dish
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['dishId']) || !isset($data['dishName']) || !isset($data['dishDescription']) || 
            !isset($data['dishPrice']) || !isset($data['dishAvailability']) || !isset($data['dishCategory']) || !isset($data['discount'])) {
            echo json_encode(["message" => "Missing required fields."]);
            exit();
        }

        $stmt = $conn->prepare("UPDATE dish SET dishName = :dishName, dishDescription = :dishDescription, dishPrice = :dishPrice, 
                                dishAvailability = :dishAvailability, dishCategory = :dishCategory, discount = :discount WHERE dishId = :dishId");
        $stmt->bindParam(':dishId', $data['dishId']);
        $stmt->bindParam(':dishName', $data['dishName']);
        $stmt->bindParam(':dishDescription', $data['dishDescription']);
        $stmt->bindParam(':dishPrice', $data['dishPrice']);
        $stmt->bindParam(':dishAvailability', $data['dishAvailability']);
        $stmt->bindParam(':dishCategory', $data['dishCategory']);
        $stmt->bindParam(':discount', $data['discount']);
        
        if ($stmt->execute()) {
            echo json_encode(["message" => "Dish updated successfully."]);
        } else {
            echo json_encode(["message" => "Failed to update dish."]);
        }
    } elseif ($method == 'DELETE') {
        // Delete dish by dishId
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['dishId'])) {
            $stmt = $conn->prepare("DELETE FROM dish WHERE dishId = :dishId");
            $stmt->bindParam(':dishId', $data['dishId']);
            $stmt->execute();
            echo json_encode(["message" => "Dish deleted successfully."]);
        } else {
            echo json_encode(["message" => "Dish ID is required."]);
        }
    } else {
        echo json_encode(["message" => "Invalid request."]);
    }
} catch (PDOException $exception) {
    echo json_encode(["message" => "Database error: " . $exception->getMessage()]);
}
?>
