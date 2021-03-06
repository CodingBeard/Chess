{# 
BeardSite
author Tim Marshall
copyright (c) 2015, Tim Marshall
#}
{% if size is not defined %}
  {% set size = 12 %}
{% endif %}
{% if indent is not defined %}
  {% set indent = 0 %}
{% endif %}
<div class="col offset-l{{ indent }} l{{ size }} m12 s12">
  {% if errorMessage %}
    <div class="alert alert-danger alert-dismissible">
      {{ errorMessage }}
    </div>
  {% endif %}
  <label class="{{ error|escape_attr }}" for="{{ key }}">
    {{ label }}
    {% if required is true %}
      <strong style="color: red;">*</strong>
    {% endif %}
    <span class="sublabel">
	  {{ sublabel }}
	</span>
  </label> <br>
  <select {{ requiredAttribute }} name="{{ key|escape_attr }}" class="{{ error|escape_attr }} {{ class|escape_attr }}">
    <option disabled value="">Choose</option>
    {% if options is iterable %}
      {% for option in options %}
        <option value="{{ option.value|escape_attr }}" {{ option.default }}>{{ option.label }}</option>
      {% endfor %}
    {% endif %}
  </select>
</div>