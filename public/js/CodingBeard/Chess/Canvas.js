/**
 * Canvas
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
 * Set up a canvas on an ID, make it responsive, enable mouse events, set up a ticker
 * @param canvasId string
 * @constructor
 */
CodingBeard.Chess.Canvas = function (canvasId) {
  this.canvas = document.getElementById(canvasId);
  this.stage = new createjs.Stage(this.canvas);
  this.pieces = new createjs.Container();

  this.onResize();
  window.onresize = $.proxy(function () {
    this.onResize();
  }, this);

  this.stage.enableMouseOver(10);
  this.stage.mouseMoveOutside = true;
  createjs.Ticker.setFPS(20);
  createjs.Ticker.addEventListener("tick", $.proxy(function (event) {
    if (this.update || this.tween) {
      this.update = false;
      this.stage.update(event);
    }
  }, this));
};

/**
 * Element of our canvas
 * @type Element
 */
CodingBeard.Chess.Canvas.prototype.canvas = false;

/**
 * Our main stage
 * @type createjs.Stage
 */
CodingBeard.Chess.Canvas.prototype.stage = false;

/**
 * Container for all of the pieces
 * @type createjs.Container
 */
CodingBeard.Chess.Canvas.prototype.pieces = false;

/**
 * Whether to update the stage on the next tick
 * @type bool
 */
CodingBeard.Chess.Canvas.prototype.update = false;

/**
 * Whether we're currently tweening a piece
 * @type bool
 */
CodingBeard.Chess.Canvas.prototype.tween = false;

/**
 * Urls of all the images we've loaded in the dom
 * @type Array
 */
CodingBeard.Chess.Canvas.prototype.loadedImages = [];


/**
 * Make the stage responsive
 */
CodingBeard.Chess.Canvas.prototype.onResize = function () {
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

/**
 * Tween a container to a xy location (pixels)
 * @param x int
 * @param y int
 * @param piece createjs.Container
 * @param time int
 */
CodingBeard.Chess.Canvas.prototype.tweenToLocation = function (x, y, piece, time) {
  if (!time) {
    time = 1000;
  }
  this.tween = true;
  return createjs.Tween.get(piece, {loop: false}).to({
    x: x,
    y: y
  }, time).wait(100).call($.proxy(function () {
    this.tween = false;
  }, this));
};

/**
 * Create a bitmap object, and update the stage once the image has been loaded
 * @param url
 * @returns createjs.Bitmap
 */
CodingBeard.Chess.Canvas.prototype.makeBitmap = function (url) {
  image = new Image();
  image.src = url;

  if (this.loadedImages.indexOf(url) == -1) {
    image.onload = $.proxy(function () {
      this.update = true;
    }, this);
    this.loadedImages.push(url);
  }
  return new createjs.Bitmap(image);
};

/**
 * Make an image inside a container 'pop' when hovered over
 * getImage should return the image from the container
 * @param piece createjs.Container
 * @param getImage Closure
 */
CodingBeard.Chess.Canvas.prototype.popOnHover = function (piece, getImage) {
  piece.on("rollover", $.proxy(function (evt) {
    var image = getImage(piece);
    if (image) {
      piece.cursor = "pointer";
      image.x = image.x - 20;
      image.y = image.y - 20;
      image.scaleX = image.scaleY = 1.2;
      this.update = true;
    }
  }, this));

  piece.on("rollout", $.proxy(function (evt) {
    var image = getImage(piece);
    if (image) {
      piece.cursor = "";
      image.x = image.x + 20;
      image.y = image.y + 20;
      image.scaleX = image.scaleY = 1;
      this.update = true;
    }
  }, this));
};