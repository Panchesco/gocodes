<?php
/**
 * Gocodes Class
 *
 * @package ExpressionEngine
 * @author Richard Whitmer/Godat Design
 * @copyright (c) 2016, Richard Whitmer
 * @license
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * @link https://github.com/panchesco
 * @since Version 3.4.4
 */
// ------------------------------------------------------------------------

/**
 * EE3 Gocodes plugin
 *
 * @package		ExpressionEngine
 * @subpackage		user
 * @category		Plugin
 * @author		Richard Whitmer
 * @link			https://github.com/panchesco/gocodes
 */
// ------------------------------------------------------------------------
class Gocodes

  {
    public function templates()

      {
	      
        // Set tagdata to variable.
        $tagdata = ee()->TMPL->tagdata;
	      
        // Fetch params.
        $template_group = ee()->TMPL->fetch_param('template_group', 'shortcodes');
        $template_type = ee()->TMPL->fetch_param('template_type', 'html');
        
        // Confirm the template type is something we want to work with.
        if(in_array($template_type,array('html','feed','css','js','xml'))) 
        {
	        $template_type = '.'.$template_type;
        } else {
	        return $tagdata;
        }

        // Determine the template group exists.
        if (file_exists(SYSPATH . 'user/templates/default_site/' . $template_group . '.group') === FALSE)
          {
            return $tagdata;
          }
        // Set array to hold shorcode matches.
        $matches = array();
        // Look for shortcode.
        preg_match_all("/\[[[:alnum:]-_]+\]/", $tagdata, $matches);
        // If shortcodes found, handle.
        // If not, return tagdata.
        if (isset($matches[0][0]))
          {
            foreach($matches[0] as $shortcode)
              {
                // Strip brackets to get the shortcode name.
                $template = str_replace(array(
                    '[',
                    ']'
                ) , '', $shortcode);
                $path = $this->template_path($template_group, $template, $template_type);
                // Get the file contents.
                $template_string = $this->get_shortcode_template($path);
                $tagdata = str_replace($shortcode, $template_string, $tagdata);
              }
          }
        return $tagdata;
      }
      
    //-----------------------------------------------------------------------------
    
    /**
     * Return the path to the template we need.
     * @param $template_group string
     * @param $template string
     * @return string
     */
    private function template_path($template_group, $template, $template_type)
      {
        $path = SYSPATH . 'user/templates/default_site/';
        $path.= $template_group . '.group/';
        $path.= $template . $template_type;
        return $path;
      }
      
    //-----------------------------------------------------------------------------
    
    /**
     * Return the file contents of template
     * @param $template_path string
     * @return string
     */
    private function get_shortcode_template($template_path)
      {
        if (file_exists($template_path))
          {
            return file_get_contents($template_path);
          }
        else
          {
            return '';
          }
      }
  }
// End class Gocodes
