<?php
// Include the database connection
global $pdo;
include('dbconnection.php');

try {
    // Get the filter data from the POST request
    $data = json_decode(file_get_contents('php://input'), true);
    $category = $data['category'] ?? 'all';
    $status = $data['status'] ?? 'all';
    $sales_channel = $data['sales_channel'] ?? 'all';
    $search = $data['search'] ?? '';
    $page = $data['page'] ?? 1;
    $country = $data['country'] ?? 'GT';

    // Calculate the offset for pagination (assuming 18 results per page)
    $limit = 18;
    $offset = ($page - 1) * $limit;

    // Start building the query
    $query = "SELECT c.name AS commerce_name, cs.name AS status_name, cs.id AS status_id, 
              cc.id AS category_id, cc.name AS category_name, c.logo, c.restrictions, c.priority,
              IF(c.external_codes_enabled = 1, c.external_codes_description, NULL) AS external_codes_description,
              GROUP_CONCAT(DISTINCT p.name SEPARATOR ', ') AS products,
              GROUP_CONCAT(DISTINCT sc.name SEPARATOR ', ') AS channels,
              GROUP_CONCAT(DISTINCT sc.id SEPARATOR ', ') AS channels_ids
              FROM commerce c
              JOIN commerce_status cs ON cs.id = c.status
                  AND c.status != -1
              JOIN commerce_sales_channels csc ON c.id = csc.commerce_id
              JOIN sales_channels sc ON sc.id = csc.sales_channel_id
              JOIN commerce_category cc ON c.commerce_category_id = cc.id
              LEFT JOIN external_code ec ON c.id = ec.commerce_id
              LEFT JOIN product p ON p.id = ec.product_id
              LEFT JOIN flavorite.user u ON c.id = u.commerce_id
                 AND u.superadmin = 0
                 AND u.active = 1
                 AND u.commerce_id IS NOT NULL
              WHERE 1=1"; // Always true to simplify WHERE clause conditions

    // Apply filters
    if ($category !== 'all') {
        $query .= " AND cc.id = :category";
    }
    if ($status !== 'all') {
        $query .= " AND cs.id = :status";
    }
    if ($sales_channel !== 'all') {
        $query .= " AND FIND_IN_SET(:sales_channel, csc.sales_channel_id) > 0";
    }
    if ($search !== '') {
        $query .= " AND c.name LIKE :search";
    }

    // Add GROUP BY and pagination
    $query .= " GROUP BY c.name, cs.name, cs.id, cc.id, cc.name, c.logo, c.restrictions, c.external_codes_description, c.priority
                ORDER BY c.priority ASC
                LIMIT :limit OFFSET :offset";

    // Prepare the query
    $stmt = $pdo->prepare($query);

    // Bind the parameters
    if ($category !== 'all') {
        $stmt->bindParam(':category', $category, PDO::PARAM_INT);
    }
    if ($status !== 'all') {
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
    }
    if ($sales_channel !== 'all') {
        $stmt->bindParam(':sales_channel', $sales_channel, PDO::PARAM_INT);
    }
    if ($search !== '') {
        $search = "%$search%";
        $stmt->bindParam(':search', $search, PDO::PARAM_STR);
    }
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

    // Execute the query
    $stmt->execute();

    // Fetch the results
    $merchants = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the data as JSON
    echo json_encode(['merchants' => $merchants]);

} catch (PDOException $e) {
    // Handle errors
    echo json_encode(['error' => 'Error retrieving data: ' . $e->getMessage()]);
}

