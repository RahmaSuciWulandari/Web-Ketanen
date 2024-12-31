<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Loading Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        @keyframes zoomInOut {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }
        }

        .animate-zoom {
            animation: zoomInOut 2s infinite;
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="flex flex-col items-center">
        <img alt="Company logo with a placeholder image of 150x150 pixels" class="w-24 h-24 mb-4 animate-zoom"
            height="150" src="https://th.bing.com/th/id/OIP.xy1BLFaIZuzx0zUyYkK4WwHaHP?w=171&h=180&c=7&r=0&o=5&pid=1.7"
            width="150" />
    </div>
</body>

</html>