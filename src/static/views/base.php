<!DOCTYPE html>
<html class="min-w-screen min-h-screen">
  <head>
    <meta charset="utf-8">
    <title>{% block title %}{% endblock %}</title>
    <link rel="stylesheet" href="/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body class="bg-primary-200 min-h-screen">
    <header>
      <nav class="navbar p-4">
        <div class="flex-1">
          <a class="btn btn-ghost normal-case text-xl" href="/dashboard.html">
            <span class="uppercase text-primary">BIG</span>
            <span class="lowercase">popcorn</span>
          </a>
        </div>
        <div class="flex-none gap-2">
          <div class="form-control">
            <input
              id="search-publication"
              type="text"
              placeholder="Buscar publicacion"
              class="input input-bordered"
            />
          </div>
          <div class="dropdown dropdown-end">
            <a tabindex="0" class="btn btn-ghost normal-case">Cuenta</a>
            <ul tabindex="0" class="mt-3 p-2 shadow menu menu-compact dropdown-content bg-base-100 rounded-box w-52">
              <li id="publish"><a>Publicar...</a></li>
              <li id="session"><a></a></li>
              <li id="register"><a>Registrarse</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <main class="bg-neutral m-0 py-4 px-8 h-fit min-h-screen">
      {% block content %}{% endblock %}
    </main>
  </body>
  {% block scripts %}{% endblock %}
  <script src="/js/index.js"></script>
</html>
