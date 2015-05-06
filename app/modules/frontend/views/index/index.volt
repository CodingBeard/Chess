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
  </div>
{% endblock %}

{% block javascripts %}
  <script src="js/easeljs-0.8.0.min.js"></script>
  <script src="js/tweenjs-0.6.0.min.js"></script>
  <script type="text/javascript">
    $(function () {
      var canvas, stage, update = true, loadedImages = [], square, scale, dragging = false,
          move = {from: {x: 0, y: 0}, to: {x: 0, y: 0}};
      var squares = {1: {}, 2: {}, 3: {}, 4: {}, 5: {}, 6: {}, 7: {}, 8: {}};

      init();

      function init() {
        canvas = document.getElementById("canvas");
        stage = new createjs.Stage(canvas);
        onResize();
        drawBoard();

        stage.enableMouseOver(10);
      }

      function drawBoard() {
        var icon;

        stage.addChild(makeBitmap("/img/chess/board.jpg"));

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

        addPieces({{ board.toString() }});

        stage.update();

        window.onresize = function () {
          onResize();
        };

        createjs.Ticker.addEventListener("tick", tick);
      }

      function addPieces(pieces) {
        for (var x = 1; x < 9; x += 1) {
          for (var y = 1; y < 9; y += 1) {
            square = new createjs.Container();
            squares[x][y] = square;
            stage.addChild(square);

            if (pieces[x - 1][y - 1]) {
              var piece = new createjs.Container();
              piece.location = {x: x, y: 9 - y};
              piece.x = x * 200;
              piece.y = y * 200;
              var rectangle = new createjs.Graphics().beginFill("#fff").drawRect(0, 0, 200, 200);
              piece.addChild(new createjs.Shape()).set({graphics: rectangle, alpha: 0.01});

              var image;
              if (pieces[x - 1][y - 1][0] == 0) {
                image = makeBitmap("/img/chess/pieces/white/" + pieces[x - 1][y - 1][1] + ".png");
                image.shadow = new createjs.Shadow("#000", 1, 1, 20);
              }
              else {
                image = makeBitmap("/img/chess/pieces/black/" + pieces[x - 1][y - 1][1] + ".png");
                image.shadow = new createjs.Shadow("#000", 1, 1, 5);
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
                this.x = (evt.stageX / scale) + this.offset.x;
                this.y = (evt.stageY / scale) + this.offset.y;
                update = true;
                dragging = true;
              });

              piece.on("pressup", function (evt) {
                move.to = {
                  x: Math.floor(((evt.stageX / scale)) / 200),
                  y: Math.floor((2000 - ((evt.stageY / scale))) / 200)
                };
                this.x = move.to.x * 200;
                this.y = (9 - move.to.y) * 200;
                this.location = move.to;
                update = true;
                dragging = false;
              });
            }
            else {
              squares[x][y].removeChildAt(0);
              squares[x][y].removeChildAt(1);
            }
          }
        }
      }

      function tick(event) {
        if (update) {
          update = false;
          stage.update(event);
        }
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
    });
  </script>
{% endblock %}

{% block footer %}
  {% include "layouts/footer.volt" %}
{% endblock %}