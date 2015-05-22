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

CodingBeard.Chess.Board.prototype = {
  /**
   * @type CodingBeard.Chess.Canvas
   */
  canvas: false,

  /**
   * @type WebSocket
   */
  socket: false,

  /**
   * @type WebSocket
   */
  gameId: false,

  /**
   * @type {{1: {}, 2: {}, 3: {}, 4: {}, 5: {}, 6: {}, 7: {}, 8: {}}}
   */
  squares: {1: {}, 2: {}, 3: {}, 4: {}, 5: {}, 6: {}, 7: {}, 8: {}},

  /**
   * @type Array
   */
  history: [],

  /**
   * @type int
   */
  turn: 0,

  /**
   * @type {{from: {x: number, y: number, piece: createjs.Container}, to: {x: number, y: number, piece: createjs.Container}}}
   */
  move: {from: {x: 0, y: 0, piece: false}, to: {x: 0, y: 0, piece: false}},


  /**
   * Send a message to the server with our gameId
   * @param {{}} message
   */
  send: function (message) {
    message.params.gameId = this.gameId;
    this.socket.send(JSON.stringify(message));
  },

  /**
   * Draw the board, adding the background image and numbers/letters
   * @param x int
   * @param y int
   */
  drawBoard: function (x, y) {
    var icon;

    this.canvas.board = new createjs.Container();
    this.canvas.board.x = x;
    this.canvas.board.y = y;
    this.canvas.stage.addChild(this.canvas.board);

    this.canvas.board.addChild(this.canvas.makeBitmap("/img/chess/board.jpg"));
    this.canvas.board.addChild(this.canvas.pieces);
    this.canvas.board.addChild(this.canvas.highlights);

    for (var i = 1; i < 9; i += 1) {
      icon = this.canvas.makeBitmap("/img/chess/letters/" + i + ".png");
      icon.x = 200 * i;
      icon.alpha = 0.7;
      icon.shadow = new createjs.Shadow("#000000", 2, 2, 10);
      this.canvas.board.addChild(icon);

      icon = this.canvas.makeBitmap("/img/chess/letters/" + i + ".png");
      icon.x = 200 * i;
      icon.y = 1800;
      icon.alpha = 0.7;
      icon.shadow = new createjs.Shadow("#000000", 2, 2, 10);
      this.canvas.board.addChild(icon);

      icon = this.canvas.makeBitmap("/img/chess/numbers/" + (9 - i) + ".png");
      icon.y = 200 * i;
      icon.alpha = 0.7;
      icon.shadow = new createjs.Shadow("#000000", 2, 2, 10);
      this.canvas.board.addChild(icon);

      icon = this.canvas.makeBitmap("/img/chess/numbers/" + (9 - i) + ".png");
      icon.x = 1800;
      icon.y = 200 * i;
      icon.alpha = 0.7;
      icon.shadow = new createjs.Shadow("#000000", 2, 2, 10);
      this.canvas.board.addChild(icon);
    }

    this.canvas.update = true;
  },


  /**
   * Draw an alert box to keep the user aware of what's going on
   * @param options {{title: string, timeout: int, message: string, links: [{title: string, callback: function}]}}|bool
   */
  alert: function (options) {
    if (options.type == "modal") {
      $('.modal-header').html(options.title);

      if (options.message) {
        $('.modal-message').html(options.message);
      }
      else {
        $('.modal-message').empty();
      }
      if (options.links) {
        $('#alert-modal').openModal({dismissible: false});
      }
      else {
        $('#alert-modal').openModal({opacity: 0.1});
      }

      if (options.timeout) {
        setTimeout(function () {
          $('#alert-modal').closeModal();
        }, options.timeout);
      }
    }
    else if (options.type == "toast") {
      if (!options.timeout) {
        options.timeout = 2000;
      }
      toast(options.message, options.timeout, 'rounded');
    }
    if (options == false) {
      $('#alert-modal').closeModal();
    }
  },

  /**
   * Set pieces on the board
   * @param locations {{1: {1: [0, "Rook"]}, 2: {}, 3: {}, 4: {}, 5: {}, 6: {}, 7: {}, 8: {}}}
   */
  addPieces: function (locations) {
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
  },

  /**
   * Make a piece: Create a container adding in invisible background and a image of the piece.
   * Set events for hover, clicking, dragging with boundaries and updating the move that will be made as it's dragged
   * Make the move once user lets go of a piece.
   * @param definition [int, string]
   * @param x int
   * @param y int
   * @returns createjs.Container
   */
  makePiece: function (definition, x, y) {
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

    piece.on("rollover", $.proxy(function () {
      if (piece.definition[0] == this.turn) {
        this.send({action: "getMoves", params: {location: {x: piece.location.x, y: piece.location.y}}});
      }
    }, this));

    piece.on("rollout", $.proxy(function () {
      this.highlightSquares([]);
    }, this));

    piece.on("mousedown", $.proxy(function (evt) {
      piece.offset = {x: piece.x - (evt.stageX / scale), y: piece.y - (evt.stageY / scale)};
      this.move.from = {x: piece.location.x, y: piece.location.y, piece: piece};
      this.move.to = {x: piece.location.x, y: piece.location.y, piece: piece};
    }, this));

    piece.on("pressmove", $.proxy(function (evt) {
      var x = Math.floor(((evt.stageX / scale) - this.canvas.board.x) / 200);
      var y = Math.floor((2000 - ((evt.stageY / scale) - this.canvas.board.y)) / 200);

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
  },

  /**
   * Get the piece/false in a square at location xy
   * @param x int
   * @param y int
   */
  getSquare: function (x, y) {
    if (this.squares[x][y].getChildAt(0)) {
      return this.squares[x][y].getChildAt(0);
    }
  },

  /**
   * Highlight the moves available to a piece on click
   * @param locations array
   */
  highlightSquares: function (locations) {
    this.canvas.highlights.removeAllChildren();
    $.each(locations, $.proxy(function (k, location) {
      var highlight = new createjs.Graphics().beginFill("#fff").drawRect(location.x * 200, (9 - location.y) * 200, 200, 200);
      this.canvas.highlights.addChild(new createjs.Shape()).set({graphics: highlight, alpha: 0.5});
    }, this));
  },

  /**
   * Set the square at location xy with a piece or false
   * @param x int
   * @param y int
   * @param piece createjs.Container|bool
   */
  setSquare: function (x, y, piece) {
    if (this.squares[x][y]) {
      this.squares[x][y].removeAllChildren();
      if (piece) {
        this.squares[x][y].addChild(piece);
      }
    }
  },

  /**
   * Make a move on the board, optionally tween the piece
   * @param move {{from: {x: number, y: number, piece: createjs.Container}, to: {x: number, y: number, piece: createjs.Container}}}
   * @param tween bool
   * @param computer bool
   */
  makeMove: function (move, tween, computer) {
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
      this.history.push(move);

      if (!computer) {
        var toPiece;
        if (move.to.piece) {
          toPiece = move.to.piece.definition;
        }
        else {
          toPiece = false;
        }
        this.send({
          action: "checkMove", params: {
            move: {
              from: {x: move.from.x, y: move.from.y, piece: move.from.piece.definition},
              to: {x: move.to.x, y: move.to.y, piece: toPiece}
            }
          }
        });
      }
    }
  },

  /**
   * Undo a move on the board
   * @param move {{from: {x: number, y: number, piece: createjs.Container}, to: {x: number, y: number, piece: createjs.Container}}}
   */
  undoMove: function (move) {
    console.log(move.from.x, move.from.y, "<-", move.to.x, move.to.y);
    if (move.from.piece) {
      move.from.piece.location = {x: move.from.x, y: move.from.y};
      this.canvas.tweenToLocation(move.from.x * 200, (9 - move.from.y) * 200, move.from.piece, 500)
        .call($.proxy(function () {
          this.setSquare(move.from.x, move.from.y, move.from.piece);
          this.setSquare(move.to.x, move.to.y, move.to.piece);
          this.canvas.update = true;
        }, this));
    }
  },

  /**
   * Undo an invalid move on the board
   */
  invalidMove: function () {
    var lastMove = this.history[this.history.length - 1];

    if (lastMove) {
      this.undoMove(lastMove);
    }
  }
};