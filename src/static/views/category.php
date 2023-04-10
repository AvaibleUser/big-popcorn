{% extends 'base.php' %}

{% block content %}
  <div class="container mx-auto mt-8">
    <h2 class="text-xl font-medium">Publicaciones de la categoría {{ category.name }}</h2>
    <div class="grid gap-4 mt-4">
      {% for publication in publications %}
        <div class="border rounded-md p-4">
          <h3 class="text-lg font-medium">{{ publication.title }}</h3>
          <div class="text-gray-600 mt-2">{{ publication.abstract }}</div>
          <a href="{{ publication.uri }}" class="text-blue-600 hover:underline mt-2">{{ publication.uri }}</a>
          <div class="mt-2 text-gray-600">{{ publication.publications_date | date("d-m-Y H:i") }}</div>
          <div class="mt-2 text-gray-600">{{ publication.type.name }}</div>
          <div class="mt-2">{{ publication.content }}</div>
        </div>
      {% endfor %}
    </div>
  </div>
{% endblock %}
