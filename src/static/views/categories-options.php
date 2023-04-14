{% for category in avaibleCategories %}
<option value="{{ category.id }}">{{ category.name }}</option>
{% endfor %}