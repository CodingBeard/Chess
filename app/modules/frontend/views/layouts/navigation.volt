{# 
@package: BeardSite
@author: Tim Marshall <Tim@CodingBeard.com>
@copyright: (c) 2015, Tim Marshall
@license: New BSD License
#}
<nav role="navigation">
  <div class="container">
    <a id="logo-container" href="/" class="brand-logo">
      <img class="logo" src="{{ url('img/icons/logo-grey-70.png') }}" alt="CodingBeard"/>
      {{ config.application.name }}
    </a>
    <ul class="right hide-on-med-and-down">
      {% set _frontendnav = navbarObject.findFirst('name = "Frontend"') %}
      {% if _frontendnav.id %}
        {% for navlink in _frontendnav.getNavlinks('level = 0') %}
          {% if navlink.children.count() %}
            <li class="no-padding">
              <a class="dropdown-button" href="#" data-activates="dropdown">{{ navlink.label }}</a>
              <ul id="dropdown" class="dropdown-content">
                {% for child in navlink.children %}
                  <li>
                    {% if child.link[0] == '#' %}
                      <a href="{{ child.link }}">{{ child.label }}</a>
                    {% else %}
                      <a href="{{ url(child.link) }}">{{ child.label }}</a>
                    {% endif %}
                  </li>
                {% endfor %}
              </ul>
            </li>
          {% else %}
            <li>
              {% if navlink.link[0] == '#' %}
                <a href="{{ navlink.link }}">{{ navlink.label }}</a>
              {% else %}
                <a href="{{ url(navlink.link) }}">{{ navlink.label }}</a>
              {% endif %}
            </li>
          {% endif %}
        {% endfor %}
      {% endif %}
    </ul>
    <ul id="nav-mobile" class="side-nav hide-on-large-only">
      {% if _frontendnav.id %}
        {% for navlink in _frontendnav.getNavlinks('level = 0') %}
          {% if navlink.children.count() %}
            <li class="no-padding">
              <ul class="collapsible">
                <li class="bold">
                  <a class="collapsible-header" data-activates="collapse1">{{ navlink.label }}</a>

                  <div id="collapse1" class="collapsible-body">
                    <ul>
                      {% for child in navlink.children %}
                        <li>
                          {% if child.link[0] == '#' %}
                            <a href="{{ child.link }}">{{ child.label }}</a>
                          {% else %}
                            <a href="{{ url(child.link) }}">{{ child.label }}</a>
                          {% endif %}
                        </li>
                      {% endfor %}
                    </ul>
                  </div>
                </li>
              </ul>
            </li>
          {% else %}
            <li class="bold">
              {% if navlink.link[0] == '#' %}
                <a href="{{ navlink.link }}">{{ navlink.label }}</a>
              {% else %}
                <a href="{{ url(navlink.link) }}">{{ navlink.label }}</a>
              {% endif %}
            </li>
          {% endif %}
        {% endfor %}
      {% endif %}
      {% set _footernav = navbarObject.findFirst('name = "Footer"') %}
      {% if _footernav.id %}
        {% for navlink in _footernav.getNavlinks('level = 0') %}
          {% if navlink.children.count() %}
            <li class="no-padding">
              <ul class="collapsible">
                <li class="bold">
                  <a class="collapsible-header" data-activates="collapse1">{{ navlink.label }}</a>

                  <div id="collapse1" class="collapsible-body">
                    <ul>
                      {% for child in navlink.children %}
                        <li>
                          {% if child.link[0] == '#' %}
                            <a href="{{ child.link }}">{{ child.label }}</a>
                          {% else %}
                            <a href="{{ url(child.link) }}">{{ child.label }}</a>
                          {% endif %}
                        </li>
                      {% endfor %}
                    </ul>
                  </div>
                </li>
              </ul>
            </li>
          {% else %}
            <li class="bold">
              {% if navlink.link[0] == '#' %}
                <a href="{{ navlink.link }}">{{ navlink.label }}</a>
              {% else %}
                <a href="{{ url(navlink.link) }}">{{ navlink.label }}</a>
              {% endif %}
            </li>
          {% endif %}
        {% endfor %}
      {% endif %}
    </ul>
    <a href="#" data-activates="nav-mobile" class="button-collapse white-text"><i class="mdi-navigation-menu"></i></a>
  </div>
</nav>