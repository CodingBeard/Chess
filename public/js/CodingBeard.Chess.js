var CodingBeard = CodingBeard || {};
CodingBeard.Chess = CodingBeard.Chess || {};


CodingBeard.Chess.Board = function (canvasId) {
  var Board = this;
  this.canvas = document.getElementById(canvasId);
  this.stage = new createjs.Stage(this.canvas);
  this.pieces = new createjs.Container();

  this.onResize();
  window.onresize = function () {
    Board.onResize();
  };

  this.stage.enableMouseOver(10);
  this.stage.mouseMoveOutside = true;
  createjs.Ticker.setFPS(20);
  createjs.Ticker.addEventListener("tick", this.tick);
};

var Board = CodingBeard.Chess.Board;

Board.prototype.canvas = false;
Board.prototype.stage = false;
Board.prototype.update = false;
Board.prototype.pieces = false;
Board.prototype.dragging = false;
Board.prototype.tween = false;
Board.prototype.loadedImages = [];
Board.prototype.squares = {1: {}, 2: {}, 3: {}, 4: {}, 5: {}, 6: {}, 7: {}, 8: {}};
Board.prototype.history = [];
Board.prototype.turn = 0;
Board.prototype.move = {from: {x: 0, y: 0, piece: false}, to: {x: 0, y: 0, piece: false}};

Board.prototype.drawBoard = function () {
  var Board = this;
  var icon;
  this.stage.addChild(this.makeBitmap("/img/chess/board.jpg"));
  this.stage.addChild(this.pieces);

  for (var i = 1; i < 9; i += 1) {
    icon = this.makeBitmap("/img/chess/letters/" + i + ".png");
    icon.x = 200 * i;
    icon.alpha = 0.7;
    icon.shadow = new createjs.Shadow("#000000", 2, 2, 10);
    this.stage.addChild(icon);

    icon = this.makeBitmap("/img/chess/letters/" + i + ".png");
    icon.x = 200 * i;
    icon.y = 1800;
    icon.alpha = 0.7;
    icon.shadow = new createjs.Shadow("#000000", 2, 2, 10);
    this.stage.addChild(icon);

    icon = this.makeBitmap("/img/chess/numbers/" + (9 - i) + ".png");
    icon.y = 200 * i;
    icon.alpha = 0.7;
    icon.shadow = new createjs.Shadow("#000000", 2, 2, 10);
    this.stage.addChild(icon);

    icon = this.makeBitmap("/img/chess/numbers/" + (9 - i) + ".png");
    icon.x = 1800;
    icon.y = 200 * i;
    icon.alpha = 0.7;
    icon.shadow = new createjs.Shadow("#000000", 2, 2, 10);
    this.stage.addChild(icon);
  }

  this.stage.update();
};

Board.prototype.getSquare = function (x, y) {
  var Board = this;
  if (this.squares[x][y].getChildAt(0)) {
    return this.squares[x][y].getChildAt(0);
  }
};

Board.prototype.setSquare = function (x, y, piece) {
  var Board = this;
  if (this.squares[x][y]) {
    this.squares[x][y].removeAllChildren();
    if (piece) {
      this.squares[x][y].addChild(piece);
    }
  }
};

Board.prototype.addPieces = function (locations) {
  var Board = this;
  this.pieces.removeAllChildren();
  for (var x = 1; x < 9; x += 1) {
    for (var y = 1; y < 9; y += 1) {
      square = new createjs.Container();
      this.squares[x][y] = square;
      this.pieces.addChild(square);

      if (locations[x - 1][y - 1]) {
        this.setSquare(x, y, this.makePiece(locations[x - 1][y - 1], x, y));
      }
      else {
        this.setSquare(x, y, false);
      }
    }
  }
  this.update = true;
};

Board.prototype.makePiece = function (definition, x, y) {
  var Board = this;
  var piece = new createjs.Container();
  piece.definition = definition;
  piece.location = {x: x, y: y};
  piece.x = x * 200;
  piece.y = (9 - y) * 200;
  var rectangle = new createjs.Graphics().beginFill("#fff").drawRect(0, 0, 200, 200);
  piece.addChild(new createjs.Shape()).set({graphics: rectangle, alpha: 0.01});

  var image;
  if (definition[0] == 0) {
    image = this.makeBitmap("/img/chess/pieces/white/" + definition[1] + ".png");
    image.shadow = new createjs.Shadow("#000", 1, 1, 20);
  }
  else {
    image = this.makeBitmap("/img/chess/pieces/black/" + definition[1] + ".png");
    image.shadow = new createjs.Shadow("#000", 1, 1, 2);
  }
  piece.addChild(image);

  piece.on("rollover", function (evt) {
    var image = this.getChildAt(1);
    if (image) {
      console.log('rollover');
      piece.cursor = "pointer";
      image.x = image.x - 20;
      image.y = image.y - 20;
      image.scaleX = image.scaleY = 1.2;
      Board.update = true;
    }
  });

  piece.on("rollout", function (evt) {
    var image = this.getChildAt(1);
    if (image) {
      console.log('rollout');
      piece.cursor = "";
      image.x = image.x + 20;
      image.y = image.y + 20;
      image.scaleX = image.scaleY = 1;
      Board.update = true;
    }
  });

  piece.on("mousedown", function (evt) {
    piece.offset = {x: piece.x - (evt.stageX / scale), y: piece.y - (evt.stageY / scale)};
    Board.move.from = {x: piece.location.x, y: piece.location.y, piece: piece};
  });

  piece.on("pressmove", function (evt) {
    var x = Math.floor(((evt.stageX / scale)) / 200);
    var y = Math.floor((2000 - ((evt.stageY / scale))) / 200);

    if (0 < x && x < 9 && 0 < y && y < 9) {
      Board.move.to = {x: x, y: y, piece: Board.getSquare(x, y)};
      piece.x = (evt.stageX / scale) + piece.offset.x;
      piece.y = (evt.stageY / scale) + piece.offset.y;
    }
    else {
      if (1 > x) {
        if (1 > y) {
          Board.move.to = {x: 1, y: 1, piece: Board.getSquare(1, 1)};
          piece.x = 200 + piece.offset.x;
          piece.y = 1800 + piece.offset.y;
        }
        else if (8 < y) {
          Board.move.to = {x: 1, y: 8, piece: Board.getSquare(1, 8)};
          piece.x = 200 + piece.offset.x;
          piece.y = 200 + piece.offset.y;
        }
        else {
          Board.move.to = {x: 1, y: y, piece: Board.getSquare(1, y)};
          piece.x = 200 + piece.offset.x;
          piece.y = (evt.stageY / scale) + piece.offset.y;
        }
      }
      else if (8 < x) {
        if (1 > y) {
          Board.move.to = {x: 8, y: 1, piece: Board.getSquare(8, 1)};
          piece.x = 1800 + piece.offset.x;
          piece.y = 1800 + piece.offset.y;
        }
        else if (8 < y) {
          Board.move.to = {x: 8, y: 8, piece: Board.getSquare(8, 8)};
          piece.x = 1800 + piece.offset.x;
          piece.y = 200 + piece.offset.y;
        }
        else {
          Board.move.to = {x: 8, y: y, piece: Board.getSquare(8, y)};
          piece.x = 1800 + piece.offset.x;
          piece.y = (evt.stageY / scale) + piece.offset.y;
        }
      }
      else if (1 > y) {
        if (1 > x) {
          Board.move.to = {x: 1, y: 1, piece: Board.getSquare(1, 1)};
          piece.x = 200 + piece.offset.x;
          piece.y = 1800 + piece.offset.y;
        }
        else if (8 < x) {
          Board.move.to = {x: 8, y: 1, piece: Board.getSquare(8, 1)};
          piece.x = 1800 + piece.offset.x;
          piece.y = 200 + piece.offset.y;
        }
        else {
          Board.move.to = {x: x, y: 1, piece: Board.getSquare(x, 1)};
          piece.x = (evt.stageX / scale) + piece.offset.x;
          piece.y = 1800 + piece.offset.y;
        }
      }
      else if (8 < y) {
        if (1 > x) {
          Board.move.to = {x: 1, y: 8, piece: Board.getSquare(1, 8)};
          piece.x = 200 + piece.offset.x;
          piece.y = 1800 + piece.offset.y;
        }
        else if (8 < x) {
          Board.move.to = {x: 8, y: 8, piece: Board.getSquare(8, 8)};
          piece.x = 1800 + piece.offset.x;
          piece.y = 1800 + piece.offset.y;
        }
        else {
          Board.move.to = {x: x, y: 8, piece: Board.getSquare(x, 8)};
          piece.x = (evt.stageX / scale) + piece.offset.x;
          piece.y = 200 + piece.offset.y;
        }
      }
    }
    Board.update = true;
    Board.dragging = true;
  });

  piece.on("pressup", function (evt) {
    piece.x = Board.move.to.x * 200;
    piece.y = (9 - Board.move.to.y) * 200;
    piece.location = {x: Board.move.to.x, y: Board.move.to.y};
    Board.makeMove(Board.move, true);
    Board.update = true;
    Board.dragging = false;
  });

  return piece;
};

Board.prototype.makeMove = function (move, tween) {
  var Board = this;
  if (move.from.piece) {
    move.from.piece.location = {x: move.to.x, y: move.to.y};
    if (tween) {
      this.tweenToSquare(move.to.x, move.to.y, move.from.piece).call(function () {
        Board.setSquare(move.to.x, move.to.y, move.from.piece);
        Board.setSquare(move.from.x, move.from.y, false);
      });
    }
    else {
      this.setSquare(move.to.x, move.to.y, move.from.piece);
      this.setSquare(move.from.x, move.from.y, false);
    }
  }
};

Board.prototype.undoMove = function (move) {
  var Board = this;
  if (move.from.piece) {
    move.from.piece.location = {x: move.from.x, y: move.from.y};
    this.tweenToSquare(move.from.x, move.from.y, move.from.piece).call(function () {
      Board.setSquare(move.from.x, move.from.y, move.from.piece);
      Board.setSquare(move.to.x, move.to.y, false);
    });
  }
};

Board.prototype.tweenToSquare = function (x, y, piece, time) {
  var Board = this;
  if (!time) {
    time = 1000;
  }
  this.tween = true;
  return createjs.Tween.get(piece, {loop: false}).to({
    x: x * 200,
    y: (9 - y) * 200
  }, time).wait(100).call(function () {
    Board.tween = false;
  });
};

Board.prototype.makeBitmap = function (url) {
  var Board = this;
  image = new Image();
  image.src = url;

  if (this.loadedImages.indexOf(url) == -1) {
    image.onload = function () {
      Board.stage.update();
    };
    this.loadedImages.push(url);
  }
  return new createjs.Bitmap(image);
};

Board.prototype.tick = function (event) {
  var Board = this;
  if (this.update || this.tween) {
    this.update = false;
    this.stage.update(event);
  }
};

Board.prototype.onResize = function () {
  var Board = this;
  var w = window.innerWidth;
  var h = window.innerHeight - 120;

  var ow = 2000;
  var oh = 2000;

  scale = Math.min(w / ow, h / oh);
  this.stage.scaleX = scale;
  this.stage.scaleY = scale;

  this.stage.canvas.width = ow * scale;
  this.stage.canvas.height = oh * scale;

  this.stage.update();
};
