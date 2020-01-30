<?php
/**
 * PicoTwentytwenty
 * Add a Comparison Image Slider to pages
 * Edited January 2019 by maloja
 *
 * @author Maloja
 * @license http://opensource.org/licenses/MIT The MIT License
 * @link    https://github.com/maloja/pico-twentytwenty
 * @version 1
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
    private $plugin_path = '/plugins/PicoTwentytwenty';
    private $twentytwenty_found = false;

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
        $counter = 0;
        $content = preg_replace_callback( '/\\<p\\>\s*\(\%\s*imgcompare\s*\(\s*(.*?)\s*,\s*(.*?)\s*\).s*\%\)\s*\\<\\/p\\>/', function ($match) use (&$counter) {
            $counter++;
            $this->twentytwenty_found = true;
            $url1 = $this->prepareImagePath($match[1]);
            $url2 = $this->prepareImagePath($match[2]);
            $out  = "\n" . '<!-- PicoTwentytwenty -->' . "\n";
            $out .= '    <div class="pico-compare-wrapper">' . "\n";
            $out .= '        <div id="imgcompare' . $counter . '" class="twentytwenty-container">' . "\n";
            $out .= '            <img src="' . $url1 . '" />' . "\n";
            $out .= '            <img src="' . $url2 . '" />' . "\n";
            $out .= '        </div>' . "\n";
            $out .= '        <div class="pico-compare-zoom-icon">&nbsp;</div>' . "\n";
            $out .= '    </div>' . "\n";
            $out .= '<!-- End PicoTwentytwenty -->' . "\n";
            return $out;
        }, $content);

        //add plugin initializing
        if ($this->twentytwenty_found) {
            $content .= '    <script src="' . $this->plugin_path . '/vendor/twentytwenty/js/jquery.event.move.js"></script>' . "\n";
            $content .= '    <script src="' . $this->plugin_path . '/vendor/twentytwenty/js/jquery.twentytwenty.js"></script>' . "\n";
            $content .= file_get_contents($_SERVER['DOCUMENT_ROOT'] . $this->plugin_path . '/assets/ptt-scripts.inc');
        }
    }

    /**
     * Triggered after Pico has rendered the page
     */
    public function onPageRendered(&$output ) {
        // add required javascripts in head tag
        if ($this->twentytwenty_found) {
            $jsh  = '    <!-- PicoTwentytwenty Elements -->' . "\n";
            $jsh .= '     <link href="' . $this->plugin_path . '/vendor/twentytwenty/css/twentytwenty.css" rel="stylesheet">' . "\n";
            $jsh .= '     <link href="' . $this->plugin_path . '/assets/picotwentytwenty.css" rel="stylesheet">' . "\n";
            $jsh .= '</head>' . "\n" . '<body>' . "\n";
            $output = preg_replace('/\\<\\/head\\>\s*\n\s*\\<body\\>/', $jsh, $output, 1);
        }
    }

   /**
    * INTERNAL FUNCTIONS
    *
    */
    private function prepareImagePath(&$img) {
        if (preg_match('/^http(s)?\:\\/\\//', $img)) return $img;
        if (preg_match('/^\\//', $img)) return $this->getConfig('base_url') . $img;
        //ok, so nothing above matches
        return $this->getConfig('base_url') . $this->twentytwenty_md_folder . $img;
    }
}

