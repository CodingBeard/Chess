{#
@package: BeardSite
@author: Tim Marshall <Tim@CodingBeard.com>
@copyright: (c) 2015, Tim Marshall
@license: New BSD License
#}
{% extends 'layouts/master.volt' %}

{% block head %}

{% endblock %}

{% block header %}
  {% include "layouts/header.volt" %}
  {% include "layouts/navigation.volt" %}
{% endblock %}

{% block content %}
  <div class="container">
    <canvas id="canvas">

    </canvas>
    <a id="new-game" href="#" class="btn">New Game</a>
    <a id="make-move" href="#" class="btn">Make Move</a>
    <a id="undo-move" href="#" class="btn">Undo Move</a>
  </div>
{% endblock %}

{% block javascripts %}
  <script src="js/easeljs-0.8.0.min.js"></script>
  <script src="js/tweenjs-0.6.0.min.js"></script>
  <script src="js/CodingBeard.Chess.js"></script>
  <script type="text/javascript">
    $(function () {

      var board = new CodingBeard.Chess.Board("canvas");

      board.drawBoard();

      var playerToken = '{{ auth.token }}';
      var socket = new WebSocket('ws://chess.local.com:8080');
      socket.onopen = onOpen;
      socket.onclose = onClose;
      socket.onmessage = onMessage;

      function onOpen(e) {
        socket.send(JSON.stringify({action: "connect", params: {token: playerToken}}));
      }

      function onMessage(e) {
        var responses = JSON.parse(e.data);
        $.each(responses, function (k, response) {
          if (response.type == "alert") {
            switch (response.params.type) {
              case "log":
                console.log(response.params.body);
                break;
              case "alert":
                alert(response.params.body);
                break;
            }
          }
          else if (response.type == "addPieces") {
            board.addPieces(response.params.pieces);
          }
          else if (response.type == "movePiece") {
            board.addPieces(response.params.pieces);
          }
        });
      }

      function onClose(e) {
        console.log("Connection lost.. Trying to reconnect.");
        setTimeout(function () {
          socket = new WebSocket('ws://chess.local.com:8080');
          socket.onopen = onOpen;
          socket.onclose = onClose;
          socket.onmessage = onMessage;
        }, 2000);
      }

      $('#new-game').click(function () {
        socket.send(JSON.stringify({action: "newGame", params: {type: "multiLocal"}}));
      });
      $('#make-move').click(function () {
        board.makeMove({from: {x: 1, y: 1, piece: board.getSquare(1, 1)}, to: {x: 5, y: 5}}, true);
      });

    });
  </script>
{% endblock %}

{% block footer %}
  {% include "layouts/footer.volt" %}
{% endblock %}