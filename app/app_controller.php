<?php
class AppController extends Controller
{
    public $default_view_class = 'AppLayoutView';

    function beforeFilter()
	{
		$exclude = array(
		'user/register',
		'user/login');

		if (in_array(Param::get(DC_ACTION), $exclude)) {
			return;
		}
		if (!isset($_SESSION['id'])) {
			header('Location: /user/login');
		}
	}
}
