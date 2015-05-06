{# 
@package: BeardSite
@author: Tim Marshall <Tim@CodingBeard.com>
@copyright: (c) 2015, Tim Marshall
@license: New BSD License
#}
{% set projects = [
  [
    'ZataBase',
    'ZataBase is a relational database engine written in <a href="http://zephir-lang.com">Zephir</a> with an aim to
    offer an object orientated interface to <a href="http://php.net">PHP</a>. I am using test driven development with
    PHPUnit testing. It is currently in its infancy and is a project to learn about relational databases and Zephir,
    I am doubtful it will ever become used by others.',
    [
      link_to('https://github.com/CodingBeard/ZataBase', 'Open source', false)
    ],
    '2015 - Current'
  ],
  [
    'Phalconskeleton',
    'Phalconskeleton is a skeleton application written in <a href="http://php.net">PHP</a> and
    <a href="http://phalconphp.com/en/">Phalcon 2.0</a> for a multi-module phalcon project. It has a user/permissions
    system, email templating, asset management, form builder, content management, navigation manager, and various other
    plugins.',
    [
      link_to('http://phalconskeleton.codingbeard.com', 'Site', false),
      link_to('https://github.com/CodingBeard/phalconskeleton', 'Open source', false)
    ],
    '2015 - Current'
  ],
  [
    'QuidditchUK',
    'QuidditchUK is the web presence of the UK quidditch association. Written in <a href="http://php.net">PHP</a> and
    <a href="http://phalconphp.com/en/">Phalcon 2.0</a> It delivers news and content; manages clubs, teams, members,
    tournaments, matches and more. It has a complex user management and permissions system.',
    [
      link_to('https://quidditchuk.org', 'Site', false)
    ],
    '2014 - Current'
  ],
  [
    'Chess',
    'A two player chess game written in <a href="http://php.net">PHP</a>, which can calculate possible moves, check,
    and checkmate. It has some code that was working towards an AI player but was never finished. I am currently
    rewriting this.',
    [
      link_to('http://chess.codingbeard.com', 'Site', false),
      link_to('https://github.com/CodingBeard/Chess', 'Open source', false)
    ],
    '2014'
  ],
  [
    'YouthBase',
    'An administration system written in <a href="http://php.net">PHP</a> for the youth centre Close House Hereford.
    I received mentoring while developing this. It was deployed to a Raspberry Pi but sadly was not used due to a
    lack of support with the staff.',
    [
      '<span class="grey-text">Not hosted, or available</span>'
    ],
    '2013 - 2014'
  ],
  [
    'PvM Drops Logger',
    'A logging tool written in <a href="http://php.net">PHP</a> for a type of gameplay in Runescape. It accesses
    public WikiaAPIs to collect data and stay up to date. It is packaged in another open source project which allows
    for PHP desktop applications.',
    [
      link_to('https://dl.dropboxusercontent.com/u/197940643/pvmlogger/index.html', 'Site', false),
      link_to('https://dl.dropboxusercontent.com/u/197940643/pvmlogger/files/source.tar.gz', 'Source', false)
    ],
    '2014'
  ],
  [
    'Clantrack',
    'Clantrack is an experience tracker for the online game Runescape written in <a href="http://php.net">PHP</a> and
    <a href="http://phalconphp.com/en/">Phalcon 1.3.1</a>. My first project. It has moved through multiple revisions
    from procedural PHP to its current OOP revision. It extrapolates historic gains, activity levels, clan records,
    play time, and more from hourly information. It has an attached IRC chat bot which can query the database using
    multiple commands, query online APIs, do unit conversion, and implements a factoid system.',
    [
      link_to('http://clantrack.com', 'Site', false)
    ],
    '2013 - Current'
  ]
] %}