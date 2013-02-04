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
     * Floating text widget.
     *
     * @octdoc      c:component/text
     * @copyright   copyright (c) 2013 by Harald Lapp
     * @author      Harald Lapp <harald@octris.org>
     */
    class text extends \org\octris\ncurses\component
    /**/
    {
        /**
         * Text alignment.
         *
         * @octdoc  d:text/T_...
         */
        const T_ALIGN_LEFT    = STR_PAD_RIGHT;
        const T_ALIGN_RIGHT   = STR_PAD_LEFT;
        const T_ALIGN_CENTER  = STR_PAD_BOTH;
        const T_ALIGN_JUSTIFY = 3;
        /**/

        /**
         * Text.
         * 
         * @octdoc  p:text/$text
         * @var     string
         */
        protected $text;
        /**/

        /**
         * Text alignment.
         *
         * @octdoc  p:text/$align
         * @var     int
         */
        protected $align;
        /**/

        /**
         * Vertical margin.
         *
         * @octdoc  p:text/$v_margin
         * @var     int
         */
        protected $v_margin;
        /**/

        /**
         * Horizontal margin.
         *
         * @octdoc  p:text/$h_margin
         * @var     int
         */
        protected $h_margin;
        /**/

        /**
         * Text component cannot take the focus.
         *
         * @octdoc  p:text/$focusable
         * @var     bool
         */
        protected $focusable = false;
        /**/

        /**
         * Constructor.
         *
         * @octdoc  m:text/__construct
         * @param   string                          $text           Text to display.
         * @param   int                             $align          Optional text alignment.
         * @param   int                             $v_margin       Optional vertical margin of text to container border.
         * @param   int                             $h_margin       Optional horizontal margin of text to container border.
         */
        public function __construct($text, $align = self::T_ALIGN_LEFT, $v_margin = 0, $h_margin = null)
        /**/
        {
            $this->text     = $text;
            $this->align    = $align;
            $this->v_margin = $v_margin;
            $this->h_margin = (is_null($h_margin) ? $v_margin * 2 : $h_margin);
        }

        /**
         * Render text.
         *
         * @octdoc  m:text/render
         */
        public function build()
        /**/
        {
            $size = $this->parent->getInnerSize();

            // text formatting
            $width = $size->width - 2 * $this->h_margin;
            $rows  = explode("\n", wordwrap($this->text, $width));

            if ($this->align != self::T_ALIGN_JUSTIFY) {
                array_walk($rows, function(&$row) use ($width, $size) {
                    $row = str_pad(trim($row), $width, ' ', $this->align);
                    $row = str_pad($row, $size->width, ' ', STR_PAD_BOTH);
                });

                $text = implode("", $rows);
            } else {
                // TODO: justify
                $text = implode("", $rows);
            }

            // output
            ncurses_mvwaddstr(
                $this->parent->getResource(), 
                $this->v_margin, 
                0, 
                $text
            );
        }
    }
}