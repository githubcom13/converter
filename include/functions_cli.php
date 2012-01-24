<?php

/**
 * Command line based converter functions
 *
 * @copyright (C) 2012 FluxBB (http://fluxbb.org)
 * @license GPL - GNU General Public License (http://www.gnu.org/licenses/gpl.html)
 * @package FluxBB
 */

/**
 * Shows an info about current running conversion process
 */
function conv_message()
{
	global $lang_convert;

	$args = func_get_args();

	// Do not show proccessing rows range
	if (count($args) && $args[0] == 'Processing range')
		$args[0] = 'Processing num';

	// Translate message
	if (count($args) && isset($lang_convert[$args[0]]))
		$args[0] = $lang_convert[$args[0]];

	$message = count($args) > 0 ? array_shift($args) : '';

	$output = vsprintf($message, $args);
	echo $output."\n";
	conv_log($output);
}

/**
 * Shows an error
 */
function conv_error($message, $file = null, $line = null, $dberror = false)
{
	global $fluxbb, $forum, $lang_convert;

	if (isset($fluxbb))
		$fluxbb->close_database();
	if (isset($forum))
		$forum->close_database();

	conv_log('Error: '.$message.' in '.$line.', '.$line.(is_array($dberror) ? "\n".implode(', ', $dberror) : ''), false, true);

	if (isset($lang_convert[$message]))
		$message = $lang_convert[$message];

	echo sprintf($lang_convert['Error'], $message).(defined('PUN_DEBUG') && isset($file) ? sprintf($lang_convert['Error file line'], $file, $line) : '')."\n";
	if (defined('PUN_DEBUG') && $dberror !== false)
		echo sprintf($lang_convert['Database reported'], $dberror['error_msg'])."\n";
	exit(0);
}


/**
 * Redirect to the next stage
 */
function conv_redirect($step, $start_at = 0, $time = 0)
{
	return false;
}
