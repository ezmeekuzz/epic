<!-- app/Views/pdf/preview.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Preview</title>
</head>
<body>
    <embed src="data:application/pdf;base64,<?php echo base64_encode($pdfContent); ?>" width="100%" height="800px" type="application/pdf">
</body>
</html>
