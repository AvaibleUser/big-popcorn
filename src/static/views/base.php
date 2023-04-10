<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://unpkg.com/@daisyui/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body class="bg-white dark:bg-gray-800">
    <header class="bg-primary-500">
      <nav class="container mx-auto px-4">
        <div class="flex justify-between">
          <a href="/" class="text-white font-bold text-2xl my-4">BigPopcorn</a>
          <button class="btn btn-primary">Log in</button>
        </div>
      </nav>
    </header>
    <div class="container mx-auto px-4">
      <h1 class="text-2xl font-bold mt-8 mb-4"><?= $heading ?></h1>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <?= $content ?>
      </div>
    </div>
  </body>
</html>
