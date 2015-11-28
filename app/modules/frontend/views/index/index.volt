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
    <canvas id="canvas">

    </canvas>

    <div id="alert-modal" class="modal">
      <div class="modal-content">
        <h4 class="modal-header center"></h4>

        <p class="modal-message"></p>
      </div>
      <div class="modal-footer">
        <span class="modal-links">

        </span>
      </div>
    </div>

    <a id="new-game" href="#" class="btn">New Game</a>
{% endblock %}

{% block javascripts %}
  <script src="js/easeljs-0.8.0.min.js"></script>
  <script src="js/tweenjs-0.6.0.min.js"></script>
  <script src="js/CodingBeard/Chess/Canvas.js"></script>
  <script src="js/CodingBeard/Chess/Board.js"></script>
  <script type="text/javascript">
    $(function () {
      var socket;

      connect();

      function connect() {
        socket = new WebSocket("ws://chess.codingbeard.com:8080");
        socket.onopen = onOpen;
        socket.onclose = onClose;
        socket.onmessage = onMessage;
      }

      var canvas = new CodingBeard.Chess.Canvas("canvas", 2000, 2000);
      var board = new CodingBeard.Chess.Board(canvas);

      board.drawBoard(0, 0);

      function onOpen(e) {
        board.socket = socket;
        socket.send(JSON.stringify({action: "connect", params: {token: "{{ auth.token }}"}}));
      }

      function onClose(e) {
        board.alert({type: "toast", message: "Connection lost, trying to reconnect.."});
        setTimeout(function () {
          connect();
        }, 2000);
      }

      function onMessage(e) {
        var responses = JSON.parse(e.data);
        $.each(responses, function (k, response) {
          if (response.type == "alert") {
            board.alert(response.params);
          }
          else if (response.type == "setGame") {
            board.gameId = response.params.id;
            board.turn = response.params.turn;
          }
          else if (response.type == "addPieces") {
            board.addPieces(response.params.pieces);
          }
          else if (response.type == "invalidMove") {
            board.invalidMove();
          }
          else if (response.type == "highlightSquares") {
            board.highlightSquares(response.params);
          }
        });
      }

      $('#new-game').click(function () {
        board.send({action: "newGame", params: {type: "multiLocal"}});
      });

    });
  </script>
{% endblock %}

{% block footer %}
  {% include "layouts/footer.volt" %}
{% endblock %}
