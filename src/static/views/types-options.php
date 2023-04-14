{% for type in avaibleTypes %}
<option value="{{ type.id }}">{{ type.name }}</option>
{% endfor %}