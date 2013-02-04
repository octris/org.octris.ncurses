<?php

/*
 * This file is part of the 'org.octris.ncurses' package.
 *
 * (c) Harald Lapp <harald@octris.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace org\octris\ncurses\component {
    /**
     * Button component.
     *
     * @octdoc      c:component/button
     * @copyright   copyright (c) 2013 by Harald Lapp
     * @author      Harald Lapp <harald@octris.org>
     */
    class button extends \org\octris\ncurses\component
    /**/
    {
        /**
         * X position of button.
         * 
         * @octdoc  p:button/$x
         * @var     int
         */
        protected $x;
        /**/

        /**
         * Y position of button.
         * 
         * @octdoc  p:button/$y
         * @var     int
         */
        protected $y;
        /**/

        /**
         * Text of button.
         * 
         * @octdoc  p:button/$text
         * @var     string
         */
        protected $text;
        /**/

        /**
         * Constructor.
         *
         * @octdoc  m:button/__construct
         * @param   int                             $x              X position of button.
         * @param   int                             $y              Y position of button.
         * @param   string                          $text           button text to display.
         */
        public function __construct($x, $y, $text)
        /**/
        {
            $this->x    = $x;
            $this->y    = $y;
            $this->text = $text;
        }

        /**
         * Get Focus.
         *
         * @octdoc  m:button/onFocus
         */
        public function onFocus()
        /**/
        {
            $res = $this->parent->getResource();

            ncurses_wattron($res, NCURSES_A_REVERSE);

            $this->build();
            
            ncurses_wattroff($res, NCURSES_A_REVERSE);
        }

        /**
         * Lose focus.
         *
         * @octdoc  m:button/onBlur
         */
        public function onBlur()
        /**/
        {
            $this->build();
        }

        /**
         * Get's called when ENTER key is pressed on a button.
         *
         * @octdoc  m:button/onAction
         */
        public function onAction()
        /**/
        {
            $this->propagateEvent('action');
        }

        /**
         * Trigger action if ENTER key is pressed.
         *
         * @octdoc  m:button/onKeypress
         * @param   int                 $key            Code of the key that was pressed.
         */
        public function onKeypress($key_code)
        /**/
        {
            if ($key_code == NCURSES_KEY_CR) {
                $this->onAction();
            }
        }

        /**
         * Render button.
         *
         * @octdoc  m:button/render
         */
        public function build()
        /**/
        {
            ncurses_mvwaddstr(
                $this->parent->getResource(), 
                $this->y, 
                $this->x, 
                '<' . $this->text . '>'
            );
        }
    }
}