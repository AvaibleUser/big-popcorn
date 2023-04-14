{% extends 'base.php' %}

{% block title %}Publicacion {{ publication.title }}{% endblock %}

{% block content %}
  <div class="container mx-auto mt-8">
    <h2 class="text-xl font-medium">{{ publication.title }}</h2>
    <div class="text-gray-600 mt-2">{{ publication.abstract }}</div>
    <div class="mt-2 text-gray-600">{{ publication.publication_date | date("d-m-Y H:i") }}</div>
    <div class="mt-2 text-gray-600">{{ publication.type.name }}</div>
    <div class="mt-4">
      <h3 class="text-lg font-medium">Autores:</h3>
      {% for author in publication.authors %}
        <div class="mt-2"><a href="{{ author.uri }}">{{ author.name }}</a></div>
      {% endfor %}
    </div>
    <div class="mt-4">
      <h3 class="text-lg font-medium">Referencias:</h3>
      {% for reference in publication.references %}
        <div class="mt-2"><a href="{{ reference.uri }}">{{ reference.title }}</a></div>
      {% endfor %}
    </div>
    <div class="mt-4">
      <h3 class="text-lg font-medium">Citas:</h3>
      {% for citation in publication.citations %}
        <div class="mt-2"><a href="{{ citation.uri }}">{{ citation.title }}</a></div>
      {% endfor %}
    </div>
    <div class="mt-4">
      <h3 class="text-lg font-medium">Categorías:</h3>
      {% for category in publication.categories %}
        <div class="mt-2">{{ category.name }}</div>
      {% endfor %}
    </div>
    <div class="mt-4">
      <embed src="data:application/pdf;base64,{{ publication.content }}" type="application/pdf" width="100%" height="600">
    </div>
  </div>
{% endblock %}
