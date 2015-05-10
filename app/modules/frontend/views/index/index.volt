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
  </div>
{% endblock %}

{% block javascripts %}
  <script src="js/easeljs-0.8.0.min.js"></script>
  <script src="js/tweenjs-0.6.0.min.js"></script>
  <script type="text/javascript">
    $(function () {
      var canvas, stage, update = true, loadedImages = [], square, scale, dragging = false, tween = false,
          move = {from: {x: 0, y: 0}, to: {x: 0, y: 0}}, pieces;
      var squares = {1: {}, 2: {}, 3: {}, 4: {}, 5: {}, 6: {}, 7: {}, 8: {}};

      init();

      function init() {
        canvas = document.getElementById("canvas");
        stage = new createjs.Stage(canvas);
        onResize();
        drawBoard();

        stage.enableMouseOver(10);
        stage.mouseMoveOutside = true;
      }

      function drawBoard() {
        var icon;

        stage.addChild(makeBitmap("/img/chess/board.jpg"));
        pieces = new createjs.Container();
        stage.addChild(pieces);

        for (var i = 1; i < 9; i += 1) {
          icon = makeBitmap("/img/chess/letters/" + i + ".png");
          icon.x = 200 * i;
          icon.alpha = 0.7;
          icon.shadow = new createjs.Shadow("#000000", 2, 2, 10);
          stage.addChild(icon);

          icon = makeBitmap("/img/chess/letters/" + i + ".png");
          icon.x = 200 * i;
          icon.y = 1800;
          icon.alpha = 0.7;
          icon.shadow = new createjs.Shadow("#000000", 2, 2, 10);
          stage.addChild(icon);

          icon = makeBitmap("/img/chess/numbers/" + (9 - i) + ".png");
          icon.y = 200 * i;
          icon.alpha = 0.7;
          icon.shadow = new createjs.Shadow("#000000", 2, 2, 10);
          stage.addChild(icon);

          icon = makeBitmap("/img/chess/numbers/" + (9 - i) + ".png");
          icon.x = 1800;
          icon.y = 200 * i;
          icon.alpha = 0.7;
          icon.shadow = new createjs.Shadow("#000000", 2, 2, 10);
          stage.addChild(icon);
        }

        stage.update();

        window.onresize = function () {
          onResize();
        };
        createjs.Ticker.setFPS(20);
        createjs.Ticker.addEventListener("tick", tick);
      }

      function addPieces(locations) {
        pieces.removeAllChildren();
        for (var x = 1; x < 9; x += 1) {
          for (var y = 1; y < 9; y += 1) {
            square = new createjs.Container();
            squares[x][y] = square;
            pieces.addChild(square);

            if (locations[x - 1][y - 1]) {
              addPiece(locations[x - 1][y - 1], x, y);
            }
            else {
              squares[x][y].removeChildAt(0);
              squares[x][y].removeChildAt(1);
            }
          }
        }
      }

      function addPiece(definition, x, y) {
        var piece = new createjs.Container();
        piece.location = {x: x, y: 9 - y};
        piece.x = x * 200;
        piece.y = y * 200;
        var rectangle = new createjs.Graphics().beginFill("#fff").drawRect(0, 0, 200, 200);
        piece.addChild(new createjs.Shape()).set({graphics: rectangle, alpha: 0.01});

        var image;
        if (definition[0] == 0) {
          image = makeBitmap("/img/chess/pieces/white/" + definition[1] + ".png");
          image.shadow = new createjs.Shadow("#000", 1, 1, 20);
        }
        else {
          image = makeBitmap("/img/chess/pieces/black/" + definition[1] + ".png");
          image.shadow = new createjs.Shadow("#000", 1, 1, 2);
        }
        piece.addChild(image);
        square.addChild(piece);


        piece.on("rollover", function (evt) {
          var image = this.getChildAt(1);
          if (image) {
            this.cursor = "pointer";
            image.x = image.x - 20;
            image.y = image.y - 20;
            image.scaleX = image.scaleY = 1.2;
            update = true;
          }
        });

        piece.on("rollout", function (evt) {
          var image = this.getChildAt(1);
          if (image) {
            this.cursor = "";
            image.x = image.x + 20;
            image.y = image.y + 20;
            image.scaleX = image.scaleY = 1;
            update = true;
          }
        });

        piece.on("mousedown", function (evt) {
          this.offset = {x: this.x - (evt.stageX / scale), y: this.y - (evt.stageY / scale)};
          move.from = this.location;
        });

        piece.on("pressmove", function (evt) {
          var x = Math.floor(((evt.stageX / scale)) / 200);
          var y = Math.floor((2000 - ((evt.stageY / scale))) / 200);

          if (0 < x && x < 9 && 0 < y && y < 9) {
            move.to = {x: x, y: y};
            this.x = (evt.stageX / scale) + this.offset.x;
            this.y = (evt.stageY / scale) + this.offset.y;
          }
          else {
            if (1 > x) {
              if (1 > y) {
                move.to = {x: 1, y: 1};
                this.x = 200 + this.offset.x;
                this.y = 1800 + this.offset.y;
              }
              else if (8 < y) {
                move.to = {x: 1, y: 8};
                this.x = 200 + this.offset.x;
                this.y = 200 + this.offset.y;
              }
              else {
                move.to = {x: 1, y: y};
                this.x = 200 + this.offset.x;
                this.y = (evt.stageY / scale) + this.offset.y;
              }
            }
            else if (8 < x) {
              if (1 > y) {
                move.to = {x: 8, y: 1};
                this.x = 1800 + this.offset.x;
                this.y = 1800 + this.offset.y;
              }
              else if (8 < y) {
                move.to = {x: 8, y: 8};
                this.x = 1800 + this.offset.x;
                this.y = 200 + this.offset.y;
              }
              else {
                move.to = {x: 8, y: y};
                this.x = 1800 + this.offset.x;
                this.y = (evt.stageY / scale) + this.offset.y;
              }
            }
            else if (1 > y) {
              if (1 > x) {
                move.to = {x: 1, y: 1};
                this.x = 200 + this.offset.x;
                this.y = 1800 + this.offset.y;
              }
              else if (8 < x) {
                move.to = {x: 8, y: 1};
                this.x = 1800 + this.offset.x;
                this.y = 200 + this.offset.y;
              }
              else {
                move.to = {x: x, y: 1};
                this.x = (evt.stageX / scale) + this.offset.x;
                this.y = 1800 + this.offset.y;
              }
            }
            else if (8 < y) {
              if (1 > x) {
                move.to = {x: 1, y: 8};
                this.x = 200 + this.offset.x;
                this.y = 1800 + this.offset.y;
              }
              else if (8 < x) {
                move.to = {x: 8, y: 8};
                this.x = 1800 + this.offset.x;
                this.y = 1800 + this.offset.y;
              }
              else {
                move.to = {x: x, y: 8};
                this.x = (evt.stageX / scale) + this.offset.x;
                this.y = 200 + this.offset.y;
              }
            }
          }
          update = true;
          dragging = true;
        });

        piece.on("pressup", function (evt) {
          this.x = move.to.x * 200;
          this.y = (9 - move.to.y) * 200;
          this.location = move.to;
          update = true;
          dragging = false;
        });
      }

      function tick(event) {
        if (update || tween) {
          update = false;
          stage.update(event);
        }
      }

      function tweenToSquare(piece, x, y, time) {
        if (!time) {
          time = 1000;
        }
        tween = true;
        createjs.Tween.get(piece, {loop: false}).to({
          x: x * 200,
          y: (9 - y) * 200
        }, time).wait(100).call(function () {
          tween = false;
        });
      }

      function makeBitmap(url) {
        image = new Image();
        image.src = url;

        if (loadedImages.indexOf(url) == -1) {
          image.onload = function () {
            update = true;
          };
          loadedImages.push(url);
        }
        return new createjs.Bitmap(image);
      }

      function onResize() {
        var w = window.innerWidth;
        var h = window.innerHeight - 120;

        var ow = 2000;
        var oh = 2000;

        scale = Math.min(w / ow, h / oh);
        stage.scaleX = scale;
        stage.scaleY = scale;

        stage.canvas.width = ow * scale;
        stage.canvas.height = oh * scale;

        stage.update()
      }

      var playerId = '{{ auth.token }}';
      var socket = new WebSocket('ws://chess.local.com:8080');
      socket.onopen = onOpen;
      socket.onclose = onClose;
      socket.onmessage = onMessage;

      function onOpen(e) {
        socket.send(JSON.stringify({action: "connect", params: {playerId: playerId}}));
      }

      function onMessage(e) {
        var response = JSON.parse(e.data);
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
        socket.send('{"type": "hi"}');
      })
    });
  </script>
{% endblock %}

{% block footer %}
  {% include "layouts/footer.volt" %}
{% endblock %}