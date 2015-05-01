/**
 * Move
 *
 * @category 
 * @package 
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */

namespace CodingBeard\Chess\Board;

class Move
{
    /**
    * @var \CodingBeard\Chess\Board\Square
    */
    public from {
        get
    };

    /**
    * @var \CodingBeard\Chess\Board\Square
    */
    public to {
        get
    };

    /**
    * @var bool
    */
    public noClip = false {
        get, set
    };

    /**
    * @var bool
    */
    public obstacle = false {
        get, set
    };

    /**
    * Constructor
    * @param \CodingBeard\Chess\Board\Move from
    * @param \CodingBeard\Chess\Board\Move to
    */
    public function __construct(const <\CodingBeard\Chess\Board\Square> from = null, <\CodingBeard\Chess\Board\Square>
     to = null)
    {
        if from {
            let this->from = from;
            if from->getPiece() {
                if from->getPiece()->getType() == "Knight" {
                    let this->noClip = true;
                }
            }
        }
        if to {
            let this->to = to;
            if to->getPiece() && !this->noClip {
                let this->obstacle = true;
            }
        }
    }

    /**
    * @param \CodingBeard\Chess\Board\Move from
    */
    public function setFrom(const <\CodingBeard\Chess\Board\Square> from)
    {
        if from->getPiece() {
            if from->getPiece()->getType() == "Knight" {
                let this->noClip = true;
            }
        }
        let this->from = from;
    }

    /**
    * @param \CodingBeard\Chess\Board\Move to
    */
    public function setTo(const <\CodingBeard\Chess\Board\Square> to)
    {
        if !this->obstacle {
            if to->getPiece() && !this->noClip {
                let this->obstacle = true;
            }
            let this->to = to;
        }
    }

}