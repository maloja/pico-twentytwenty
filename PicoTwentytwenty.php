<?php
/**
 * PicoTwentytwenty
 * Add a Comparison Image Slider to pages
 * Edited January 2019 by maloja
 *
 * @author Maloja
 * @license http://opensource.org/licenses/MIT The MIT License
 * @link    https://github.com/maloja/pico-twentytwenty
 */
class PicoTwentytwenty extends AbstractPicoPlugin
{
    const API_VERSION = 2;
    protected $enabled = true;
    protected $dependsOn = array();

    /*
     * Internal Variables
     */
    private $twentytwenty_md_folder;
    private $twentytwenty_count = 0;
    private $p_keyword = 'imgcompare';

    /**
     * Register path relative to content without index and extension
     * var/html/content/foo/bar.md => foo/bar/
     */
    public function onRequestFile(&$file)
    {
        // get the path where the md file is
        $search_str = $_SERVER['DOCUMENT_ROOT'] . "/(.*/)" . ".*" . $this->getConfig('content_ext') . "$";
        $search_str = '/' . preg_replace('/\//', '\\/', $search_str) . '/';
        if (preg_match($search_str, $file, $matches)) $this->twentytwenty_md_folder = $matches[1];
    }

    /**
     * Replace (% imagecompare (img1.jpg, img2.jpg %) tags
     */
    public function onContentParsed(&$content) {
        $content = preg_replace_callback( '/<p>\s*\(%\s+' . $this->p_keyword  .'\s*\(\s*(.*?)\s*\)\s+%\)\s*<\/p>/', function($match) {
            $out = '';
            if ($match[1]) {
                $this->twentytwenty_count++;
                list ($img1, $img2) = explode(',', str_replace('"', '', $match[1]));
                $img1 = trim($img1);
                $img2 = trim($img2);
                $out  = "\n" . '<!-- PicoTwentytwenty -->' . "\n";
                $out .= '    <div class="pico-compare-wrapper">' . "\n";
                $out .= '        <div id="imgcompare' . $counter . '" class="twentytwenty-container">' . "\n";
                $out .= '            <img src="' . $img1 . '" />' . "\n";
                $out .= '            <img src="' . $img2 . '" />' . "\n";
                $out .= '        </div>' . "\n";
                $out .= '        <div class="pico-compare-zoom-icon">&nbsp;</div>' . "\n";
                $out .= '    </div>' . "\n";
                $out .= '<!-- End PicoTwentytwenty -->' . "\n";
            }
            return $out;
        }, $content);

        //add plugin initializing
        if ($this->twentytwenty_count > 0) {
            $content .= '<script src="' . $this->getConfig('plugins_url') . 'PicoTwentytwenty/vendor/twentytwenty/js/jquery.event.move.js"></script>' . "\n";
            $content .= '<script src="' . $this->getConfig('plugins_url') . 'PicoTwentytwenty/vendor/twentytwenty/js/jquery.twentytwenty.js"></script>' . "\n";
            $content .= file_get_contents($this->getConfig('plugins_url') . 'PicoTwentytwenty/assets/ptt-scripts.inc');
        }
    }

    /**
     * Triggered after Pico has rendered the page
     */
    public function onPageRendered(&$output ) {
        // add required javascripts in head tag
        if ($this->twentytwenty_count > 0) {
            $jsh  = '    <!-- PicoTwentytwenty Elements -->' . "\n";
            $jsh .= '     <link href="' . $this->getConfig('plugins_url') . 'PicoTwentytwenty/vendor/twentytwenty/css/twentytwenty.css" rel="stylesheet">' . "\n";
            $jsh .= '     <link href="' . $this->getConfig('plugins_url') . 'PicoTwentytwenty/assets/picotwentytwenty.css" rel="stylesheet">' . "\n";
            $jsh .= '</head>' . "\n" . '<body>' . "\n";
            $output = preg_replace('/\\<\\/head\\>\s*\n\s*\\<body\\>/', $jsh, $output, 1);
        }
    }
}

