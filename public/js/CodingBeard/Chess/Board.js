/**
 * Board
 *
 * @category
 * @package Chess
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */
var CodingBeard = CodingBeard || {};
CodingBeard.Chess = CodingBeard.Chess || {};

/**
 * @param canvas CodingBeard.Chess.Canvas
 * @constructor
 */
CodingBeard.Chess.Board = function (canvas) {
  this.canvas = canvas;
};

/**
 * @type CodingBeard.Chess.Canvas
 */
CodingBeard.Chess.Board.prototype.canvas;

/**
 * @type {{1: {}, 2: {}, 3: {}, 4: {}, 5: {}, 6: {}, 7: {}, 8: {}}}
 */
CodingBeard.Chess.Board.prototype.squares = {1: {}, 2: {}, 3: {}, 4: {}, 5: {}, 6: {}, 7: {}, 8: {}};

/**
 * @type Array
 */
CodingBeard.Chess.Board.prototype.history = [];

/**
 * @type int
 */
CodingBeard.Chess.Board.prototype.turn = 0;

/**
 * @type {{from: {x: number, y: number, piece: createjs.Container}, to: {x: number, y: number, piece: createjs.Container}}}
 */
CodingBeard.Chess.Board.prototype.move = {from: {x: 0, y: 0, piece: false}, to: {x: 0, y: 0, piece: false}};


/**
 * Draw the board, adding the background image and numbers/letters
 */
CodingBeard.Chess.Board.prototype.drawBoard = function () {
  var icon;
  this.canvas.stage.addChild(this.canvas.makeBitmap("/img/chess/board.jpg"));
  this.canvas.stage.addChild(this.canvas.pieces);

  for (var i = 1; i < 9; i += 1) {
    icon = this.canvas.makeBitmap("/img/chess/letters/" + i + ".png");
    icon.x = 200 * i;
    icon.alpha = 0.7;
    icon.shadow = new createjs.Shadow("#000000", 2, 2, 10);
    this.canvas.stage.addChild(icon);

    icon = this.canvas.makeBitmap("/img/chess/letters/" + i + ".png");
    icon.x = 200 * i;
    icon.y = 1800;
    icon.alpha = 0.7;
    icon.shadow = new createjs.Shadow("#000000", 2, 2, 10);
    this.canvas.stage.addChild(icon);

    icon = this.canvas.makeBitmap("/img/chess/numbers/" + (9 - i) + ".png");
    icon.y = 200 * i;
    icon.alpha = 0.7;
    icon.shadow = new createjs.Shadow("#000000", 2, 2, 10);
    this.canvas.stage.addChild(icon);

    icon = this.canvas.makeBitmap("/img/chess/numbers/" + (9 - i) + ".png");
    icon.x = 1800;
    icon.y = 200 * i;
    icon.alpha = 0.7;
    icon.shadow = new createjs.Shadow("#000000", 2, 2, 10);
    this.canvas.stage.addChild(icon);
  }

  this.canvas.update = true;
};

/**
 * Set pieces on the board
 * @param locations {{1: {1: [0, "Rook"]}, 2: {}, 3: {}, 4: {}, 5: {}, 6: {}, 7: {}, 8: {}}}
 */
CodingBeard.Chess.Board.prototype.addPieces = function (locations) {
  this.canvas.pieces.removeAllChildren();
  for (var x = 1; x < 9; x += 1) {
    for (var y = 1; y < 9; y += 1) {
      square = new createjs.Container();
      this.squares[x][y] = square;
      this.canvas.pieces.addChild(square);

      if (locations[x - 1][y - 1]) {
        this.setSquare(x, y, this.makePiece(locations[x - 1][y - 1], x, y));
      }
      else {
        this.setSquare(x, y, false);
      }
    }
  }
  this.canvas.update = true;
};

/**
 * Make a piece: Create a container adding in invisible background and a image of the piece.
 * Set events for hover, clicking, dragging with boundaries and updating the move that will be made as it's dragged
 * Make the move once user lets go of a piece.
 * @param definition [int, string]
 * @param x int
 * @param y int
 * @returns createjs.Container
 */
CodingBeard.Chess.Board.prototype.makePiece = function (definition, x, y) {
  var piece = new createjs.Container();
  piece.definition = definition;
  piece.location = {x: x, y: y};
  piece.x = x * 200;
  piece.y = (9 - y) * 200;
  var rectangle = new createjs.Graphics().beginFill("#fff").drawRect(0, 0, 200, 200);
  piece.addChild(new createjs.Shape()).set({graphics: rectangle, alpha: 0.01});

  var image;
  if (definition[0] == 0) {
    image = this.canvas.makeBitmap("/img/chess/pieces/white/" + definition[1] + ".png");
    image.shadow = new createjs.Shadow("#000", 1, 1, 20);
  }
  else {
    image = this.canvas.makeBitmap("/img/chess/pieces/black/" + definition[1] + ".png");
    image.shadow = new createjs.Shadow("#000", 1, 1, 2);
  }
  piece.addChild(image);

  this.canvas.popOnHover(piece, function (piece) {
    return piece.getChildAt(1);
  });

  piece.on("mousedown", $.proxy(function (evt) {
    piece.offset = {x: piece.x - (evt.stageX / scale), y: piece.y - (evt.stageY / scale)};
    this.move.from = {x: piece.location.x, y: piece.location.y, piece: piece};
    this.move.to = {x: piece.location.x, y: piece.location.y, piece: piece};
  }, this));

  piece.on("pressmove", $.proxy(function (evt) {
    var x = Math.floor(((evt.stageX / scale)) / 200);
    var y = Math.floor((2000 - ((evt.stageY / scale))) / 200);

    if (0 < x && x < 9 && 0 < y && y < 9) {
      this.move.to = {x: x, y: y, piece: this.getSquare(x, y)};
      piece.x = (evt.stageX / scale) + piece.offset.x;
      piece.y = (evt.stageY / scale) + piece.offset.y;
    }
    else {
      if (1 > x) {
        if (1 > y) {
          this.move.to = {x: 1, y: 1, piece: this.getSquare(1, 1)};
          piece.x = 200 + piece.offset.x;
          piece.y = 1800 + piece.offset.y;
        }
        else if (8 < y) {
          this.move.to = {x: 1, y: 8, piece: this.getSquare(1, 8)};
          piece.x = 200 + piece.offset.x;
          piece.y = 200 + piece.offset.y;
        }
        else {
          this.move.to = {x: 1, y: y, piece: this.getSquare(1, y)};
          piece.x = 200 + piece.offset.x;
          piece.y = (evt.stageY / scale) + piece.offset.y;
        }
      }
      else if (8 < x) {
        if (1 > y) {
          this.move.to = {x: 8, y: 1, piece: this.getSquare(8, 1)};
          piece.x = 1800 + piece.offset.x;
          piece.y = 1800 + piece.offset.y;
        }
        else if (8 < y) {
          this.move.to = {x: 8, y: 8, piece: this.getSquare(8, 8)};
          piece.x = 1800 + piece.offset.x;
          piece.y = 200 + piece.offset.y;
        }
        else {
          this.move.to = {x: 8, y: y, piece: this.getSquare(8, y)};
          piece.x = 1800 + piece.offset.x;
          piece.y = (evt.stageY / scale) + piece.offset.y;
        }
      }
      else if (1 > y) {
        if (1 > x) {
          this.move.to = {x: 1, y: 1, piece: this.getSquare(1, 1)};
          piece.x = 200 + piece.offset.x;
          piece.y = 1800 + piece.offset.y;
        }
        else if (8 < x) {
          this.move.to = {x: 8, y: 1, piece: this.getSquare(8, 1)};
          piece.x = 1800 + piece.offset.x;
          piece.y = 200 + piece.offset.y;
        }
        else {
          this.move.to = {x: x, y: 1, piece: this.getSquare(x, 1)};
          piece.x = (evt.stageX / scale) + piece.offset.x;
          piece.y = 1800 + piece.offset.y;
        }
      }
      else if (8 < y) {
        if (1 > x) {
          this.move.to = {x: 1, y: 8, piece: this.getSquare(1, 8)};
          piece.x = 200 + piece.offset.x;
          piece.y = 1800 + piece.offset.y;
        }
        else if (8 < x) {
          this.move.to = {x: 8, y: 8, piece: this.getSquare(8, 8)};
          piece.x = 1800 + piece.offset.x;
          piece.y = 1800 + piece.offset.y;
        }
        else {
          this.move.to = {x: x, y: 8, piece: this.getSquare(x, 8)};
          piece.x = (evt.stageX / scale) + piece.offset.x;
          piece.y = 200 + piece.offset.y;
        }
      }
    }
    this.canvas.update = true;
  }, this));

  piece.on("pressup", $.proxy(function (evt) {
    piece.x = this.move.to.x * 200;
    piece.y = (9 - this.move.to.y) * 200;
    if (piece.location.x != this.move.to.x || piece.location.y != this.move.to.y) {
      piece.location = {x: this.move.to.x, y: this.move.to.y};
      this.makeMove(this.move);
    }
    this.canvas.update = true;
  }, this));

  return piece;
};

/**
 * Get the piece/false in a square at location xy
 * @param x int
 * @param y int
 */
CodingBeard.Chess.Board.prototype.getSquare = function (x, y) {
  if (this.squares[x][y].getChildAt(0)) {
    return this.squares[x][y].getChildAt(0);
  }
};

/**
 * Set the square at location xy with a piece or false
 * @param x int
 * @param y int
 * @param piece createjs.Container|bool
 */
CodingBeard.Chess.Board.prototype.setSquare = function (x, y, piece) {
  if (this.squares[x][y]) {
    this.squares[x][y].removeAllChildren();
    if (piece) {
      this.squares[x][y].addChild(piece);
    }
  }
};

/**
 * Make a move on the board, optionally tween the piece
 * @param move {{from: {x: number, y: number, piece: createjs.Container}, to: {x: number, y: number, piece: createjs.Container}}}
 * @param tween bool
 */
CodingBeard.Chess.Board.prototype.makeMove = function (move, tween) {
  console.log(move.from.x, move.from.y, "->", move.to.x, move.to.y);
  if (move.from.piece) {
    move.from.piece.location = {x: move.to.x, y: move.to.y};
    if (tween) {
      this.canvas.tweenToLocation(move.to.x * 200, (9 - move.to.y) * 200, move.from.piece)
        .call($.proxy(function () {
          this.setSquare(move.to.x, move.to.y, move.from.piece);
          this.setSquare(move.from.x, move.from.y, false);
        }, this));
    }
    else {
      this.setSquare(move.to.x, move.to.y, move.from.piece);
      this.setSquare(move.from.x, move.from.y, false);
    }
  }
};

/**
 * Undo a move on the board
 * @param move {{from: {x: number, y: number, piece: createjs.Container}, to: {x: number, y: number, piece: createjs.Container}}}
 */
CodingBeard.Chess.Board.prototype.undoMove = function (move) {
  var Board = this;
  if (move.from.piece) {
    move.from.piece.location = {x: move.from.x, y: move.from.y};
    this.canvas.tweenToLocation(move.from.x, move.from.y, move.from.piece)
      .call($.proxy(function () {
        this.setSquare(move.from.x, move.from.y, move.from.piece);
        this.setSquare(move.to.x, move.to.y, false);
      }, this));
  }
};
