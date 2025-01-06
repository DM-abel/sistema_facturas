<?php
header('Content-Type: application/json');

try {
    // Recibir los datos
    $facturaData = json_decode($_POST['facturaData'], true);
    $pdfFile = $_FILES['pdf'];

    // Directorio donde se guardarán los PDFs
    $uploadDir = 'facturas/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Guardar el archivo PDF
    $pdfPath = $uploadDir . $pdfFile['name'];
    move_uploaded_file($pdfFile['tmp_name'], $pdfPath);

    // Guardar los datos de la factura (por ejemplo, en un archivo JSON)
    $jsonPath = $uploadDir . 'factura-' . $facturaData['numeroFactura'] . '.json';
    file_put_contents($jsonPath, json_encode($facturaData));

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
