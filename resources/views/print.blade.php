<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <iframe id="pdfFrame" src="{{ $url }}" style="width: 0; height: 0; border: none;"></iframe>
    <script>
        window.onload = function() {
            const iframe = document.getElementById('pdfFrame');
            iframe.onload = function() {
                iframe.contentWindow.print();
            };
        };
    </script>
</body>
</html>
