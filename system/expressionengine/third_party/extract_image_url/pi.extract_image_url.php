<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * A really simple plugin that'll grab an image URL from a chunk of markup. Great when paired with CE Image for automatically generating feed thumbnails.
 *
 * @author    Matt Stein <matt@workingconcept.com>
 * @copyright Copyright (c) 2013 Working Concept Inc
 */

$plugin_info = array(
						'pi_name'        => 'Extract Image URL',
						'pi_version'     => '1.0',
						'pi_author'      => 'Matt Stein',
						'pi_author_url'  => 'http://workingconcept.com',
						'pi_description' => 'Get the URL of the first image in a chunk of HTML, if it exists.',
						'pi_usage'       =>  Extract_image_url::usage()
					);


class Extract_image_url
{
	public $return_data = "";


	/**
	 * Ye olde constructor
	 */
	
	public function __construct()
	{
	    $this->EE =& get_instance();
	    $this->Extract_image_url();
	}


	/**
	 * The only meat on this bone; checks parameters and returns an image URL if it exists.
	 * 
	 * @param  string $str
	 * @return string
	 */
	
	public function Extract_image_url($str = "")
	{
		$data       = "";
		$occurrence = $this->EE->TMPL->fetch_param('occurrence') ? $this->EE->TMPL->fetch_param('occurrence') : 1;
		$default    = $this->EE->TMPL->fetch_param('default') ? $this->EE->TMPL->fetch_param('default') : "";

		if (empty($str)) $str = $this->EE->TMPL->tagdata;

		preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $str, $matches);

		if ( ! empty($matches))
		{
			$data = $matches[intval($occurrence)];
		}
		else
		{
			$data = $default;
		}

		$this->return_data = $data;
	}


	/**
	 * Usage
	 *
	 * This function describes how the plugin is used.
	 *
	 * @access	public
	 * @return	string
	 */
	
	public function usage()
	{
		ob_start();
?>
This plugin is simple to use:

{exp:extract_image_url}
<p>Whatever is your source for the URL. Maybe it's a paragraph with <img src="/assets/foo.jpg" /> images, even more than one. <img src="/assets/foo2.jpg" /></p>
{/exp:extract_image_url}

Example in an EE entries tag:
--
{exp:weblog:entries weblog="main" limit="5" rdf="off"}
{if '{exp:extract_image_url str="{post_body}" != ''}<img src="{exp:extract_image_url}{post_body}{/exp:extract_image_url}" /><br/>{/if}{title}
{/exp:weblog:entries}
--

<?php
		$buffer = ob_get_contents();

		ob_end_clean();

		return $buffer;
	}
}

/* End of file pi.extract_image_url.php */
/* Location: ./system/expressionengine/third_party/extract_image_url/pi.extract_image_url.php */