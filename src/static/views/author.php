{% extends 'base.php' %}

{% block title %}Autor {{ author.name }}{% endblock %}

{% block content %}
{% include ('list-publications.php') with {'bunchtitle': 'Publicaciones de {{ author.name }}'} %}
{% endblock %}
