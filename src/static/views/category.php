{% extends 'base.php' %}

{% block title %}Categoria {{ category.name }}{% endblock %}

{% block content %}
{% include ('list-publications.php') with {'bunchtitle': 'Publicaciones de la categoría {{ category.name }}'} %}
{% endblock %}
