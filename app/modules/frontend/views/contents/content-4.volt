{% set projects = [
      [
        'ZataBase',
        'ZataBase is a relational database engine written in <a href="http://zephir-lang.com">Zephir</a> with an aim to
        offer an object orientated interface to php scripts. I am using test driven development with PHPUnit testing.
        It is currently in its infancy and is a project to learn about relational databases and Zephir, I am
        doubtful it will ever become used by others.',
        [
          link_to('https://github.com/CodingBeard/ZataBase', 'Open source', false)
        ],
        '2015 - Current'
      ],
      [
        'Phalconskeleton',
        'Phalconskeleton is a skeleton application written in <a href="http://phalconphp.com/en/">Phalcon 2.0</a> for a
        multi-module phalcon project. It has a user/permissions system, email templating, asset management, form builder,
        content management, navigation manager, and various other plugins.',
        [
          link_to('https://phalconskeleton.codingbeard.com', 'Site', false),
          link_to('https://github.com/CodingBeard/phalconskeleton', 'Open source', false)
        ],
        '2015 - Current'
      ],
      [
        'QuidditchUK',
        'QuidditchUK is the web presence of the UK quidditch association. Written in
        <a href="http://phalconphp.com/en/">Phalcon 2.0</a> It delivers news and content; manages clubs, teams, members,
        tournaments, matches and more. It has a complex user management and permissions system.',
        [
          link_to('https://quidditchuk.org', 'Site', false)
        ],
        '2014 - Current'
      ],
      [
        'Chess',
        'A two player chess game written in php, which can calculate possible moves, check, and checkmate. It has some code that was
        working towards an AI player but was never finished. I hope to rewrite and host this online with knowledge
        gained since first creating it. It was the most enjoyable project I have worked on.',
        [
          '<span class="grey-text">Not hosted, or available</span>'
        ],
        '2014'
      ],
      [
        'YouthBase',
        'My first attempt at OOP programming, an administration system written in php for the youth centre Close House Hereford.
        I received mentoring while developing this. It was deployed to a Raspberry Pi but sadly was not used due to a lack of
        support with the staff.',
        [
          '<span class="grey-text">Not hosted, or available</span>'
        ],
        '2013 - 2014'
      ],
      [
        'PvM Drops Logger',
        'A logging tool written in PHP for a type of gameplay in Runescape. It accesses public WikiaAPIs to collect data and stay up to
        date. It is packaged in another open source project which allows for php desktop applications.',
        [
          link_to('https://dl.dropboxusercontent.com/u/197940643/pvmlogger/index.html', 'Site', false),
          link_to('https://dl.dropboxusercontent.com/u/197940643/pvmlogger/files/source.tar.gz', 'Source', false)
        ],
        '2014'
      ],
      [
        'Clantrack',
        'The first programming I ever did. It has moved through multiple revisions from procedural PHP to the
        now OOP MVC, and Javascript powered application it is.
        Clantrack is an experience tracker for the online game Runescape written in <a href="http://phalconphp.com/en/">Phalcon 1.3.1</a>.
        It extrapolates historic gains, activity levels, clan records, play time, and more from hourly information. It has an attached IRC
        chat bot which can query the database using multiple commands, query online APIs, do unit conversion, and implements a factoid system.',
        [
          link_to('clantrack.com', 'Site', false)
        ],
        '2013 - Current'
      ]
    ] %}
    
    {% set size = 6 %}
    {% for key, project in projects %}
      {% if key % 2 == 0 %}
        <div class="row">
        {% if key == projects|length - 1 %}
          {% set size = 12 %}
        {% endif %}
      {% endif %}
      <div class="col s12 m{{ size }}">
        <div class="card grey darken-1">
          <div class="card-content white-text">
            <span class="card-title">{{ project[0] }}</span>

            <p>{{ project[1] }}</p>
          </div>
          <div class="card-action">
            {% if project[2] is iterable %}
              {% for link in project[2] %}
                {{ link }}
              {% endfor %}
            {% endif %}
            <span class="right grey-text">{{ project[3] }}</span>
          </div>
        </div>
      </div>
      {% if key % 2 != 0 %}
        </div>
      {% endif %}
    {% endfor %}